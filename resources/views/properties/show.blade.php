@extends('layouts.app')

@section('content')
@php
    $directionsUrl = $property->latitude && $property->longitude
        ? 'https://www.google.com/maps/dir/?api=1&destination=' . $property->latitude . ',' . $property->longitude
        : 'https://www.google.com/maps/search/?api=1&query=' . urlencode($property->address);
@endphp

<div class="max-w-6xl mx-auto py-8 px-4">
    <a href="{{ route('properties.index') }}" class="text-blue-600 hover:underline mb-6 inline-block">&larr; Back to Listings</a>

    <div class="grid gap-8 lg:grid-cols-[2fr_1fr]">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
            @if($property->image_path)
                <img src="{{ asset('storage/' . $property->image_path) }}" alt="{{ $property->title }}" class="w-full h-96 object-cover">
            @else
                <div class="w-full h-96 bg-gray-200 flex items-center justify-center text-gray-400">No Image Available</div>
            @endif

            <div class="p-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $property->title }}</h1>
                        <div class="text-gray-600 flex flex-wrap items-center gap-2">
                            <span>📍 {{ $property->address }}</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $property->status === 'vacant' ? 'bg-teal-100 text-teal-700' : 'bg-red-100 text-red-700' }}">{{ ucfirst($property->status) }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-teal-600">${{ number_format($property->price, 2) }}/month</p>
                    </div>
                </div>

                <div class="prose prose-slate max-w-none mb-8 text-gray-700">
                    <p>{{ $property->description }}</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 mb-8">
                    <div class="rounded-3xl border border-slate-200 p-5 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-900 mb-2">Directions</h2>
                        <p class="text-sm text-slate-600 mb-4">Get turn-by-turn navigation from anywhere with Google Maps.</p>
                        <a href="{{ $directionsUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center w-full rounded-2xl bg-blue-600 text-white px-4 py-3 text-sm font-semibold hover:bg-blue-700 transition">Open directions</a>
                    </div>
                    <div class="rounded-3xl border border-slate-200 p-5 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-900 mb-2">Interior Images</h2>
                        <p class="text-sm text-slate-600 mb-4">Preview the living spaces, kitchen, and bedrooms.</p>
                        <div class="grid gap-3 sm:grid-cols-2">
                            @if($property->image_path)
                                <img src="{{ asset('storage/' . $property->image_path) }}" alt="Interior view" class="h-28 w-full rounded-2xl object-cover">
                                <img src="{{ asset('storage/' . $property->image_path) }}" alt="Interior view" class="h-28 w-full rounded-2xl object-cover">
                            @else
                                <div class="h-28 w-full rounded-2xl bg-gray-200"></div>
                                <div class="h-28 w-full rounded-2xl bg-gray-200"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-3xl border border-slate-200 p-6 bg-white shadow-sm">
                        <h2 class="text-lg font-semibold text-slate-900 mb-3">Bedrooms & Living Areas</h2>
                        <ul class="space-y-3 text-slate-600">
                            <li class="flex items-start gap-3">
                                <span class="mt-1 text-teal-600">•</span>
                                <div>
                                    <p class="font-semibold text-slate-900">Open plan living room</p>
                                    <p class="text-sm">Comfortable layout ideal for relaxing and entertaining.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 text-teal-600">•</span>
                                <div>
                                    <p class="font-semibold text-slate-900">Modern kitchen</p>
                                    <p class="text-sm">Stainless appliances and generous countertop space.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 text-teal-600">•</span>
                                <div>
                                    <p class="font-semibold text-slate-900">Private master retreat</p>
                                    <p class="text-sm">A relaxing bedroom with storage and a calm atmosphere.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 p-6 bg-white shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900 mb-3">Contact the team</h2>
                <p class="text-slate-600 mb-6">Ask a question, request a tour, or book a viewing in minutes.</p>
                <a href="mailto:leasing@rentalhub.example.com?subject=Request%20info%20about%20{{ urlencode($property->title) }}" class="block w-full rounded-2xl bg-teal-600 text-white text-center px-4 py-3 font-semibold hover:bg-teal-700 transition">Email leasing</a>
                <a href="tel:+18001234567" class="mt-3 block w-full rounded-2xl border border-slate-200 text-slate-900 text-center px-4 py-3 font-semibold hover:bg-slate-50 transition">Call support</a>
            </div>

            <div class="rounded-3xl border border-slate-200 p-6 bg-white shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900 mb-3">Quick facts</h3>
                <dl class="grid gap-3 text-sm text-slate-600">
                    <div class="flex justify-between gap-4 border-b border-slate-100 pb-3">
                        <dt class="font-medium text-slate-900">Address</dt>
                        <dd>{{ $property->address }}</dd>
                    </div>
                    <div class="flex justify-between gap-4 border-b border-slate-100 pb-3">
                        <dt class="font-medium text-slate-900">Status</dt>
                        <dd>{{ ucfirst($property->status) }}</dd>
                    </div>
                    @if($property->latitude && $property->longitude)
                        <div class="flex justify-between gap-4">
                            <dt class="font-medium text-slate-900">Coordinates</dt>
                            <dd>{{ $property->latitude }}, {{ $property->longitude }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            @auth
                @if(auth()->user()->isAdmin())
                    <div class="rounded-3xl border border-slate-200 p-6 bg-white shadow-sm">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Admin Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('properties.edit', $property) }}" class="block rounded-2xl bg-yellow-500 text-white text-center px-4 py-3 font-semibold hover:bg-yellow-600 transition">Edit Listing</a>
                            <form action="{{ route('properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this listing?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-2xl bg-red-500 text-white px-4 py-3 font-semibold hover:bg-red-600 transition">Delete Listing</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </aside>
    </div>
</div>
@endsection
