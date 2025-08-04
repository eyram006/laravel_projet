<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gestionnaire;
use App\Models\User;

class GestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gestionnaire::create([
                 'nom' => 'Doe',
                 'prenom' => 'Yasmine',
                'sexe' => 'F',
                'user_id' => User::where('email', 'yasmine@gmail.com')->first()->id,

        ]);

         Gestionnaire::factory()->count(3)->create();
    }
}
