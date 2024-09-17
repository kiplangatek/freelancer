<!DOCTYPE html>
<html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
      <link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
      <script src="https://unpkg.com/alpinejs" defer></script>

      <title>Forgot Password</title>
      @vite(['resources/css/app.css'])
      <script src="https://cdn.tailwindcss.com"></script>
      <style>
         @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

         body {
            font-family: 'Inter', sans-serif;
         }
      </style>
   </head>

   <body class="flex h-full items-center justify-center bg-gray-100 px-5">
      <div class="w-full max-w-md rounded-lg bg-white px-8 py-8 shadow-lg">
         <h2 class="mb-6 text-center text-2xl font-bold">Password Reset</h2>
         @if (session('email'))
            <x-alert type="error" :message="session('email')" />
         @endif
         <form method="POST" action="{{ route('password.update') }}" class="space-y-3">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="flex flex-col space-y-1">
               <label for="email" class="font-semibold text-gray-700">Email Address</label>
               <input type="email" name="email" id="email" required
                  class="rounded-md border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex flex-col space-y-1">
               <label for="password" class="font-semibold text-gray-700">New Password</label>
               <input type="password" name="password" id="password" required
                  class="rounded-md border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex flex-col space-y-1">
               <label for="password_confirmation" class="font-semibold text-gray-700">Confirm New Password</label>
               <input type="password" name="password_confirmation" id="password_confirmation" required
                  class="rounded-md border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
               class="w-full rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
               Reset Password
            </button>
         </form>
      </div>
   </body>

</html>
