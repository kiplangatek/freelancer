<x-layout :title="'Home'">
	<style>
		.splash {
			background-image: url('https://www.clarkson.edu/sites/default/files/2023-06/Data-Science-Applied-Hero-1600x900.jpg');
			/* Updated image path */
			background-repeat: no-repeat;
			background-size: cover;
			background-position: center;
			position: relative;
		}

		/* Fade down effect for splash section */
		.splash::after {
			content: "";
			position: absolute;
			bottom: 0;
			left: 0;
			right: 0;
			height: 100px;
			background: linear-gradient(180deg, rgba(223, 221, 221, 0) 0%, rgb(180, 195, 210) 100%);
		}

		/* Brand text with linear gradient */
		.brand-gradient {
			background: linear-gradient(to right, #00b78f, #0036ff);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
		}

		/* Hide scrollbar for WebKit browsers */
		.scrollbar-hidden::-webkit-scrollbar {
			display: none;
		}

		.scrollbar-hidden {
			-ms-overflow-style: none;
			scrollbar-width: none;
			/* Firefox */
		}

		/* Enhance buttons style */
		#scrollLeft,
		#scrollRight {
			transition: opacity 0.3s ease;
		}

		#scrollLeft:hover,
		#scrollRight:hover {
			opacity: 0.8;
		}

	</style>

	<section class="mb-10 w-full bg-gray-200">
		<!-- Splash Section -->
		<div class="splash h-80  flex items-center justify-center w-full pt-20 md:h-96">
			<div class="w-full px-10 py-6 flex items-center justify-center">
				<h1 class="font-bold text-white">
					<span class="text-3xl">Build your Career or</span> <br>
					<span class="brand-gradient text-5xl md:text-8xl">Brand</span>
				</h1>
			</div>
		</div>

		<!-- Why Choose Us Section -->
		<div class="mb-10 px-6 py-10 md:px-12">
			<h2 class="mb-6 text-3xl font-black text-gray-800 text-center">Why Choose Us?</h2>
			<ol class=" mx-auto list-inside space-y-4 px-3 text-gray-800">
				@foreach ([
				    ['icon' => 'briefcase', 'title' => 'Expertise:', 'description' => 'Our team of professionals is highly skilled and experienced in delivering outstanding results.'],
				    ['icon' => 'shield-checkmark', 'title' => 'Scrutiny:', 'description' => 'Our freelancers undergo rigorous assessments to ensure their services meet high standards.'],
				    ['icon' => 'star', 'title' => 'Quality:', 'description' => 'We prioritize quality, ensuring you get the best value for your investment.'],
				    ['icon' => 'happy', 'title' => 'Customer Satisfaction:', 'description' => 'Your satisfaction is our top priority. We strive to exceed your expectations.'],
				] as $item)
					<li class="mx-auto flex items-start space-x-4 text-gray-700 rounded-lg bg-gray-300 md:bg-transparent px-4 py-6 md:py-2 shadow-lg md:shadow-none">
						<ion-icon name="{{ $item['icon'] }}" class=" text-[28px] md:text-3xl " size="large"></ion-icon>
						<div>
							<b class="italic">{{ $item['title'] }}</b> {{ $item['description'] }}
						</div>
					</li>
				@endforeach
			</ol>
		</div>


		<!-- Featured Services Section -->
		<section class="w-full bg-gray-200 py-4">
			<div class="container mx-auto px-4">
				<h2 class="mb-4 text-2xl font-bold text-gray-900">Featured Services</h2>
				<div class="relative">
					<!-- Left Scroll Button -->
					<button id="scrollLeft"
						   class="absolute left-0 top-1/2 z-10 flex hidden -translate-y-1/2 items-center justify-center rounded-full bg-white bg-opacity-50 p-2 text-gray-800 backdrop-blur focus:outline-none">
						<ion-icon name="chevron-back" size="large"></ion-icon>
					</button>

					<!-- Swipe Scroll Section -->
					<div id="scrollContainer"
						class="scrollbar-hidden flex space-x-2 overflow-x-auto scroll-smooth">
						@foreach ($features as $feature)
							{{-- <a href="{{ route('services.show', $feature->id) }}">
								<div class=" w-[360px] flex-shrink-0 rounded-lg bg-white pb-4 shadow-md">
									<img src="{{ asset('storage/services/' . $feature->image) }}"
										alt="{{ $feature->title }}"
										class="mb-4 h-32 w-full rounded-md rounded-b-none object-cover">
									<h3 class="px-2 text-lg font-bold text-gray-800">{{ $feature->title }}</h3>
									<p class="mb-1 px-2 text-sm text-gray-600">
										Ksh. {{ number_format($feature->price) }}</p>
									<h5 class="px-2 text-lg font-semibold text-gray-600">{{ $feature->freelancer->name }}</h5>
								</div>
							</a> --}}
							<a href="{{ route('services.show',$feature->id) }}">
								<div class="h-auto w-[360px] flex-shrink-0 rounded-lg p-2 shadow-md mb-2 bg-gray-100/50">
									<div class="flex w-full gap-x-1 h-24 mb-3">
										<img class=" h-full w-24 rounded-md object-cover" src="{{ asset('storage/services/'.$feature->image) }}" alt="{{ $feature->title }}">
										<div class="ml-2">
											<h4 class="text-sm font-bold mb-1 flex items-center">{{ $feature->title}}</h4>
											<p class="flex items-center underline mb-1" ><ion-icon name="person-circle" class="mr-2 text-2xl"></ion-icon><ion-icon name="at"></ion-icon>{{$feature->freelancer->username }}</p>
											<p class="flex items-center "><ion-icon name="wallet" class="mr-2 text-2xl"></ion-icon>
												<span class="rounded-md bg-green-200 border px-2  border-green-700">{{number_format($feature->price)}}</span>
											</p>
										</div>
									</div>
									<div class="flex mt-3">
										<a href="/services?category={{ $feature->category->id }}" class="py-1 px-2 rounded-2xl bg-blue-200 border border-blue-600">{{ $feature->category->name }}</a>
									</div>
								</div>
							</a>
						@endforeach
					</div>

					<!-- Right Scroll Button -->
					<button id="scrollRight"
						   class="absolute right-0 top-1/2 z-10 flex -translate-y-1/2 items-center justify-center rounded-full bg-white bg-opacity-50 p-2 text-gray-800 backdrop-blur focus:outline-none">
						<ion-icon name="chevron-forward" size="large"></ion-icon>
					</button>
				</div>
			</div>
		</section>
	</section>

	<script>
		const scrollContainer = document.getElementById('scrollContainer')
		const scrollLeft = document.getElementById('scrollLeft')
		const scrollRight = document.getElementById('scrollRight')

		const updateButtons = () => {
			const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth

			// Update visibility based on scroll position
			scrollLeft.style.display = scrollContainer.scrollLeft > 0 ? 'flex' : 'none'
			scrollRight.style.display = scrollContainer.scrollLeft < maxScrollLeft ? 'flex' : 'none'
		}

		scrollLeft.addEventListener('click', () => {
			scrollContainer.scrollBy({
				left: -360,
				behavior: 'smooth',
			})
		})

		scrollRight.addEventListener('click', () => {
			scrollContainer.scrollBy({
				left: 360,
				behavior: 'smooth',
			})
		})

		scrollContainer.addEventListener('scroll', updateButtons)

		// Initialize button visibility
		updateButtons()
	</script>
</x-layout>
