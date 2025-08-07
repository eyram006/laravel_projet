<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Enums\StatutEnum;
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

    public function assures()
    {
        return $this->hasMany(Assure::class, 'client_id');
    }

    // public function assuresViaToken()
    // {
    //     return $this->hasMany(Assure::class, 'client_token_public', 'token_public');
    // }

    // Contrainte métier : peut avoir un seul assuré principal
    // public function assurePrincipal()
    // {
    //     return $this->hasOne(Assure::class)->where('is_principal', true);
    // }
}

