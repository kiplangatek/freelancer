<x-layout :title="$application->service->title">
	<section class="body-font mt-16 w-full items-center px-6 py-10">
		<div class="z-40 mx-auto mt-4 flex w-[95%] transform items-center gap-1">
			<div>
				<a href="/my"
				   class="flex h-14 w-fit items-center rounded-lg bg-blue-200 bg-opacity-60 px-1 text-lg font-bold backdrop-blur-lg hover:bg-opacity-70 md:h-16">
					<ion-icon class="mx-1 text-2xl" name="chevron-back-circle-outline"></ion-icon>
					<span class="hidden md:block">Back</span>
				</a>
			</div>
			<div
				class="flex h-14 flex-1 items-center justify-between rounded-lg bg-blue-200 bg-opacity-70 px-2 backdrop-blur-lg md:h-16">
				<div class="flex items-center text-[16px] font-semibold md:text-xl">
					{{ $application->service->title }}
				</div>
				<div class="mr-1">
					<p
						class="{{ $application->status ? 'bg-green-100 text-green-700' : 'bg-yellow-50 text-yellow-700' }} inline-block rounded-xl px-2 py-2 text-sm font-bold">
						{{ $application->status ? '✔ Completed' : '! Pending' }}
					</p>
				</div>
			</div>
		</div>
		<div class="container mx-auto mt-5">
			<!-- Freelancer Name and Service Price -->
			<div class="mb-2 flex items-center justify-between">
				<p class="text-lg font-black text-gray-900">
					{{ $application->service->freelancer->name ?? 'No Freelancer' }}
				</p>
				<p class="rounded-md bg-green-100 px-2 py-1 text-lg text-gray-600 shadow-sm">
					Ksh. {{ number_format($application->service->price) }}
				</p>
			</div>
			<!-- Service Image -->
			<div class="mb-3">
				@if ($application->service->image)
					<img src="{{ asset('storage/services/' . $application->service->image) }}" alt="Service Image"
						class="h-48 w-full rounded-md object-cover shadow-lg">
				@else
					<p class="italic text-gray-500">No Image Available</p>
				@endif
			</div>

			<!-- Service Details -->
			<div class="bg-trasparent px-4 py-6 leading-relaxed text-gray-950">
				{!! $application->service->details !!}
			</div>

			<!-- Actions Section -->
			<div class="mt-6 flex items-center justify-start">
				@if (!$application->status)
					<form action="{{ route('applications.cancel', $application->id) }}" method="POST"
						 onsubmit="return confirm('Are you sure you want to cancel this application?');">
						@csrf
						@method('DELETE')
						<button type="submit"
							   class="w-full rounded-md bg-red-600 px-4 py-2 text-white shadow-lg transition duration-300 hover:bg-red-700">
							Cancel Application
						</button>
					</form>
				@endif

			</div>
			<!-- Status Messages -->
			@if (session('status'))
				<div class="mt-6 rounded bg-green-100 p-4 text-green-800">
					{{ session('status') }}
				</div>
			@endif
		</div>
	</section>
</x-layout>
