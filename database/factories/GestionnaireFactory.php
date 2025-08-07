<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Gestionnaire;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gestionnaire>
 */
class GestionnaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { $user = User::inRandomOrder()->first();
        return [
             'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            // 'email' =>$user->email,
            'sexe' => $this->faker->randomElement(['M', 'F']),
            'user_id' =>$user->id,
       
           
        ];
    }
}
