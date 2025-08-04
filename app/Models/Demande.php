<?php

namespace App\Models;

use App\Http\Enums\StatutEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demande extends Model
{
   use HasFactory;
    protected $fillable = ['reponses', 'employe_id','statut'];

    protected $casts = [
        'reponses' => 'array',
        'statut' => StatutEnum::class,
    ];

    public function Employe()
    {
        return $this->belongsTo(Employe::class);
    }

    public function Gestionnaire()
    {
        return $this->belongsTo(Gestionnaire::class);
    }
}
