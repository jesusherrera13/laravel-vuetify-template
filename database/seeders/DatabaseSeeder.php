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

        // SYSTEM LANGUAGES
        $array = [
            [ 'name' => 'Español' ],
            [ 'name' => 'Inglés' ],
            [ 'name' => 'Francés' ],
        ];

        foreach($array as $row) {

            DB::table('system_languages')->insert([
                'name' => $row['name'],
                'created_at' => date('Y-m-d h:i:s'),
            ]);
        }
        // SYSTEM LANGUAGES

        $array = [
            [ 'name' => 'Administrador' ],
            [ 'name' => 'Usuario' ],
        ];

        foreach($array as $row) {

            DB::table('system_user_roles')->insert([
                'name' => $row['name'],
                'created_at' => date('Y-m-d h:i:s'),
            ]);
        }

        $array = [
            [
                'name' => 'Sistema',
                'key' => 'system-configuration',
                'route' => '/system-configuration',
                'mdi_icon' => 'mdi-security',
                'created_at' => date('Y-m-d h:i:s'),
                'menus' => [
                    [
                        'name' => 'Módulos',
                        'key' => 'system-modules',
                        'route' => '/system-modules',
                        'mdi_icon' => 'mdi-apps',
                        'created_at' => date('Y-m-d h:i:s'),
                        'module_id' => 1
                    ],
                    [
                        'name' => 'Usuarios',
                        'key' => 'system-users',
                        'route' => '/system-users',
                        'mdi_icon' => 'mdi-shield-account',
                        'created_at' => date('Y-m-d h:i:s'),
                        'module_id' => 1
                    ],
                    [
                        'name' => 'Accesos',
                        'key' => 'system-access',
                        'route' => '/system-access',
                        'mdi_icon' => 'mdi-shield-key',
                        'created_at' => date('Y-m-d h:i:s'),
                        'module_id' => 1
                    ],
                ]
            ],
        ];

        foreach($array as $row) {

            DB::table('system_modules')->insert([
                'name' => $row['name'],
                'key' => $row['key'],
                'route' => $row['route'],
                'mdi_icon' => $row['mdi_icon'],
                'created_at' => date('Y-m-d h:i:s'),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            foreach($row['menus'] as $rowM) {
                DB::table('system_modules_menus')->insert([
                    'name' => $rowM['name'],
                    'key' => $rowM['key'],
                    'route' => $rowM['route'],
                    'mdi_icon' => $rowM['mdi_icon'],
                    'module_id' => $rowM['module_id'],
                    'created_at' => date('Y-m-d h:i:s'),
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }
        }
        // MENUS


    }
}
