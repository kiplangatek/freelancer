<!-- resources/views/admin/freelancers.blade.php -->
<x-layout :title="'Manage Users'">
	<section class="body-font mt-14 w-full py-10">

		<div class="container mx-auto mt-8 px-4">
			<h1 class="text-3xl font-bold mb-6 text-left">Users</h1>
			<div class="overflow-x-auto">
				<table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
					<thead>
					<tr class="bg-gray-800 text-white text-left">
						<th class="py-3 px-4 text-xs md:text-sm">Name</th>
						<th class="py-3 px-4 text-xs md:text-sm">Email</th>
						<th class="py-3 px-4 text-xs md:text-sm">User Type</th> <!-- New column -->
						<th class="py-3 px-4 text-xs md:text-sm">Status</th>
						<th class="py-3 px-4 text-xs md:text-sm">Actions</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($users as $user)
						<tr class="border-b text-xs md:text-sm">
							<td class="py-3 px-4">{{ $user->name }}</td>
							<td class="py-3 px-4">{{ $user->email }}</td>
							<td class="py-3 px-4">{{ $user->usertype }}</td> <!-- New column data -->
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
	</section>
</x-layout>
