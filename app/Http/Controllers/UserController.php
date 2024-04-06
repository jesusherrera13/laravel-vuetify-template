<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function update(Request $request, User $user) {
        // dd($request);
        $validated = [];

        if($request['password_reset']) {

            $fields = $request->validate([
                'name' => 'required',
                'password' => 'required|string|confirmed',
            ]);
            
            $validated = [
                'name' => $fields['name'],
                'password' => bcrypt($fields['password']),
            ];
        }
        else {
            $fields = $request->validate([
                'name' => 'required',
            ]);

            $validated = [
                'name' => $fields['name'],
            ];
        }

        $user->update($validated);

        return response([
            'sucesss' => true,
        ], 200);
    }
}
