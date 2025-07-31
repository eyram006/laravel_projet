<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Entreprise extends Model
{
    use HasFactory;
     protected $fillable = ['nom', 'raison_social', 'address', 'user_id', 'access_token'];

    // Génère automatiquement un token si vide
    protected static function booted()
    {
        static::creating(function ($entreprise) {
            if (empty($entreprise->access_token)) {
                $entreprise->access_token = Str::random(5);
            }
        });
    }
    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employes()
    {
        return $this->hasMany(Employe::class, 'entreprise_id');
    }

    // public function employesViaToken()
    // {
    //     return $this->hasMany(Employe::class, 'entreprise_token_public', 'token_public');
    // }

    // Contrainte métier : peut avoir un seul employé principal
    // public function employePrincipal()
    // {
    //     return $this->hasOne(Employe::class)->where('is_principal', true);
    // }
}

