<?php

namespace Database\Factories;

// use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Assure;
use App\Models\User;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assure>
 */
class AssureFactory extends Factory
{
    protected $model = Assure::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client = Client::inRandomOrder()->first();

        return [
           'nom' => $this->faker->lastName,
            'prenoms' => $this->faker->firstName,
            'sexe' => $this->faker->randomElement(['M', 'F']),
            'email' => $this->faker->unique()->safeEmail,
            'contact' => $this->faker->unique()->phoneNumber,
            'addresse' => $this->faker->city,
            'client_id' =>$client->id,
            'client_access_token' => $client->access_token,
            'user_id' => User::inRandomOrder()->value('id'), 
            'is_principal' => $this->faker->boolean(100),
            'date_naissance'=>$this->faker->date(),
            'anciennete'=>$this->faker->numberBetween(0, 50) . ' ans',
        ];
    }
}
