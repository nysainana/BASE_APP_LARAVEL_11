<?php

namespace Database\Seeders;

use App\Models\Societe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocieteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Societe::query()->updateOrCreate(
            ['nom' => "RAZANAMALALA Eugénie"],
            [
                "telephone" => "+261 38 54 414 95",
                "email" => "eugenie.razanamalala@gmail.com",
                "nif" => "6000189797",
                "stat" => "14107 31 1998 0 00194",
                "rcs" => null,
                "cif" => "0189309/ DGI-L du 24/06/24",
                "activite" => null,
                "adresse" => "Lot 44B bis pile 11/45 Andranomadio",
                "ville" => "Toamasina",
                "code_postal" => "501",
                "pays" => "Madagascar",
                "numero_compte" => "BMOI 00004 00010 02151800129 32"
            ]
        );
    }
}
