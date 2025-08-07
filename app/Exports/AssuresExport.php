<?php

namespace App\Exports;

use App\Models\Assure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Support\Facades\DB;

class AssuresExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return[]  ;
        }
        
    //   public function map($assure): array
    // {
    //     return [
    //         $assure->id,
    //         $assure->nom,
    //         $assure->prenoms,
    //         $assure->sexe,
    //         $assure->email,
    //         $assure->contact,
    //         $assure->addresse,
    //         $assure->client_id,
    //         $assure->date_naissance,
    //         $assure->anciennete,
    //         $assure->client_access_token,
    //         $assure->user_id,
    //         $assure->is_principal ? 'Oui' : 'Non', // cast booléen
    //         $assure->statut->value ?? '', // enum
    //     ];
    // } 
       
        
       
        public function headings(): array
        {
            return [
                'Nom',
                'Prénoms',
                'Sexe',
                'Email',
                'Contact',
                'Adresse',
                'Date de Naissance',
                'Ancienneté',
                'Statut',
            ];
    }
}
