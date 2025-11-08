<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Societe>
 */
class SocieteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "nom" => "NOM DE LA SOCIETE",
            "telephone" => null,
            "email" => null,
            "nif" => null,
            "stat" => null,
            "rcs" => null,
            "cif" => null,
            "activite" => null,
            "adresse" => null,
            "ville" => null,
            "code_postal" => null,
            "pays" => null,
        ];
    }
}
