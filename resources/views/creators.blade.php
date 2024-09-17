<x-layout>
	<x-slot:title>
		Creators
	</x-slot:title>

	<section class="mt-24 px-4 py-6 grid gap-2 md:gap-3 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mx-auto">
		@foreach ($freelancers as $freelancer)
			<div class="bg-white mx-auto rounded-xl shadow-md hover:shadow-lg w-[95%]">
				<div class="block p-6">
					<!-- Freelancer Photo and Info -->
					<div class="flex items-center space-x-4">
						<!-- Semi-Rounded Avatar -->
						<div class="relative h-16 w-16">
							<img src="{{ asset('storage/avatars/' . $freelancer->photo) }}"
							     alt="{{ $freelancer->name }}"
							     class="h-full w-full object-cover rounded-2xl"> <!-- Semi-rounded corners -->
						</div>

						<!-- Freelancer Info -->
						<div>
							<div class="flex items-center">
								<h2 class="text-lg font-semibold text-gray-800">{{ $freelancer->name }}</h2>
								<!-- Verification Badge After Name -->
								@if($freelancer->verified)
									<span class="text-blue-500">
							            <ion-icon name="checkmark-circle" class="text-blue-500"></ion-icon>
							          </span>
								@elseif($freelancer->suspended)
									<span class="text-yellow-500">
							            <ion-icon name="alert-circle" class="text-yellow-500"></ion-icon>
							          </span>
								@endif
							</div>
							<p class="text-sm text-gray-500">{{ $freelancer->email }}</p>
						</div>
					</div>

					<!-- Projects and Rating -->
					<div class="flex justify-between items-center mt-4">
						<!-- Project Count -->
						@php
							$projectCount = $freelancer->services->count();
						@endphp
						<div>
							<p class="text-sm text-gray-500">Projects</p>
							<span class="font-black">
								{{$projectCount}}
							</span>
						</div>

						<!-- Rating (Example hardcoded, can be dynamically replaced) -->
						<div>
							<p class="text-sm text-gray-500">Rating</p>
							<span class="font-black flex items-center">
							<ion-icon class="text-amber-500" name="star"></ion-icon>	{{$freelancer->averageRating}}
							</span>
						</div>
					</div>

					<!-- Action Buttons -->
					<div class="flex justify-between mt-6">
						<a href="{{ route('freelancer.services', $freelancer->id) }}">
							<button class="bg-blue-600 text-white py-2 px-4 rounded-lg">
								Hire now
							</button>
						</a>
						<button class="bg-gray-200 text-gray-800 py-2 px-4 rounded-lg">
							Message
						</button>
					</div>
				</div>
			</div>
		@endforeach

	</section>
</x-layout>
