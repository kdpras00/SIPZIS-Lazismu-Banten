@props([
'title',
'color' => 'green',
'icon' => '',
'description' => '',
])

<div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-xl p-8 border border-white/20">
    <div class="flex items-center mb-6">
        <div class="p-3 rounded-2xl bg-{{ $color }}-100 text-{{ $color }}-600 mr-4">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-{{ $color }}-800">{{ $title }}</h3>
    </div>
    <div class="text-{{ $color }}-700 leading-relaxed space-y-4">
        {{ $slot }}
        <p>{{ $description }}</p>
    </div>
</div>