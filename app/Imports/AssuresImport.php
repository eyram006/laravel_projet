<?php

namespace App\Imports;

use App\Models\Assure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client;

class AssuresImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    // public $recap = [
    //     'ajoutes' => 0,
    //     'ignores' => 0,
    //     'erreurs' => [],
    // ];

    // public function collection(Collection $rows)
    // {
    //     if ($rows->isEmpty()) {
    //         return;
    //     }

    //     // 1️⃣ Normaliser les entêtes
    //     $headers = $rows->shift()->map(function ($header) {
    //         $header = trim($header);
    //         $header = mb_strtolower($header, 'UTF-8');
    //         $header = preg_replace('/\s+/', '_', $header);
    //         return $header;
    //     });

    //     foreach ($rows as $index => $row) {
    //         $data = [];

    //         // 2️⃣ Mapper & nettoyer les données
    //         foreach ($headers as $i => $header) {
    //             $value = isset($row[$i]) ? trim($row[$i]) : null;
    //             if (in_array($header, ['nom', 'prenoms', 'adresse', 'statut'])) {
    //                 $value = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
    //             }
    //             if ($header === 'email' && $value) {
    //                 $value = mb_strtolower($value);
    //             }
    //             if ($header === 'date_de_naissance' && $value) {
    //                 try {
    //                     $value = \Carbon\Carbon::parse($value)->format('Y-m-d');
    //                 } catch (\Exception $e) {
    //                     $value = null;
    //                 }
    //             }
    //             $data[$header] = $value;
    //         }

    //         // 3️⃣ Validation
    //         $validator = Validator::make($data, [
    //             'nom' => 'required|string|max:255',
    //             'prenoms' => 'required|string|max:255',
    //             'email' => 'required|email|unique:users,email',
    //             'sexe' => 'required|in:M,F',
    //             'date_de_naissance' => 'nullable|date',
    //         ]);

    //         if ($validator->fails()) {
    //             $this->recap['ignores']++;
    //             if (!is_array($this->recap['erreurs'])) {
    //             $this->recap['erreurs']=[];}
    //             $this->recap['erreurs'][] = [
    //                 'ligne' => $index + 2, // +2 car entête et index base 0
    //                 'erreurs' => $validator->errors()->all()
    //             ];
    //             continue;
    //         }

    //         // 4️⃣ Éviter doublons par email
    //         if (Assure::where('email', $data['email'])->exists()) {
    //             $this->recap['ignores']++;
    //             continue;
    //         }

    //         // 5️⃣ Création User
    //         $user = User::create([
    //             'name' => $data['nom'] . ' ' . $data['prenoms'],
    //             'email' => $data['email'],
    //             'password' => Hash::make('password123'),
    //         ]);
    //         $user->assignRole('assure');

    //         // 6️⃣ Création Assure
    //         Assure::create([
    //             'nom' => $data['nom'],
    //             'prenoms' => $data['prenoms'],
    //             'sexe' => $data['sexe'],
    //             'email' => $data['email'],
    //             'contact' => $data['contact'] ?? null,
    //             'addresse' => $data['adresse'] ?? null,
    //             'date_naissance' => $data['date_de_naissance'] ?? null,
    //             'anciennete' => $data['anciennete'] ?? null,
    //             'statut' => $data['statut'] ?? null,
    //             'user_id' => $user->id,
    //             'client_id' => Client::first()->id, 
    //         ]);

    //         $this->recap['ajoutes']++;
    //     }
    // }

    public function model(array $row)
    {
        return new Assure([
            //
        ]);
    }
}
