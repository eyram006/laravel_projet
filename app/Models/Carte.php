<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carte extends Model
{
     use HasFactory;
   protected $fillable = ['employe_id'];

   public function employe()
{
    return $this->belongsTo('App\Models\Employe');
} 
}

 
