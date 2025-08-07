<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestionnaire extends Model
{
    /** @use HasFactory<\Database\Factories\GestionnaireFactory> */
    use HasFactory;

    protected $fillable = [
        'nom','prenom','sexe','user_id',
    ];

    public function Demande()
    {
        return $this->hasMany(Demande::class);
    }

    protected static function boot()
{
    parent::boot(); 

    static::deleting(function ($gestionnaire) {
        $gestionnaire->user?->delete(); 
    });
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
