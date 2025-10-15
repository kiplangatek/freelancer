<!-- resources/views/admin/freelancers.blade.php -->
<x-layout :title="'Manage Users & Timers'">
	<section class="body-font mt-14 w-full py-10">

		<div class="container mx-auto mt-8 px-4">

			<!-- Tabs -->
			<div x-data="{ tab: 'users' }">
				<div class="flex border-b border-gray-300 mb-6 space-x-4">
					<button
						@click="tab = 'users'"
						:class="tab === 'users' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'"
						class="pb-2 text-sm md:text-base font-semibold focus:outline-none">
						Users
					</button>

					<button
						@click="tab = 'timers'"
						:class="tab === 'timers' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'"
						class="pb-2 text-sm md:text-base font-semibold focus:outline-none">
						Countdown Timers
					</button>
				</div>

				<!-- USERS TAB -->
				<div x-show="tab === 'users'">
					<h1 class="text-3xl font-bold mb-6 text-left">Users</h1>
					<div class="overflow-x-auto">
						<table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
							<thead>
							<tr class="bg-gray-800 text-white text-left">
								<th class="py-3 px-4 text-xs md:text-sm">Name</th>
								<th class="py-3 px-4 text-xs md:text-sm">Email</th>
								<th class="py-3 px-4 text-xs md:text-sm">User Type</th>
								<th class="py-3 px-4 text-xs md:text-sm">Status</th>
								<th class="py-3 px-4 text-xs md:text-sm">Actions</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($users as $user)
								<tr class="border-b text-xs md:text-sm">
									<td class="py-3 px-4">{{ $user->name }}</td>
									<td class="py-3 px-4">{{ $user->email }}</td>
									<td class="py-3 px-4">{{ $user->usertype }}</td>
									<td class="py-3 px-4">
										<div class="flex-col items-center md:flex">
											@if($user->verified)
												<span class="text-green-600">Verified</span>
											@else
												<span class="text-red-600">Not Verified</span>
											@endif
											@if($user->suspended)
												<span class="ml-2 text-yellow-600">Suspended</span>
											@endif
										</div>
									</td>
									<td class="py-3 px-4 flex flex-col space-y-1 md:flex-row md:space-y-0 md:space-x-2">
										@if(!$user->verified)
											<form action="{{ route('admin.verify', $user->id) }}" method="POST">
												@csrf
												@method('PATCH')
												<button
													class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-500">
													Verify
												</button>
											</form>
										@else
											<form action="{{ route('admin.revoke', $user->id) }}" method="POST">
												@csrf
												@method('PATCH')
												<button
													class="px-2 py-1 bg-yellow-600 text-white rounded-md hover:bg-yellow-500">
													Revoke
												</button>
											</form>
										@endif

										<form action="{{ route('admin.suspend', $user->id) }}" method="POST">
											@csrf
											@method('PATCH')
											<button
												class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-500">
												{{ $user->suspended ? 'Unsuspend' : 'Suspend' }}
											</button>
										</form>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>

				<!-- TIMERS TAB -->
				<div x-show="tab === 'timers'">
					<h1 class="text-3xl font-bold mb-6 text-left">Create Countdown Timer</h1>

					<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
						<form action="{{ route('admin.timers.store') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="mb-4">
								<label class="block font-semibold mb-1">Title</label>
								<input type="text" name="title" class="w-full border rounded p-2" required>
							</div>

							<div class="mb-4">
								<label class="block font-semibold mb-1">Image</label>
								<input type="file" name="image" class="w-full border rounded p-2">
							</div>

							<div class="mb-4">
								<label class="block font-semibold mb-1">Expiry Date & Time</label>
								<input type="datetime-local" name="expiry_datetime" class="w-full border rounded p-2" required>
							</div>

							<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">
								Save Timer
							</button>
						</form>
					</div>

					<!-- Optional: Display existing timers -->
					@if(isset($timers) && $timers->count())
						<h2 class="text-2xl font-bold mt-10 mb-4">Existing Timers</h2>
						<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
							@foreach($timers as $timer)
								<div class="bg-white shadow p-4 rounded-lg text-center">
									@if($timer->image)
										<img src="{{ asset('storage/'.$timer->image) }}" class="mx-auto rounded-lg mb-3 w-48 h-32 object-cover">
									@endif
									<h3 class="text-lg font-semibold mb-2">{{ $timer->title }}</h3>
									<p class="text-gray-500 text-sm mb-2">
										Expires: {{ \Carbon\Carbon::parse($timer->expiry_datetime)->format('d M Y, h:i A') }}
									</p>
									<a href="#" class="text-blue-600 hover:underline">View Countdown</a>
								</div>
							@endforeach
						</div>
					@endif
				</div>
			</div>
		</div>
	</section>
</x-layout>
