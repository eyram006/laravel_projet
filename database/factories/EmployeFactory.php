<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employe;
use App\Models\User;
use App\Models\Entreprise;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employe>
 */
class EmployeFactory extends Factory
{
    protected $model = Employe::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        

        return [
           'nom' => $this->faker->lastName,
            'prenoms' => $this->faker->firstName,
            'sexe' => $this->faker->randomElement(['M', 'F']),
            'email' => $this->faker->unique()->safeEmail,
            'contact' => $this->faker->unique()->phoneNumber,
            'addresse' => $this->faker->address,
            'entreprise_id' => Entreprise::inRandomOrder()->value('id'),
            'entreprise_access_token' => Entreprise::inRandomOrder()->value('access_token'),
            'user_id' => User::inRandomOrder()->value('id'), 
            'is_principal' => $this->faker->boolean(30),
        ];
    }
}
