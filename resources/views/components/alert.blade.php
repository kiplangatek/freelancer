@props(['type', 'message'])

@php
	$alertClasses = [
	   'success' => 'bg-green-100 text-green-800',
	   'error' => 'bg-red-100 text-red-800',
	   'warning' => 'bg-yellow-100 text-yellow-800',
	   'info' => 'bg-blue-100 text-blue-800',
    ];

    $iconNames = [
	   'success' => 'checkmark-circle',
	   'error' => 'close-circle',
	   'warning' => 'warning-outline',
	   'info' => 'information-circle',
    ];
@endphp

<div x-data="{ show: true }" x-show="show" class="{{ $alertClasses[$type] }} mb-1 flex items-center rounded-lg p-4">
	<ion-icon name="{{ $iconNames[$type] }}" class="mr-2 text-lg"></ion-icon>
	<span class="flex-1">{{ $message }}</span>
	<button @click="show = false" class="ml-4 text-current">
		<ion-icon name="close" class="text-lg"></ion-icon>
	</button>
</div>
