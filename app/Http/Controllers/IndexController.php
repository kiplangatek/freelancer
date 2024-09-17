<?php

    namespace App\Http\Controllers;

    use App\Models\Service;

    class IndexController extends Controller
    {
        public function index()
        {
            $features = Service::where('featured', true)->get();

            return view('index', compact('features'));
        }
    }
