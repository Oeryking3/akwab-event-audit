<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UtilisateurFactory extends Factory
{
    protected $model = Utilisateur::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = Role::firstOrCreate(['libelle' => 'utilisateur']);

        return [
            'nom'          => $this->faker->lastName(),
            'prenoms'      => $this->faker->firstName(),
            'email'        => $this->faker->unique()->safeEmail(),
            'telephone'    => $this->faker->phoneNumber(),
            'mot_de_passe' => bcrypt('password'),
            'id_role'      => $role->id_role,
        ];
    }

    public function admin(): static
    {
        return $this->state(function () {
            $role = Role::firstOrCreate(['libelle' => 'admin']);

            return ['id_role' => $role->id_role];
        });
    }
}