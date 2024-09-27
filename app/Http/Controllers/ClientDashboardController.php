<?php

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\Auth;
    use App\Models\Rating;

    class ClientDashboardController extends Controller
    {
        public function index()
        {
            $user = Auth::user();
		  $allratings = Rating::all();
            return view('client.dashboard', compact('user'));
        }
    }
