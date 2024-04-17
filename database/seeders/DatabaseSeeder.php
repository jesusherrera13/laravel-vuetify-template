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

        // MENUS
        $array = [
            [
                'name' => 'Sistema',
                'key' => 'sistema',
                'route' => '/system',
                'icon' => 'mdi-security',
                'created_at' => date('Y-m-d h:i:s'),
                'menus' => [
                    [
                        'name' => 'Módulos',
                        'key' => 'modules',
                        'route' => '/modules',
                        'icon' => 'mdi-apps',
                        'created_at' => date('Y-m-d h:i:s'),
                    ],
                    [
                        'name' => 'Usuarios',
                        'key' => 'users',
                        'route' => '/users',
                        'icon' => 'mdi-shield-account',
                        'created_at' => date('Y-m-d h:i:s'),
                    ],
                    [
                        'name' => 'Sincronización con la nube',
                        'key' => 'cloud-sync',
                        'route' => '/cloud-sync',
                        'icon' => 'mdi-cloud-sync',
                        'created_at' => date('Y-m-d h:i:s'),
                    ],
                ],
            ],
            [
                'name' => 'Configuración',
                'key' => 'configuracion',
                'route' => '/config',
                'icon' => 'mdi-cog',
                'created_at' => date('Y-m-d h:i:s'),
                'menus' => [
                    [
                        'name' => 'Compañías',
                        'key' => 'companies',
                        'route' => '/companies',
                        'icon' => 'mdi-domain',
                        'created_at' => date('Y-m-d h:i:s'),
                    ],
                    [
                        'name' => 'Empresas',
                        'key' => 'businesses',
                        'route' => '/businesses',
                        'icon' => 'mdi-office-building',
                        'created_at' => date('Y-m-d h:i:s'),
                    ],
                    [
                        'name' => 'Plazas',
                        'key' => 'plazas',
                        'route' => '/plazas',
                        'icon' => 'mdi-home-group',
                        'created_at' => date('Y-m-d h:i:s'),
                    ],
                ]
            ]
        ];

        foreach($array as $row) {

            $id = DB::table('system_modules')->insertGetId([
                'name' => $row['name'],
                'key' => $row['key'],
                'route' => $row['route'],
                'icon' => $row['icon'],
                'created_at' => date('Y-m-d h:i:s'),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            foreach($row['menus'] as $row2) {
                DB::table('system_modules_menus')->insert([
                    'name' => $row2['name'],
                    'key' => $row2['key'],
                    'route' => $row2['route'],
                    'icon' => $row2['icon'],
                    'module_id' => $id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }
        }
        // MENUS
        // $table->string('name');
        // $table->string('url');
        // $table->string('method');

        // CLOUD SYNC
        $array = [
            [
                'name' => 'alerta.fortia.com.mx',
                'created_at' => date('Y-m-d h:i:s'),
                'items' => [
                    [
                        'name' => 'Companies',
                        'url' => 'https://{dominio}/FortiaPrimeApi.OpenSync/api/v1/organizational-structure/company',
                        'method' => 'GET',
                        'created_at' => date('Y-m-d h:i:s'),
                    ],
                ],
            ],
        ];

        foreach($array as $row) {

            $id = DB::table('system_cloud_domains')->insertGetId([
                'name' => $row['name'],
                'created_at' => date('Y-m-d h:i:s'),
            ]);

            foreach($row['items'] as $row2) {

                $row2['url'] = str_replace('{dominio}', $row['name'], $row2['url']);

                DB::table('system_cloud_sync')->insert([
                    'name' => $row2['name'],
                    'url' => $row2['url'],
                    'method' => $row2['method'],
                    'cloud_domain_id' => $id,
                    'created_at' => date('Y-m-d h:i:s'),
                ]);
            }
        }
        // MENUS
    }
}
