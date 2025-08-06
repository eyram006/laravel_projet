<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Client extends Model
{
    use HasFactory;
     protected $fillable = ['nom', 'raison_social', 'address', 'user_id', 'access_token'];

    // Génère automatiquement un token si vide
    protected static function booted()
    {
        static::creating(function ($client) {
            if (empty($client->access_token)) {
                $client->access_token = Str::random(5);
            }
        });
        
        static::updating(function ($client) {
            if (empty($client->access_token)) {
                $client->access_token = Str::random(5);
            }
        });
    }

    protected $casts = [
        'reponses' => 'array',
        'statut' => StatutEnum::class,
    ];
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

