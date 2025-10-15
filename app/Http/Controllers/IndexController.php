<?php

    namespace App\Http\Controllers;

    use App\Models\Service;
    use App\Models\Timer;

    class IndexController extends Controller
    {
        public function index()
        {
            $features = Service::where('featured', true)->get();

            $announcement= Timer::latest()->first();

            return view('index', compact('features','announcement'));
        }
    }
