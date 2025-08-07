<?php

namespace App\Imports;

use App\Models\Assure;
use Maatwebsite\Excel\Concerns\ToModel;

class AssuresImport implements ToModel,WithSkipDuplicates,PersistRelations
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Assure([
            //
        ]);
    }
}
