<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Enums\StatutEnum;

class Assure extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'nom', 'prenoms', 'sexe', 'email', 'contact',
        'addresse', 'client_id','date_naissance','anciennete',
        'client_access_token', 'user_id', 'is_principal','statut',
    ];

    protected $casts = [
        'is_principal' => 'boolean',
        'statut' => StatutEnum::class,
    ];

    // Relations
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
         return $this->belongsTo(User::class);
    }

    public function beneficiaires()
    {
        return $this->hasMany(Beneficiare::class);
}
 public function demande()
    {
        return $this->hasOne(Demande::class);
}

public function carte()
    {
        return $this->hasOne(Carte::class);
}

}