@props([
'id',
'title',
'color' => 'green',
'icon' => '',
'items' => [],
])

<div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-xl p-8 border border-white/20 overflow-hidden">
    <div class="flex items-center mb-6">
        <div class="p-3 rounded-2xl bg-{{ $color }}-100 text-{{ $color }}-600 mr-4">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-{{ $color }}-800">{{ $title }}</h3>
    </div>

    <ul id="{{ $id }}-content"
        class="overflow-hidden transition-all duration-500 ease-in-out space-y-3 max-h-0">
        @foreach ($items as $item)
        <li class="flex items-start space-x-3 text-{{ $color }}-700">
            <svg class="w-5 h-5 mt-1 flex-shrink-0 text-{{ $color }}-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414L9 14.414l-3.707-3.707a1 1 0 011.414-1.414L9 11.586l6.293-6.293a1 1 0 011.414 0z"
                    clip-rule="evenodd" />
            </svg>
            <span>{{ $item }}</span>
        </li>
        @endforeach
    </ul>

    <button id="toggle-{{ $id }}"
        class="mt-6 flex items-center space-x-2 text-{{ $color }}-600 hover:text-{{ $color }}-800 transition">
        <span class="font-semibold">Lihat {{ strtolower($title) }}</span>
        <svg id="{{ $id }}-chevron" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
    </button>
</div>