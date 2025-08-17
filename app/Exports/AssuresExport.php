<?php

namespace App\Exports;

use App\Models\Assure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class AssuresExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    public function collection()
    {
        // Retourner des données d'exemple pour le template
        return collect([
            [
                'nom' => 'Dupont',
                'prenoms' => 'Jean',
                'sexe' => 'M',
                'email' => 'jean.dupont@example.com',
                'contact' => '+22501234567',
                'addresse' => '123 Rue de la Paix, Abidjan',
                'date_de_naissance' => '1985-03-15',
                'anciennete' => '5 ans',
                'statut' => 'actif'
            ],
            [
                'nom' => 'Martin',
                'prenoms' => 'Marie',
                'sexe' => 'F',
                'email' => 'marie.martin@example.com',
                'contact' => '+22501234568',
                'addresse' => '456 Avenue des Fleurs, Yamoussoukro',
                'date_de_naissance' => '1990-07-22',
                'anciennete' => '3 ans',
                'statut' => 'actif'
            ],
            [
                'nom' => 'Bernard',
                'prenoms' => 'Pierre',
                'sexe' => 'M',
                'email' => 'pierre.bernard@example.com',
                'contact' => '+22501234569',
                'addresse' => '789 Boulevard Central, Bouaké',
                'date_de_naissance' => '1988-11-08',
                'anciennete' => '7 ans',
                'statut' => 'actif'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'nom',
            'prenoms',
            'sexe',
            'email',
            'contact',
            'addresse',
            'date_de_naissance',
            'anciennete',
            'statut'
        ];
    }

    public function map($assure): array
    {
        return [
            $assure['nom'],
            $assure['prenoms'],
            $assure['sexe'],
            $assure['email'],
            $assure['contact'],
            $assure['addresse'],
            $assure['date_de_naissance'],
            $assure['anciennete'],
            $assure['statut']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style pour l'en-tête
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '007BFF'],
            ],
        ]);

        // Style pour les données d'exemple
        $sheet->getStyle('A2:I4')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F8F9FA'],
            ],
        ]);

        // Bordures pour toutes les cellules
        $sheet->getStyle('A1:I4')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'DEE2E6'],
                ],
            ],
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // nom
            'B' => 15, // prenoms
            'C' => 8,  // sexe
            'D' => 30, // email
            'E' => 15, // contact
            'F' => 40, // addresse
            'G' => 15, // date_de_naissance
            'H' => 15, // anciennete
            'I' => 10, // statut
        ];
    }
}
