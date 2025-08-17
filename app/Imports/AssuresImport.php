<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssuresImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        return $rows; // Les données seront traitées dans le contrôleur
    }

    public function headingRow(): int
    {
        return 1; // Première ligne = en-têtes
    }
}
 