<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Client;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entreprise>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->company,
            'raison_social' => $this->faker->unique()->company(),
            'address' => $this->faker->city,
            'user_id' => User::inRandomOrder()->value('id'), 
            'access_token' => Str::random(5), // ou utiliser Str::uuid() si tu préfères un format UUID
          
        ];
    }
}
