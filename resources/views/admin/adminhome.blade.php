@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
	<h1 class="text-3xl font-bold mb-4 text-gray-900">Welcome, {{ $admin->name }}</h1>
	<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
		<div class="bg-white rounded-xl shadow p-6 text-center">
			<div class="text-2xl font-bold text-blue-700">{{ $stats['total'] }}</div>
			<div class="text-gray-600 mt-2">Total Properties</div>
		</div>
		<div class="bg-white rounded-xl shadow p-6 text-center">
			<div class="text-2xl font-bold text-teal-600">{{ $stats['vacant'] }}</div>
			<div class="text-gray-600 mt-2">Vacant</div>
		</div>
		<div class="bg-white rounded-xl shadow p-6 text-center">
			<div class="text-2xl font-bold text-red-600">{{ $stats['occupied'] }}</div>
			<div class="text-gray-600 mt-2">Occupied</div>
		</div>
	</div>

	<div class="flex justify-between items-center mb-6">
		<h2 class="text-2xl font-semibold text-gray-800">Your Properties</h2>
		<a href="{{ route('properties.create') }}" class="bg-gradient-to-r from-teal-500 to-blue-600 text-white px-5 py-2 rounded-lg font-semibold shadow hover:from-teal-600 hover:to-blue-700 transition">Add New Property</a>
	</div>

	@if($properties->isEmpty())
		<div class="text-gray-500">You have not added any properties yet.</div>
	@else
		<div class="overflow-x-auto">
			<table class="min-w-full bg-white rounded-xl shadow">
				<thead>
					<tr class="bg-gray-100 text-gray-700">
						<th class="py-3 px-4 text-left">Title</th>
						<th class="py-3 px-4 text-left">Address</th>
						<th class="py-3 px-4 text-left">Status</th>
						<th class="py-3 px-4 text-left">Price</th>
						<th class="py-3 px-4 text-left">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($properties as $property)
						<tr class="border-b last:border-0">
							<td class="py-3 px-4 font-semibold text-blue-900">{{ $property->title }}</td>
							<td class="py-3 px-4">{{ $property->address }}</td>
							<td class="py-3 px-4">
								<span class="inline-block px-2 py-1 rounded text-xs {{ $property->status === 'vacant' ? 'bg-teal-100 text-teal-700' : 'bg-red-100 text-red-700' }}">
									{{ ucfirst($property->status) }}
								</span>
							</td>
							<td class="py-3 px-4">${{ number_format($property->price, 2) }}</td>
							<td class="py-3 px-4 flex gap-2">
								<a href="{{ route('properties.show', $property) }}" class="text-blue-600 hover:underline">View</a>
								<a href="{{ route('properties.edit', $property) }}" class="text-yellow-600 hover:underline">Edit</a>
								<form action="{{ route('properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="text-red-600 hover:underline">Delete</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="mt-6">
			{{ $properties->links() }}
		</div>
	@endif
</div>
@endsection
