@extends('layouts.admin')

@section('content')

<div class="bg-white p-6 rounded shadow space-y-6">

    {{-- BANNER IMAGE --}}
    @if($event->banner_image)
        <img src="{{ asset('storage/' . $event->banner_image) }}"
             class="w-full h-64 object-cover rounded">
    @endif

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold">{{ $event->title }}</h1>
     @if($event->subtitle)
            <p class="text-gray-600 mt-1">{{ $event->subtitle }}</p>
        @endif
    </div>

    {{-- BASIC INFO --}}
    <div class="grid grid-cols-2 gap-4 text-sm bg-gray-50 p-4 rounded">

        <p><strong>Venue:</strong> {{ $event->venue ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($event->status) }}</p>

        <p><strong>Start:</strong>
            {{ \Carbon\Carbon::parse($event->start_datetime)->format('d M Y, h:i A') }}
        </p>

        <p><strong>End:</strong>
            {{ \Carbon\Carbon::parse($event->end_datetime)->format('d M Y, h:i A') }}
        </p>
        <p><strong>Prerequisites:</strong> {{ $event->prerequisites ?? 'N/A' }}</p>
        <p><strong>Fee:</strong> {{ $event->registration_fee ?? 'Free' }}</p>

        <p><strong>Registration:</strong>
            @if($event->registration_link)
                <a href="{{ $event->registration_link }}"
                   class="text-blue-600 underline"
                   target="_blank">
                    Open Link
                </a>
            @else
                N/A
            @endif
        </p>

    </div>

    {{-- DESCRIPTION --}}
    <div>
        <h2 class="text-xl font-bold mb-2">Description</h2>

        <p class="text-gray-700 leading-relaxed whitespace-pre-line">
            {{ $event->description }}
        </p>
    </div>

    {{-- TAGS --}}
    @php
        $tags = is_array($event->tags)
            ? $event->tags
            : json_decode($event->tags ?? '[]', true);
    @endphp

    @if(!empty($tags))
        <div>
            <h2 class="text-xl font-bold mb-2">Tags</h2>

            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <span class="bg-gray-200 px-3 py-1 rounded-full text-sm">
                        {{ $tag }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- SPEAKERS --}}
    @if($event->speakers && $event->speakers->count())
        <div>
            <h2 class="text-xl font-bold mb-3">Speakers</h2>

            <div class="grid md:grid-cols-3 gap-4">
                @foreach($event->speakers as $speaker)
                    <div class="border p-4 rounded text-center">

                        {{-- IMAGE --}}
                        <img src="{{ $speaker->image
                                    ? asset('storage/' . $speaker->image)
                                    : 'https://via.placeholder.com/150' }}"
                             class="w-24 h-24 mx-auto rounded-full object-cover mb-2"
                             alt="Speaker">

                        <p class="font-bold">{{ $speaker->name }}</p>
                        <p class="text-sm text-gray-600">{{ $speaker->title }}</p>

                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- AGENDA --}}
    @if($event->agendas && $event->agendas->count())
        <div>
            <h2 class="text-xl font-bold mb-3">Agenda</h2>

            <div class="space-y-3">
                @foreach($event->agendas as $agenda)
                    <div class="border-l-4 border-blue-500 pl-3">

                        <p class="text-sm text-gray-600">
                            {{ $agenda->start_time }} - {{ $agenda->end_time }}
                        </p>

                        <p class="font-medium">
                            {{ $agenda->topic }}
                        </p>

                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- HIGHLIGHTS --}}
    @if($event->highlights && $event->highlights->count())
        <div>
            <h2 class="text-xl font-bold mb-3">Highlights</h2>

            <ul class="list-disc ml-5 space-y-1">
                @foreach($event->highlights as $highlight)
                    <li>{{ $highlight->text }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

@endsection