<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carte extends Model
{
   protected $fillable = ['employe_id'];

   public function employe()
{
    return $this->belongsTo('App\Models\Employe');
} 
}

 
