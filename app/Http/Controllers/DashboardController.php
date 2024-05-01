<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request) {

        $response = Http::post('http://localhost/integra/api/soporte/testing/viaticosDashboard',[
            'user_id' => 1
        ]);

        $data = $response->json();
        
        return response()->json($data, 200);
    }
}
