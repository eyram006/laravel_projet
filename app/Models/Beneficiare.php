<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Beneficiare extends Model
{
     use HasFactory;
   protected $fillable = ['url_justificatif', 'assure_id', 'user_id'];

    public function assure()
    {
        return $this->belongsTo(Assure::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
