<?php

namespace App\Http\Controllers;

use App\Models\Assure;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Imports\AssuresImport;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ImportAssuresController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Lecture du fichier Excel
        $rows = Excel::toCollection(new AssuresImport, $request->file('file'))->first();

        
        if ($rows->isEmpty()) {
            return back()->with('error', 'Le fichier est vide ou les en-têtes sont incorrects.');
        }

        // Colonnes attendues
        $colonnesAttendues = [
            'nom', 'prenoms', 'sexe', 'email', 'contact', 'addresse', 'anciennete', 'date_naissance'
        ];

        // Normaliser les clés du premier élément
        $entetes = array_map(fn($v) => strtolower(trim($v)), array_keys($rows->first()));

        foreach ($colonnesAttendues as $col) {
            if (!in_array($col, $entetes)) {
                return back()->with('error', "Colonne manquante : {$col}");
            }
        }

        $inserted = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            try {
                $password = Str::random(8);

                $assure = Assure::create([
                    'nom' => $row['nom'],
                    'prenoms' => $row['prenoms'],
                    'sexe' => $row['sexe'],
                    'email' => $row['email'],
                    'contact' => $row['contact'],
                    'addresse' => $row['addresse'],
                    'anciennete' => $row['anciennete'],
                    'date_naissance' => $this->convertDate($row['date_naissance']),
                    'password' => bcrypt($password),
                ]);
               dd($row);

                // Envoi de l'email
                try {
                    Mail::raw("Bonjour {$assure->prenoms}, votre compte a été créé. Votre mot de passe est : {$password}", function ($message) use ($assure) {
                        $message->to($assure->email)
                            ->subject('Création de votre compte');
                    });
                } catch (\Exception $e) {
                    $errors[] = "Ligne " . ($index + 2) . ": impossible d'envoyer l'email.";
                }

                $inserted++;
            } catch (\Exception $e) {
                $errors[] = "Ligne " . ($index + 2) . ": erreur - " . $e->getMessage();
            }
        }

        return response()->json([
            'status' => 'ok',
            'inserted' => $inserted,
            'errors' => $errors
        ]);
    }

    private function convertDate($value)
    {
        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
        }
        return date('Y-m-d', strtotime($value));
    }
}
