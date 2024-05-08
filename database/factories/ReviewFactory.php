<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reviews = [
            'Le Coach A sait vraiment comment tirer le meilleur de ses joueurs.',
            'J\'ai été impressionné par les perspectives stratégiques du Coach B.',
            'Le Coach C a une approche unique de l\'entraînement qui donne des résultats.',
            'Les compétences en communication du Coach D sont de premier ordre.',
            'Le Coach E montre une compréhension profonde du jeu.',
            'Le leadership du Coach F est vraiment inspirant.',
            'Le Coach G a un talent pour repérer les talents.',
            'J\'apprécie la dévotion et la passion du Coach H.',
            'Le Coach I a un excellent palmarès de succès.',
            'La connaissance technique du Coach J est impressionnante.'
        ];

        return [
            // 'coach_id' => User::whereHas('role', function ($query) {
            //     $query->where('name', 'coach');
            // })->get(),
            // 'client_id' => User::whereHas('role', function ($query) {
            //     $query->where('name', 'client');
            // })->get(),
            'coach_id' => User::whereHas('role', function ($query) {
                $query->where('name', 'coach');
            })->inRandomOrder()->first()->id,
            'client_id' => User::whereHas('role', function ($query) {
                $query->where('name', 'client');
            })->inRandomOrder()->first()->id,
            'text' => $this->faker->randomElement($reviews),
        ];
    }
}
