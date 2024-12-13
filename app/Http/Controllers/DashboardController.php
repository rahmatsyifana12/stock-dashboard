<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $authClaims = $request->get('auth_claims');
        $role = $authClaims['role'] ?? 'user'; // set default role to 'user' if not provided
        return view('dashboard', ['role' => $role]);
    }
}
