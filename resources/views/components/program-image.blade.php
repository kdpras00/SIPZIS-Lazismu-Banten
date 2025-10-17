@props(['category', 'alt'])

@php
$program = \App\Models\Program::byCategory($category)->first();
$imageUrl = $program ? $program->image_url : asset('img/program/' . $category . '.jpg');
@endphp

<img src="{{ $imageUrl }}" alt="{{ $alt }}" {{ $attributes }}>