<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Chirp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChirpSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios de ejemplo si no existen
        $users = User::count() < 3 // Si hay menos de 3 usuarios, crear algunos
                    ? collect([
                        User::create([
                            'name' => 'Alice Developer',
                            'email' => 'alice@example.com',
                            'password' => bcrypt('password'),
                        ]),
                        User::create([
                            'name' => 'Bob Builder',
                            'email' => 'bob@example.com',
                            'password' => bcrypt('password'),
                        ]),
                    ])
                    : User::take(3)->get(); // Obtener los primeros 3 usuarios existentes
 
        // Mensajes de ejemplo para los chirps
        $chirps = [
            'Acabo de descubrir Laravel - ¿dónde ha estado esto toda mi vida? 🚀',
            '¡Construyendo algo genial con Chirper hoy!',
            'El ORM Eloquent de Laravel es pura magia ✨',
        ];
 
        // Crear chirps para cada usuario
        foreach ($chirps as $message) {
            $users->random()->chirps()->create([
                'message' => $message,
                'created_at' => now()->subMinutes(rand(5, 1440)),
            ]);
        }
    }
}
