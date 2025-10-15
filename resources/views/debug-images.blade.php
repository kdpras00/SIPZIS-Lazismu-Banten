@extends('layouts.main')

@section('title', 'Debug Images - SIPZIS')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Debug Images</h1>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Campaign Image Test</h2>

            @if(isset($campaign) && $campaign->photo)
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Campaign Photo:</h3>
                @php
                $imageUrl = filter_var($campaign->photo, FILTER_VALIDATE_URL)
                ? $campaign->photo
                : asset('storage/' . $campaign->photo);
                @endphp
                <p>Image URL: {{ $imageUrl }}</p>
                <img src="{{ $imageUrl }}" alt="Campaign Image" class="w-full h-64 object-cover rounded-lg mt-2">
            </div>
            @else
            <p class="text-gray-600">No campaign photo available</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Category Images Test</h2>

            @if(isset($categoryDetails))
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Category Image:</h3>
                <p>Image URL: {{ $categoryDetails['image'] }}</p>
                <img src="{{ $categoryDetails['image'] }}" alt="Category Image" class="w-full h-64 object-cover rounded-lg mt-2">
            </div>
            @else
            <p class="text-gray-600">No category details available</p>
            @endif
        </div>
    </div>
</div>
@endsection