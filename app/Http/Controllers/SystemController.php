<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Module;

class SystemController extends Controller
{
    //
    public function modules() {

        $modules = collect(
            [
                (object) [
                'name' => 'Home',
                'key' => 'home',
                'route' => '/dashboard',
                'mdi_icon' => 'mdi-home',
                'menus' => [
                    (object) [
                        'name' => 'Dashboard',
                        'key' => 'dashboard',
                        'route' => '/dashboard',
                        'mdi_icon' => 'mdi-home',
                    ]
                ]
            ]
        ]);

        if(auth()->user()->is_master) {

            $menus = Module::with("menus")->get();
            $modules = $modules->merge($menus);
        }
        else {
            $tmp = DB::table("users_accesos_modules")->where("user_id",auth()->user()->id)->get();

            $cond = [];

            if($tmp->count()) {
                foreach($tmp as $row) {
                    $cond[] = $row->modulo_id;
                }
            }

            $modules = Modulo::whereIn("id", $cond)->with("menus")->get();
        }

        return response()->json($modules, 200);
    }
}
