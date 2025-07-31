<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'prenoms', 'sexe', 'email', 'contact',
        'addresse', 'entreprise_id',
        'entreprise_access_token', 'user_id', 'is_principal'
    ];

    protected $casts = [
        'is_principal' => 'boolean',
    ];

    // Relations
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function user()
    {
         return $this->belongsTo(User::class);
    }

    public function beneficiaires()
    {
        return $this->hasMany(Beneficiare::class);
}
 public function Demande()
    {
        return $this->hasOne(Demande::class);
}

public function Carte()
    {
        return $this->hasOne(Carte::class);
}

}