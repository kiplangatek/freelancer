<?php

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\Auth;

    class ClientDashboardController extends Controller
    {
        public function index()
        {
            $user = Auth::user();
            return view('client.dashboard', compact('user'));
        }
    }
