<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        /* 
            use Illuminate\Support\Facades\Hash;
            dd(Hash::make("password"));
        */

        // USUARIOS
        DB::table('users')->insert([
            'name' => 'El Juego Perfecto MX',
            'email' => 'eljuegoperfectomx13@gmail.com',
            'password' => '$2y$10$oIsnvXUi6DwR14GQzvBXmOFtX6.FeofhzyZ3sm4UsxnpXH0BMoH76',
            'is_master' => 1
        ]);

        $array = [
            [ 'nombre' => 'Administrador' ],
            [ 'nombre' => 'Usuario' ],
        ];

        foreach($array as $row) {

            DB::table('system_roles')->insert([
                'nombre' => $row['nombre'],
                'created_at' => date('Y-m-d h:i:s'),
            ]);
        }
    }
}
