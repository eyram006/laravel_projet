<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestionnaire extends Model
{
    /** @use HasFactory<\Database\Factories\GestionnaireFactory> */
    use HasFactory;

    protected $fillable = [
        'nom','prenom','sexe'
    ];

    public function Demande()
    {
        return $this->hasMany(Demande::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
