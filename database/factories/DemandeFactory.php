<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Demande;
use App\Models\Employe;
use App\Models\Gestionnaire;
use Illuminate\Support\Arr;
use App\Http\Enums\StatutEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Demande>
 */
class DemandeFactory extends Factory
{

    protected $model = Demande::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reponses' => [
                'question1' => $this->faker->sentence,
                'question2' => $this->faker->sentence,
                'question3' => $this->faker->sentence,
            ],
            'statut' => Arr::random(StatutEnum::cases()),
            'employe_id' => Employe::inRandomOrder()->first()?->id  , 
            'gestionnaire_id' => Gestionnaire::inRandomOrder()->first()?->id
       
        ];
    }
}
