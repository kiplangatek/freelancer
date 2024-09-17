@php use Carbon\Carbon; @endphp
	<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Dashboard | Admin</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">
	<script src="https://unpkg.com/alpinejs" defer></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	@vite(['resources/css/app.css'])
</head>

<body class="h-full font-inter">
<div x-data="{ sidebarOpen: false, activeTab: 'users' }"
     x-init="activeTab = new URLSearchParams(window.location.search).get('activeTab') || 'users'">
	<!-- Header -->
	<header class="fixed z-10 flex w-full items-center justify-between bg-gray-400 px-8 py-6 text-white md:z-50">
		<button @click="sidebarOpen = !sidebarOpen" class="md:hidden">
			<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
			     xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
				</path>
			</svg>
		</button>
		<div class="h-auto w-16 transition-all duration-300 md:hidden" id="logo">
			<img class="h-auto w-full" src="{{ asset('storage/ui/logo.png') }}" alt="Logo">
		</div>
		<div class="hidden h-auto w-16 transition-all duration-300 md:block" id="logo">
			<a href="/">
				<img class="h-auto w-full" src="{{ asset('storage/ui/logo.png') }}" alt="Logo">
			</a>
		</div>
		<div>
			@auth
				<div class="relative">
					<a href="/my">
						<img src="{{ asset('storage/avatars/' . Auth::user()->photo) }}" alt="Profile"
						     class="duration-600 h-10 w-10 cursor-pointer rounded-full transition-all hover:ring-2 hover:ring-offset-blue-600"/>
					</a>
				</div>
			@endauth
		</div>
	</header>

	<!-- Sidebar -->
	<div :class="{ 'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen }"
	     class="fixed inset-y-0 left-0 z-20 w-64 transform bg-gray-400 p-4 text-white transition duration-200 ease-in-out md:translate-x-0">
		<div class="flex h-16 items-center justify-between bg-gray-400 md:hidden">
			<div class="h-auto w-16 transition-all duration-300" id="logo">
				<a href="/">
					<img class="h-auto w-full" src="{{ asset('storage/ui/logo.png') }}" alt="Logo">
				</a>
			</div>
			<button @click="sidebarOpen = false" class="p-2 focus:outline-none">
				<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
				     xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
					</path>
				</svg>
			</button>
		</div>
		<nav class="mt-5 md:mt-20">
			<a @click.prevent="activeTab = 'users'; window.history.pushState({}, '', '?activeTab=users')"
			   :class="{ 'bg-gray-500': activeTab === 'users' }"
			   class="block rounded-lg px-4 py-2 text-sm font-medium">Users</a>
			<a @click.prevent="activeTab = 'ratings'; window.history.pushState({}, '', '?activeTab=ratings')"
			   :class="{ 'bg-gray-500': activeTab === 'ratings' }"
			   class="mt-4 block rounded-lg px-4 py-2 text-sm font-medium">Ratings</a>
			<a @click.prevent="activeTab = 'services'; window.history.pushState({}, '', '?activeTab=services')"
			   :class="{ 'bg-gray-500': activeTab === 'services' }"
			   class="mt-4 block rounded-lg px-4 py-2 text-sm font-medium">Services</a>
			<a @click.prevent="activeTab = 'inactive-freelancers'; window.history.pushState({}, '', '?activeTab=inactive-freelancers')"
			   :class="{ 'bg-gray-500': activeTab === 'inactive-freelancers' }"
			   class="mt-4 block rounded-lg px-4 py-2 text-sm font-medium">Inactive Freelancers</a>
			<a @click.prevent="activeTab = 'categories'; window.history.pushState({}, '', '?activeTab=categories')"
			   :class="{ 'bg-gray-500': activeTab === 'categories' }"
			   class="mt-4 block rounded-lg px-4 py-2 text-sm font-medium">Categories</a>
		</nav>

	</div>

	<!-- Main content -->
	<main class="pt-12 md:ml-64">
		<div class="mt-12 px-10">
			@if (session('success'))
				<x-alert type="success" :message="session('success')"/>
			@endif

			@if (session('error'))
				<x-alert type="error" :message="session('error')"/>
			@endif
		</div>
		<!-- Users Tab Content -->
		<div x-show="activeTab === 'users'" class="px-4" x-cloak>
			<section class="w-full py-1">
				<div class="container mx-auto mt-1 px-4">
					<h1 class="mb-6 text-left text-3xl font-bold">Users</h1>
					<div class="overflow-x-auto">
						<table class="min-w-full overflow-hidden rounded-lg bg-white shadow-md">
							<thead class="sticky top-0 bg-gray-800 text-white">
							<tr class="text-left">
								<th class="px-4 py-3 text-xs md:text-sm">Name</th>
								<th class="px-4 py-3 text-xs md:text-sm">Email</th>
								<th class="px-4 py-3 text-xs md:text-sm">User Type</th>
								<th class="px-4 py-3 text-xs md:text-sm">Status</th>
								<th class="px-4 py-3 text-xs md:text-sm">Actions</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($users as $user)
								<tr class="border-b text-xs md:text-sm">
									<td class="px-4 py-3">{{ $user->name }}</td>
									<td class="px-4 py-3">{{ $user->email }}</td>
									<td class="px-4 py-3">{{ $user->usertype }}</td>
									<td class="px-4 py-3">
										<div class="flex-col items-center md:flex">
											@if ($user->verified)
												<span class="text-green-600">Verified</span>
											@else
												<span class="text-red-600">Not Verified</span>
											@endif
											@if ($user->suspended)
												<span class="ml-2 text-yellow-600">Suspended</span>
											@endif
										</div>
									</td>
									<td
										class="flex flex-col space-y-1 px-4 py-3 md:flex-row md:space-x-2 md:space-y-0">
										@if (!$user->verified)
											<form action="{{ route('admin.verify', $user->id) }}"
											      method="POST">
												@csrf
												@method('PATCH')
												<button
													class="rounded-md bg-blue-600 px-2 py-1 text-white hover:bg-blue-500">
													Verify
												</button>
											</form>
										@else
											<form action="{{ route('admin.revoke', $user->id) }}"
											      method="POST">
												@csrf
												@method('PATCH')
												<button
													class="rounded-md bg-yellow-600 px-2 py-1 text-white hover:bg-yellow-500">
													Revoke
												</button>
											</form>
										@endif

										<form action="{{ route('admin.suspend', $user->id) }}" method="POST">
											@csrf
											@method('PATCH')
											<button
												class="rounded-md bg-red-600 px-2 py-1 text-white hover:bg-red-500">{{ $user->suspended ? 'Unsuspend' : 'Suspend' }}</button>
										</form>

										<!-- Delete User Form -->
										<div x-data="{ showModal: false, userId: null }">
											<!-- Delete Button -->
											<form :action="`{{ url('admin/delete-user/') }}/${userId}`"
											      method="POST">
												@csrf
												@method('DELETE')
												<button type="button"
												        @click="showModal = true; userId = {{ $user->id }}"
												        class="rounded-md bg-red-800 px-2 py-1 text-white hover:bg-red-700">
													Delete
												</button>

												<!-- Custom Confirmation Modal -->
												<div x-show="showModal"
												     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
													<div class="w-full max-w-sm rounded-lg bg-white p-4 shadow-lg">
														<h2 class="mb-4 text-lg font-bold">Confirm
															Deletion</h2>
														<p>Are you sure you want to delete this user?</p>
														<div class="mt-4 flex justify-end">
															<button type="button"
															        @click="showModal = false"
															        class="mr-2 rounded bg-gray-500 px-4 py-2 text-white hover:bg-gray-400">
																Cancel
															</button>
															<button type="submit"
															        class="rounded bg-red-800 px-4 py-2 text-white hover:bg-red-700">
																Delete
															</button>
														</div>
													</div>
												</div>
											</form>
										</div>

									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</section>

		</div>

		<!-- Ratings Tab Content -->
		<div x-show="activeTab === 'ratings'" class="px-4" x-cloak>
			<section class="w-full py-1">
				<div class="container mx-auto mt-1 px-4">
					<h1 class="mb-6 text-left text-3xl font-bold">Ratings</h1>
					<div class="overflow-x-auto">
						<table class="min-w-full overflow-hidden rounded-lg bg-white shadow-md">
							<thead class="sticky top-0 bg-gray-800 text-white">
							<tr class="text-left">
								<th class="px-4 py-3 text-xs md:text-sm">Freelancer</th>
								<th class="px-4 py-3 text-xs md:text-sm">Service</th>
								<th class="px-4 py-3 text-xs md:text-sm">Rating</th>
								<th class="px-4 py-3 text-xs md:text-sm">Comment</th>
								<th class="px-4 py-3 text-xs md:text-sm">Date</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($ratings as $rating)
								<tr class="border-b text-xs md:text-sm">
									<td class="px-4 py-3">{{ $rating->freelancer->name }}</td>
									<td class="px-4 py-3">{{ $rating->service->title }}</td>
									<td class="px-4 py-3">
                                       <span
	                                       class="@if ($rating->rating >= 4) bg-green-200 text-green-800
                                                @elseif($rating->rating >= 2)
                                                    bg-yellow-200 text-yellow-800
                                                @else
                                                    bg-red-200 text-red-800 @endif inline-flex items-center rounded-full px-2 py-1 text-xs font-medium">
                                          {{ $rating->rating }}
                                       </span>
									</td>
									<td class="px-4 py-3">{{ $rating->comments }}</td>
									<td class="min-w-32 px-4 py-3">{{ $rating->created_at->format('d M Y, h:i A ') }}
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>

		<!-- Services Tab Content -->
		<div x-show="activeTab === 'services'" class="px-4" x-cloak>
			<section class="w-full py-1">
				<div class="container mx-auto mt-1 px-4">
					<h1 class="mb-6 text-left text-3xl font-bold">Services</h1>
					<div class="overflow-x-auto">
						<table class="min-w-full overflow-hidden rounded-lg bg-white shadow-md">
							<thead class="sticky top-0 bg-gray-800 text-white">
							<tr class="text-left">
								<th class="px-4 py-3 text-xs md:text-sm">Service</th>
								<th class="px-4 py-3 text-xs md:text-sm">Freelancer</th>
								<th class="px-4 py-3 text-xs md:text-sm">Price in Ksh.</th>
								<th class="px-4 py-3 text-xs md:text-sm">Featured</th>
								<th class="px-4 py-3 text-xs md:text-sm">Actions</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($services as $service)
								<tr class="border-b text-xs md:text-sm">
									<td class="px-4 py-3">{{ $service->title }}</td>
									<td class="px-4 py-3">{{ $service->freelancer->name }}</td>
									<td class="px-4 py-3">{{number_format($service->price) }}</td>
									<td class="px-4 py-3">
										@if ($service->featured)
											<span class="text-green-600">Yes</span>
										@else
											<span class="text-red-600">No</span>
										@endif
									</td>
									<td
										class="flex flex-col space-y-1 px-4 py-3 md:flex-row md:space-x-2 md:space-y-0">
										@if (!$service->featured)
											<form action="{{ route('admin.feature', $service->id) }}"
											      method="POST">
												@csrf
												@method('PATCH')
												<button
													class="rounded-md bg-blue-600 px-2 py-1 text-white hover:bg-blue-500">
													Feature
												</button>
											</form>
										@else
											<form action="{{ route('admin.removeFeature', $service->id) }}"
											      method="POST">
												@csrf
												@method('PATCH')
												<button
													class="rounded-md bg-yellow-600 px-2 py-1 text-white hover:bg-yellow-500">
													Unfeature
												</button>
											</form>
										@endif
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>

		<!-- Categories Tab Content -->
		<div x-show="activeTab === 'categories'" class="px-4" x-cloak>
			<section class="w-full py-1">
				<div class="container mx-auto mt-1 px-4">
					<h1 class="mb-6 text-left text-3xl font-bold">Categories</h1>
					<div class="overflow-x-auto">
						<table class="min-w-full overflow-hidden rounded-lg bg-white shadow-md">
							<thead class="sticky top-0 bg-gray-800 text-white">
							<tr class="text-left">
								<th class="px-4 py-3 text-xs md:text-sm">Category Name</th>
								<th class="px-4 py-3 text-xs md:text-sm">Actions</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($categories as $category)
								<tr class="border-b text-xs md:text-sm">
									<td class="px-4 py-3">
										<div x-data="{ editing: false, name: '{{ $category->name }}' }">
											<template x-if="!editing">
												<span x-text="name"></span>
											</template>
											<template x-if="editing">
												<form
													:action="`{{ route('categories.update', $category->id) }}`"
													method="POST">
													@csrf
													@method('PATCH')
													<input type="text" name="name" :value="name" required
													       class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
													<div class="mt-2 flex justify-end space-x-2">
														<button type="submit"
														        class="rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-600">
															Save
														</button>
														<button type="button" @click="editing = false"
														        class="rounded bg-red-500 px-4 py-2 font-bold text-white hover:bg-red-600">
															Cancel
														</button>
													</div>
												</form>

											</template>
											<button x-show="!editing" @click="editing = true"
											        class="ml-2 rounded-md bg-yellow-600 px-2 py-1 text-white hover:bg-yellow-500">
												Edit
											</button>
										</div>
									</td>
									<td
										class="flex flex-col space-y-1 px-4 py-3 md:flex-row md:space-x-2 md:space-y-0">
										<!-- Delete Category Form -->
										<div x-data="{ showModal: false, categoryId: null }">
											<!-- Delete Button -->
											<form
												:action="`{{ route('categories.delete', '') }}/${categoryId}`"
												method="POST">
												@csrf
												@method('DELETE')
												<button type="button"
												        @click="showModal = true; categoryId = {{ $category->id }}"
												        class="rounded-md bg-red-800 px-2 py-1 text-white hover:bg-red-700">
													Delete
												</button>

												<!-- Custom Confirmation Modal -->
												<div x-show="showModal"
												     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
													<div class="w-full max-w-sm rounded-lg bg-white p-4 shadow-lg">
														<h2 class="mb-4 text-lg font-bold">Confirm
															Deletion</h2>
														<p>Are you sure you want to delete this
															category?</p>
														<div class="mt-4 flex justify-end">
															<button type="button"
															        @click="showModal = false"
															        class="mr-2 rounded bg-gray-500 px-4 py-2 text-white hover:bg-gray-400">
																Cancel
															</button>
															<button type="submit"
															        class="rounded bg-red-800 px-4 py-2 text-white hover:bg-red-700">
																Delete
															</button>
														</div>
													</div>
												</div>
											</form>

										</div>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
					<!-- Button to open the form -->
					<div x-data="{ openCategoryForm: false }">
						<button @click="openCategoryForm = true"
						        class="mt-6 rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-600">
							Create Category
						</button>

						<!-- Modal Popup Form -->
						<div x-show="openCategoryForm" @click.away="openCategoryForm = false"
						     class="fixed inset-0 z-50 flex items-center justify-center">
							<div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
								<h2 class="mb-4 text-lg font-bold">Create a New Category</h2>
								<form action="{{ route('categories.store') }}" method="POST">
									@csrf
									<div class="mb-4">
										<label for="name" class="block text-sm font-medium text-gray-700">Category
											Name</label>
										<input type="text" name="name" id="name" required
										       class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
									</div>
									<div class="flex justify-end">
										<button type="submit"
										        class="rounded bg-green-500 px-4 py-2 font-bold text-white hover:bg-green-600">
											Create
										</button>
										<button type="button" @click="openCategoryForm = false"
										        class="ml-4 rounded bg-red-500 px-4 py-2 font-bold text-white hover:bg-red-600">
											Cancel
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<!-- Inactive Freelancers Tab Content -->
		<div x-show="activeTab === 'inactive-freelancers'" class="px-4" x-cloak>
			<section class="w-full py-1">
				<div class="container mx-auto mt-1 px-4">
					<h1 class="mb-6 text-left text-3xl font-bold">Inactive Freelancers</h1>

					@if($inactiveFreelancers->count() > 0)
						<!-- Notify All button only visible when there are inactive freelancers -->
						<form action="{{ route('admin.create') }}" method="POST">
							@csrf
							<button type="submit"
							        class="mb-4 rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
								Notify All
							</button>
						</form>
					@endif

					<div class="overflow-x-auto">
						<table class="min-w-full overflow-hidden rounded-lg bg-white shadow-md">
							<thead class="sticky top-0 bg-gray-800 text-white">
							<tr class="text-left">
								<th class="px-4 py-3 text-xs md:text-sm">Name</th>
								<th class="px-4 py-3 text-xs md:text-sm">Email</th>
								<th class="px-4 py-3 text-xs md:text-sm">Joined Date</th>
							</tr>
							</thead>
							<tbody>
							@if($inactiveFreelancers->count() > 0)
								@foreach ($inactiveFreelancers as $freelancer)
									@php
										$joinedDate = Carbon::parse($freelancer->created_at);
									@endphp
									<tr class="border-b text-xs md:text-sm">
										<td class="px-4 py-3">{{ $freelancer->name }}</td>
										<td class="px-4 py-3">{{ $freelancer->email }}</td>
										<td class="px-4 py-3">{{ $joinedDate->format('d M Y, H:i') }}</td>
									</tr>
								@endforeach
							@else
								<!-- Centered message when no inactive freelancers -->
								<tr>
									<td colspan="3" class="px-4 py-3 text-center text-gray-500">
										No Freelancer with 0 services Right Now
									</td>
								</tr>
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>


	</main>
</div>
<script>
	function openModal(userId) {
		document.querySelector('[x-data]').__x.$data.showModal = true;
		document.querySelector('[x-data]').__x.$data.userId = userId;
	}

	function deleteUser(userId) {
		let form = document.querySelector('form[action*="' + userId + '"]');
		form.submit();
	}
</script>
</body>

</html>
