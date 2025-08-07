<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carte extends Model
{
     use HasFactory;
   protected $fillable = ['assure_id'];

   public function assure()
{
    return $this->belongsTo('App\Models\Assure');
} 
}

 
