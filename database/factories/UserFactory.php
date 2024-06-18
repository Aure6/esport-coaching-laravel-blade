<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nicknames = ['Streetbowl', 'GameMaster', 'EsportKing', 'Playmaker', 'Champion', /*... add more nicknames ...*/];
        $names = [];

        for ($i = 0; $i < 40; $i++) {
            $name = $this->faker->firstName . " '" . $this->faker->randomElement($nicknames) . "' " . $this->faker->lastName;
            array_push($names, $name);
        }

        return [
            // 'name' => fake()->name(),
            'name' => $this->faker->randomElement($names),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),

            // 'role_id' => Role::inRandomOrder()->first()->id,
            'role_id' => Role::get()->random()->id,

            // 'avatar_path' => 'avatar_placeholder.png',
            'avatar_path' => $this->faker->randomElement(['avatar1.jpg', 'avatar2.jpg', 'avatar3.jpg', 'avatar4.jpg']),

            // coach stuff
            'game_id' => Game::get()->random()->id,
            // 'bio' => $this->faker->realTextBetween($minNbChars = 80, $maxNbChars = 600),
            'bio' => "Je suis entraîneur professionnel de la Ligue depuis la saison 5 et j'ai passé des milliers d'heures à travailler avec des joueurs de tous niveaux. Je me concentre sur la prise de décision patiente et calculée qui vous permet de contrôler vos adversaires et le rythme du jeu. Si vous avez du mal à atteindre vos objectifs de file d'attente en solo, si vous essayez d'améliorer votre jeu d'équipe, ou même si vous débutez dans le jeu, je serais ravi de vous aider dans votre parcours. Je suis spécialisé dans le Mid/ADC/Support, mais quelle que soit la position que vous jouez, les principes fondamentaux ne changent pas. Grâce à une relecture détaillée et/ou une observation en direct, j'améliorerai votre compréhension jusqu'à ce que vous puissiez même vaincre des adversaires plus doués que vous. On ne peut pas vraiment rester bloqué quand on est constamment meilleur que l'équipe ennemie, n'est-ce pas ? Si cela vous plaît, réservez votre prochaine leçon.",
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
