<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = ['reponses', 'employe_id','statut'];

    protected $casts = [
        'reponses' => 'array',
        'statut' => StatutEnum::class,
    ];

    public function Employe()
    {
        return $this->belongsTo(Employe::class);
    }
}
