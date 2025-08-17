<?php

namespace App\Http\Controllers;

use App\Models\Assure;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Exports\AssuresExport;
use App\Imports\AssuresImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;


/**
 * Import des assurés depuis un fichier Excel
 */

class AssureController extends Controller
{

public function import(Request $request) 
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,xls,csv|max:10240',    
        ]);
       $userId = Auth::id();

    // Recherche du client lié à cet utilisateur
    $client = Client::where('user_id', $userId)->firstOrFail();
     $clientAccessToken = $client->access_token;

    // On a maintenant le client_id
    $clientId = $client->id;
        $file = $request->file('fichier');
        $client = Client::findOrFail($client->$clientId);
     $entrepriseName = preg_replace('/\s+/', '_', strtolower($client->nom));

    // Fichier uploadé
    $file = $request->file('fichier');
    $extension = $file->getClientOriginalExtension();

    // Nom unique : nom entreprise + clientId + time + uniqid
    $fileName = $entrepriseName . '_client_' . $clientId . '_' . time() . '_' . uniqid() . '.' . $extension;

    // Sauvegarde temporaire
    $tempPath = $file->storeAs('tmp', $fileName);
$fullPath = storage_path('app/' . $tempPath);
    
$spreadsheet = IOFactory::load($fullPath);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray();

    
    if (empty($data)) {
        return back()->with('error', 'Le fichier est vide.');
    }

    // Normaliser et vérifier les entêtes
    $headers = $this->normalizeHeaders(array_shift($data));
    $requiredColumns = ['nom', 'prenoms', 'sexe', 'email', 'contact', 'addresse', 'date_de_naissance', 'anciennete', 'statut'];
    $missingColumns = array_diff($requiredColumns, $headers);

    if (!empty($missingColumns)) {
        return back()->with('error', 'Colonnes manquantes: ' . implode(', ', $missingColumns));
    }


    $results = [
        'total_lignes' => count($data),
        'ajoutes' => 0,
        'ignores' => 0,
        'erreurs' => []
    ];

    

    foreach ($data as $index => $row) {
        $lineNumber = $index + 2; // Ligne réelle dans le fichier

        $rowData = array_combine($headers, $row);
        $validationResult = $this->cleanAndValidateData($rowData);

        if (!empty($validationResult['errors'])) {
            $results['erreurs'][] = [
                'ligne' => $lineNumber,
                'erreurs' => $validationResult['errors'],
            ];
            $results['ignores']++;
            continue;
        }

        $cleanedData = $validationResult['data'];

        // Vérifier doublon
        $exists = Assure::where('email', $cleanedData['email'])
            ->where('client_id', $clientId)
            ->exists();

        if ($exists) {
            $results['ignores']++;
            continue;
        }

        // Créer User
        $plainPassword = Str::random(10);
        $user = User::create([
            'name' => $cleanedData['nom'] . ' ' . $cleanedData['prenoms'],
            'email' => $cleanedData['email'],
            'password' => Hash::make($plainPassword),
        ]);
        $user->assignRole('assure');

        // Créer Assure
        Assure::create([
            'nom' => $cleanedData['nom'],
            'prenoms' => $cleanedData['prenoms'],
            'sexe' => $cleanedData['sexe'],
            'email' => $cleanedData['email'],
            'contact' => $cleanedData['contact'] ?? null,
            'addresse' => $cleanedData['addresse'] ?? null,
            'date_naissance' => $cleanedData['date_de_naissance'],
            'anciennete' => $cleanedData['anciennete'] ?? null,
            'statut' => $cleanedData['statut'] ?? 'actif',
            'user_id' => $user->id,
            'client_id' => $clientId,
            'client_access_token' => $clientAccessToken,
            'is_principal' => true,
        ]);

        $results['ajoutes']++;
    }

    /** -------------------------------
     *    SI TOUT OK → DÉPLACER
     * ------------------------------*/
    $finalPath = 'backups/' . $fileName;
    Storage::move($tempPath, $finalPath);

    return back()->with('import_results', $results);
}

    /**
     * Normalise les entêtes (trim, minuscules, underscore)
     */
    private function normalizeHeaders(array $headers): array
    {
        $normalized = [];
        foreach ($headers as $header) {
            $header = trim($header);
            $header = strtolower($header);
            $header = iconv('UTF-8', 'ASCII//TRANSLIT', $header);
            $header = preg_replace('/[\s\-]+/', '_', $header);
            $header = preg_replace('/[^a-z0-9_]/', '', $header);
            $normalized[] = $header;
        }
        return $normalized;
    }

    /**
     * Nettoie et valide une ligne de données, retourne ['data'=>..., 'errors'=>...]
     */
    private function cleanAndValidateData(array $rowData): array
    {
        $result = ['data' => null, 'errors' => []];
        $cleaned = [];

        foreach ($rowData as $key => $value) {
            $cleaned[$key] = is_string($value) ? trim($value) : $value;
        }

        try {
            // Nom/prénoms
            if (isset($cleaned['nom'])) {
                $cleaned['nom'] = ucwords(strtolower($cleaned['nom']));
            } else {
                $result['errors'][] = "Nom manquant";
            }

            if (isset($cleaned['prenoms'])) {
                $cleaned['prenoms'] = ucwords(strtolower($cleaned['prenoms']));
            } else {
                $result['errors'][] = "Prénoms manquants";
            }

            // Email
            if (!empty($cleaned['email'])) {
                $cleaned['email'] = strtolower($cleaned['email']);
                if (!filter_var($cleaned['email'], FILTER_VALIDATE_EMAIL)) {
                    $result['errors'][] = "Email invalide: {$cleaned['email']}";
                }
            } else {
                $result['errors'][] = "Email manquant";
            }

            // Date de naissance
            if (!empty($cleaned['date_de_naissance'])) {
                if (is_numeric($cleaned['date_de_naissance'])) {
                    $date = ExcelDate::excelToDateTimeObject($cleaned['date_de_naissance']);
                } else {
                    $formats = ['d/m/Y', 'Y-m-d', 'd-m-Y'];
                    $date = null;
                    foreach ($formats as $format) {
                        try {
                            $date = Carbon::createFromFormat($format, $cleaned['date_de_naissance']);
                            if ($date) break;
                        } catch (\Exception $e) {}
                    }
                    if (!$date) {
                        $result['errors'][] = "Format date de naissance invalide: {$cleaned['date_de_naissance']}";
                    }
                }
                if ($date) {
                    $cleaned['date_de_naissance'] = $date->format('Y-m-d');
                }
            } else {
                $result['errors'][] = "Date de naissance manquante";
            }

            // Sexe
            if (!empty($cleaned['sexe'])) {
                $cleaned['sexe'] = strtoupper($cleaned['sexe']);
                if (!in_array($cleaned['sexe'], ['M', 'F'])) {
                    $result['errors'][] = "Sexe invalide: {$cleaned['sexe']}";
                }
            } else {
                $result['errors'][] = "Sexe manquant";
            }

            // Validation Laravel
            $validator = Validator::make($cleaned, [
                'nom' => 'required|string|max:255',
                'prenoms' => 'required|string|max:255',
                'email' => 'required|email',
                'sexe' => 'required|in:M,F',
                'contact' => 'nullable|string|max:20',
                'addresse' => 'nullable|string|max:255',
                'date_de_naissance' => 'required|date',
                'anciennete' => 'nullable|string',
                'statut' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $result['errors'] = array_merge($result['errors'], $validator->errors()->all());
            }

            if (count($result['errors']) > 0) {
                return $result;
            }

            $result['data'] = $cleaned;
            return $result;

        } catch (\Exception $e) {
            $result['errors'][] = $e->getMessage();
            return $result;
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assures = Assure::orderBy('id')->paginate();
        $clients = Client::all();
        return view('assures.index', compact('assures', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(Assure $assure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $assure = Assure::findOrFail($id);
        return view('assures.edit', compact('assure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        
        $assure = Assure::findOrFail($id);
        $validated = $request->validate([
            'nom' => 'sometimes|max:255',
            'prenoms'=> 'sometimes|max:250',
            'email' => "sometimes|email|unique:users,email,{$assure->user_id}",
            'sexe' => 'sometimes|in:M,F',
            'contact' => 'nullable|string|max:20',
            'addresse' => 'nullable|string|max:255',
            'client_id' => 'sometimes|exists:clients,id',
            'is_principal' => 'sometimes|boolean',
        ]);

        $assure->update($validated);

        if ($assure->user) {
            $assure->user->update([
                'name' => ($validated['nom'] ?? $assure->nom) . ' ' . ($validated['prenoms'] ?? $assure->prenoms),
                'email' => $validated['email'] ?? $assure->email,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Assuré mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $assure = Assure::findOrFail($id);

        $assure->delete();

        return redirect()->back()->with('success', 'Assuré supprimé avec succès.');
    }


    public function create()
    {
        // return view('assures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'prenoms' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'sexe' => 'required|in:M,F',
        'contact' => 'required|string',     // <- important
        'addresse' => 'nullable|string',
        'is_principal' => 'required|boolean',
        'client_id' => 'required|exists:clients,id',
    ]); 

    // Récupérer le client
    $client = Client::findOrFail($validated['client_id']);

    // Créer l'utilisateur
    $user = User::create([
        'name' => $validated['nom'] . ' ' . $validated['prenoms'],
        'email' => $validated['email'],
        'password' => Hash::make('password123'), // Mot de passe temporaire
    ]);

    // Attribuer le rôle 'assure'
    $user->assignRole('assure');

    // Créer l'assuré associé
    $assure = Assure::create([
        'nom' => $validated['nom'],
        'prenoms' => $validated['prenoms'],
        'email' => $validated['email'],
        'sexe' => $validated['sexe'],
         'contact' => $validated['contact'],  // <- à ne pas oublier !
        'addresse' => $validated['addresse'] ?? null,
        'user_id' => $user->id,
        'client_id' => $client->id,
        'is_principal' => $validated['is_principal'] ?? false,
    ]);

    return redirect()->route('dashboard')->with('success', 'Assuré créé avec succès.');
        
    }

    public function export() 
    {
        return Excel::download(new AssuresExport, 'assures.xlsx');
    }






}
