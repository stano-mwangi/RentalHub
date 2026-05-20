@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-8 text-gray-900">Edit Property</h1>
    <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-lg p-8 space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Property Title</label>
            <input type="text" name="title" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" value="{{ old('title', $property->title) }}" required>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none">{{ old('description', $property->description) }}</textarea>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Address</label>
            <input type="text" name="address" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" value="{{ old('address', $property->address) }}" required>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Monthly Price (USD)</label>
            <input type="number" name="price" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" value="{{ old('price', $property->price) }}" min="0" step="0.01" required>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" required>
                <option value="vacant" {{ old('status', $property->status) == 'vacant' ? 'selected' : '' }}>Vacant</option>
                <option value="occupied" {{ old('status', $property->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Latitude</label>
                <input type="number" name="latitude" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" value="{{ old('latitude', $property->latitude) }}" step="0.0000001">
            </div>
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Longitude</label>
                <input type="number" name="longitude" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none" value="{{ old('longitude', $property->longitude) }}" step="0.0000001">
            </div>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Property Image</label>
            <input type="file" name="image" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none">
            @if($property->image_path)
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                    <img src="{{ asset('storage/' . $property->image_path) }}" alt="Current Image" class="h-40 w-full object-cover rounded-lg">
                </div>
            @endif
        </div>
        <div class="flex gap-4 mt-8">
            <button type="submit" class="bg-gradient-to-r from-teal-500 to-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-teal-600 hover:to-blue-700 transition">Update Property</button>
            <a href="{{ route('admin.properties.index') }}" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-50 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
