@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-teal-500 to-blue-600 py-10 mb-8">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Find Your Next Home</h1>
        <p class="text-blue-100 mb-6">Browse available rentals with updated status, location search, and detailed listings.</p>
        <form method="GET" action="{{ route('properties.index') }}" class="flex flex-col md:flex-row gap-3 justify-center items-center max-w-2xl mx-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by address or title..." class="rounded px-4 py-2 w-full md:w-72 focus:ring-2 focus:ring-blue-400">
            <select name="status" class="rounded px-4 py-2 w-full md:w-40 focus:ring-2 focus:ring-blue-400">
                <option value="">All Statuses</option>
                <option value="vacant" {{ request('status') === 'vacant' ? 'selected' : '' }}>Vacant</option>
                <option value="occupied" {{ request('status') === 'occupied' ? 'selected' : '' }}>Occupied</option>
            </select>
            <button type="submit" class="bg-gradient-to-r from-teal-500 to-blue-600 text-white px-6 py-2 rounded font-semibold shadow hover:from-teal-600 hover:to-blue-700 transition">Search</button>
        </form>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4">
    @auth
        @if(auth()->user()->isAdmin())
            <div class="flex justify-end mb-6">
                <a href="{{ route('properties.create') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white px-5 py-2 rounded-xl shadow hover:bg-slate-800 transition">Add New Listing</a>
            </div>
        @endif
    @endauth

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="flex-1">
            @if($properties->isEmpty())
                <div class="text-gray-500">No properties found.</div>
            @else
                <div class="flex flex-col gap-6">
                    @foreach($properties as $property)
                        <div class="bg-white rounded-xl shadow flex flex-col md:flex-row overflow-hidden hover:shadow-lg transition">
                            <div class="md:w-56 flex-shrink-0 h-40 md:h-auto bg-gray-100 flex items-center justify-center">
                                @if($property->image_path)
                                    <img src="{{ asset('storage/' . $property->image_path) }}" alt="{{ $property->title }}" class="object-cover w-full h-full md:h-40 md:w-56">
                                @else
                                    <span class="text-gray-400">No Image</span>
                                @endif
                            </div>
                            <div class="flex-1 p-4 flex flex-col">
                                <div class="flex items-center gap-2 mb-1">
                                    <h2 class="text-xl font-semibold text-blue-900 flex-1">{{ $property->title }}</h2>
                                    <span class="inline-block px-2 py-1 rounded text-xs {{ $property->status === 'vacant' ? 'bg-teal-100 text-teal-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($property->status) }}
                                    </span>
                                </div>
                                <div class="text-gray-600 mb-1">{{ $property->address }}</div>
                                <div class="text-blue-700 font-bold mb-2">${{ number_format($property->price, 2) }}</div>
                                <div class="text-gray-500 text-sm mb-4">{{ \Illuminate\Support\Str::limit($property->description, 90) }}</div>
                                <a href="{{ route('properties.show', $property) }}" class="mt-auto inline-block bg-gradient-to-r from-teal-500 to-blue-600 text-white px-4 py-2 rounded font-semibold shadow hover:from-teal-600 hover:to-blue-700 transition">View Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            @endif
        </div>
        <div class="lg:w-1/3 hidden lg:block">
            <div class="sticky top-24">
                <div class="rounded-xl shadow bg-white overflow-hidden h-96 flex items-center justify-center p-6 text-center">
                    <div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-3">Neighborhood Snapshot</h3>
                        <p class="text-slate-500">Filter by location or status to narrow your search, then click details for directions, interior highlights, and contact options.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
