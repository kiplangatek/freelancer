<header id="header"
	   class="fixed left-0 top-0 z-50 mx-auto ml-[2.5%] mt-3 w-[95%] rounded-xl bg-gray-500 bg-opacity-70 px-8 py-6 backdrop-blur-lg transition-all duration-300">
	<nav class="flex w-full items-center justify-between">
		<div class="h-auto w-16 transition-all duration-300" id="logo">
			<a href="/">
				<img class="h-auto w-full" src="{{ asset('storage/ui/logo.png') }}" alt="Logo">
			</a>
		</div>
		<div id="nav-links"
			class="absolute left-0 top-[70px] z-50 hidden min-h-fit w-full items-center justify-between rounded-bl-xl rounded-br-xl bg-gray-400 pt-6 transition-all duration-500 md:static md:ml-8 md:flex md:min-h-fit md:w-auto md:bg-transparent md:pt-0 md:backdrop-blur-none">
			<ul
				class="mx-auto flex flex-col items-center justify-center gap-6 p-3 md:flex-row md:items-center md:gap-[4vw]">
				<li>
					<x-link href="/services" :active="request()->is('services')">Services</x-link>
				</li>
				<li>
					<x-link href="/creators" :active="request()->is('creators')">Creators</x-link>
				</li>
				<li>
					<x-link href="/contacts" :active="request()->is('contacts')">Contacts</x-link>
				</li>
			</ul>
		</div>
		@auth
			<form action="{{ route('services.search') }}" method="get"
				 class="flex flex-1 items-center justify-center px-2 md:mr-4">
				<input type="search" id="" name="search"
					  class="ml-1 flex h-9 w-[115px] flex-1 items-center rounded-full rounded-r-none border-gray-300 bg-gray-100 px-2 text-xs italic outline-none focus:ring-1 focus:ring-gray-400 focus:ring-offset-1 md:h-10  md:rounded-r-none"
					  placeholder="Search services" value="{{ isset($search) ? $search : '' }}" required />
				<button type="submit"
					   class="flex h-9 items-center rounded-full rounded-l-none bg-gray-200 px-1 text-white md:h-10  md:rounded-l-none md:px-4">
					<span class="hidden md:block text-black">Search</span>
					<ion-icon class="text-black md:hidden font-black px-2" name="search"></ion-icon>
				</button>
			</form>
		@endauth
		<div class="flex items-center gap-2 ">
			<ion-icon id="menu-icon" name="menu" class="cursor-pointer text-3xl md:hidden"
					onclick="toggleMenu()"></ion-icon>
			@guest
				<a href="/login"
				   class="flex items-center rounded-md bg-blue-600 px-2 py-1.5 font-semibold text-white transition-all duration-300 hover:bg-blue-700 hover:text-slate-300">Login</a>
			@endguest
			@auth
				<div class="relative">
					<a href="/my">
						<img src="{{ asset('storage/avatars/' . Auth::user()->photo) }}" alt="Profile"
							class="duration-600 h-9 w-9 cursor-pointer rounded-full transition-all hover:ring-2 hover:ring-offset-blue-600" />
					</a>
				</div>
			@endauth
		</div>
	</nav>
</header>
