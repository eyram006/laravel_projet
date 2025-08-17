<?php

namespace App\Http\Controllers;

use App\Models\Assure;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Exports\AssuresExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\IOFactory;




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
        $assures = Assure::orderBy('id', 'asc')->paginate();
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
    public function update(Request $request, $id)
    {

        $assure = Assure::findOrFail($id);
        $validated = $request->validate([
            'nom' => 'sometimes|max:255',
            'prenoms' => 'sometimes|max:250',
            'email' => "sometimes|email|unique:users,email,{$assure->user_id}",
            'sexe' => 'sometimes|in:M,F',
            'contact' => 'nullable|string|max:20',
            'addresse' => 'nullable|string|max:255',
            'client_id' => 'sometimes|exists:clients,id',
            'is_principal' => 'sometimes|boolean',
        ]);

        foreach ($validated as $key => $value) {
            $assure->$key = $value;
        }
        $assure->save();

        if ($assure->user) {
            $assure->user->fill([
                'name' => ($validated['nom'] ?? $assure->nom) . ' ' . ($validated['prenoms'] ?? $assure->prenoms),
                'email' => $validated['email'] ?? $assure->email,
            ])->save();
        }

        return redirect()->route('dashboard')->with('success', 'Assuré mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $assure = Assure::findOrFail($id);

        $assure->delete($id);

        return redirect()->back()->with('success', 'Assuré supprimé avec succès.');
    }


    public function create()
    {
        // return view('assures.create');
    }




    /**
     * Store a newly created resource in storage.
     */
    

    // public function export()
    // {
    //     return Excel::download(new AssuresExport, 'assures.xlsx');
    // }

    /**
     * Affiche le formulaire d'import
     */
    public function showImport()
    {
        $clients = Client::all();
        return view('assures.import', compact('clients'));
    }



    
public function store(Request $request)
{
    try {
        // Validation des données gynécologiques conditionnelle
        $this->validateGynecologicalData($request);

        // Validation des données
        $validatedData = $request->validate([
            // Données personnelles de base (pour table assures)
            'donnees_medicales.informations_personnelles.nom' => 'required|string|max:255',
            'donnees_medicales.informations_personnelles.prenom' => 'required|string|max:255',
            'donnees_medicales.informations_personnelles.sexe' => 'required|in:M,F',
            'donnees_medicales.informations_personnelles.date_naissance' => 'required|date|before:today',
            'donnees_medicales.informations_sociodemographiques.email' => 'required|email|unique:assures,email',
            'donnees_medicales.informations_sociodemographiques.telephone' => 'required|string|unique:assures,contact',
            
            // Données socio-démographiques
            'donnees_medicales.informations_sociodemographiques.situation_matrimoniale' => 'required|string',
            'donnees_medicales.informations_sociodemographiques.niveau_etudes' => 'required|string',
            'donnees_medicales.informations_sociodemographiques.quartier' => 'required|string|max:255',
            'donnees_medicales.informations_sociodemographiques.employeur' => 'required|string|max:255',
            'donnees_medicales.informations_sociodemographiques.profession' => 'required|string|max:255',
            
            // Contact d'urgence
            'donnees_medicales.contact_urgence.personne_a_prevenir' => 'required|string|max:255',
            
            // Couverture santé
            'donnees_medicales.couverture_sante.deja_beneficie' => 'required|in:oui,non',
            'donnees_medicales.couverture_sante.periode' => 'nullable|string|max:255',
            
            // Antécédents médicaux
            'donnees_medicales.antecedents_medicaux.maladie_6_mois' => 'nullable|string',
            'donnees_medicales.antecedents_medicaux.maladie_chronique' => 'required|string',
            'donnees_medicales.antecedents_medicaux.traitement_en_cours' => 'required|string',
            'donnees_medicales.antecedents_medicaux.depenses_mensuelles_sante' => 'required|numeric|min:0',
            'donnees_medicales.antecedents_medicaux.porte_lunettes' => 'required|in:oui,non',
            
            // Allergies et antécédents
            'donnees_medicales.allergies_antecedents.allergies' => 'required|string',
            'donnees_medicales.allergies_antecedents.antecedents_chirurgicaux' => 'required|string',
            'donnees_medicales.allergies_antecedents.antecedents_familiaux' => 'required|string',
            
            // Mode de vie
            'donnees_medicales.mode_vie.consommation_alcool_semaine' => 'required|integer|min:0',
            'donnees_medicales.mode_vie.consommation_cola_jour' => 'required|integer|min:0',
            'donnees_medicales.mode_vie.annees_tabagisme' => 'required|integer|min:0',
            'donnees_medicales.mode_vie.cigarettes_par_jour' => 'required|integer|min:0',
            
            // Données gynécologiques (conditionnelles)
            'donnees_medicales.gynecologie.age_premieres_regles' => 'nullable|integer|min:0|max:30',
            'donnees_medicales.gynecologie.methode_contraceptive' => 'nullable|string',
            'donnees_medicales.gynecologie.maladie_seins' => 'nullable|string',
            'donnees_medicales.gynecologie.autre_maladie_genitale' => 'nullable|string',
            'donnees_medicales.gynecologie.maladie_col_uterus' => 'nullable|string',
            'donnees_medicales.gynecologie.nombre_grossesses' => 'nullable|integer|min:0',
            'donnees_medicales.gynecologie.nombre_accouchements' => 'nullable|integer|min:0',
            'donnees_medicales.gynecologie.particularites_derniere_grossesse' => 'nullable|string',
            'donnees_medicales.gynecologie.cesarienne_details' => 'nullable|string',
        ], [
            // Messages d'erreur personnalisés
            'donnees_medicales.informations_personnelles.nom.required' => 'Le nom est obligatoire',
            'donnees_medicales.informations_personnelles.prenom.required' => 'Le prénom est obligatoire',
            'donnees_medicales.informations_personnelles.sexe.required' => 'Le sexe est obligatoire',
            'donnees_medicales.informations_personnelles.sexe.in' => 'Le sexe doit être M ou F',
            'donnees_medicales.informations_personnelles.date_naissance.required' => 'La date de naissance est obligatoire',
            'donnees_medicales.informations_personnelles.date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui',
            'donnees_medicales.informations_sociodemographiques.email.required' => 'L\'email est obligatoire',
            'donnees_medicales.informations_sociodemographiques.email.unique' => 'Cet email est déjà utilisé',
            'donnees_medicales.informations_sociodemographiques.telephone.unique' => 'Ce numéro de téléphone est déjà utilisé',
        ]);

        DB::beginTransaction();

        // Utiliser l'ID de l'utilisateur connecté comme client_id
        $clientId = Auth::id();

        // Récupérer les informations du client pour l'access_token
        $client = Client::where('user_id', $clientId)->first();
        if (!$client) {
            throw new \Exception('Aucun client associé à cet utilisateur. Veuillez contacter l\'administrateur.');
        }

        // Création de l'adresse complète
        $adresse = $this->buildAddress($validatedData);

        // Calculer l'âge de l'assuré
        $dateNaissance = Carbon::parse($validatedData['donnees_medicales']['informations_personnelles']['date_naissance']);
        $anciennete = $this->calculateAge($dateNaissance->format('Y-m-d'));

        // Créer l'assuré
        $assure = Assure::create([
            'nom' => $validatedData['donnees_medicales']['informations_personnelles']['nom'],
            'prenoms' => $validatedData['donnees_medicales']['informations_personnelles']['prenom'],
            'sexe' => $validatedData['donnees_medicales']['informations_personnelles']['sexe'],
            'email' => $validatedData['donnees_medicales']['informations_sociodemographiques']['email'],
            'contact' => $validatedData['donnees_medicales']['informations_sociodemographiques']['telephone'],
            'addresse' => $adresse,
            'client_id' => $client->id,
            'client_access_token' => $client->access_token,
            'user_id' => $clientId,
            'date_naissance' => $dateNaissance,
            'anciennete' => $anciennete . ' ans',
            'statut' => 'en attente',
            'is_principal' => $request->input('is_principal', true),
            // Stockage direct des données médicales dans le champ JSON
            'donnees_medicales' => json_encode($validatedData['donnees_medicales'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        ]);

        DB::commit();

        // Log de l'activité
        Log::info('Nouvel assuré créé', [
            'assure_id' => $assure->id,
            'user_id' => $clientId,
            'client_id' => $client->id,
            'email' => $assure->email,
            'nom' => $assure->nom,
            'prenoms' => $assure->prenoms
        ]);

        return redirect()->route('assures.index')
            ->with('success', 'Assuré créé avec succès! Votre demande est en cours de traitement.')
            ->with('assure_data', [
                'id' => $assure->id,
                'nom' => $assure->nom,
                'prenoms' => $assure->prenoms,
                'email' => $assure->email
            ]);

    } catch (ValidationException $e) {
        DB::rollBack();
        Log::warning('Erreur de validation lors de la création d\'assuré', [
            'errors' => $e->errors(),
            'user_id' => Auth::id()
        ]);
        
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput()
            ->with('error', 'Veuillez corriger les erreurs dans le formulaire');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Erreur lors de la création d\'assuré', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'user_id' => Auth::id(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        return redirect()->back()
            ->withInput()
            ->with('error', 'Une erreur est survenue lors de l\'enregistrement : ' . $e->getMessage());
    }
}




}
