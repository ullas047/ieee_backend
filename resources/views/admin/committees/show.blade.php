@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Committee Member Details
            </h1>
            <p class="text-gray-500 mt-1">
                View committee member information.
            </p>
        </div>

        <a href="{{ route('committees.index') }}"
           class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700 transition">
            ← Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">

        <div class="p-8">

            <div class="flex flex-col md:flex-row gap-8">

                <!-- Image -->
                <div class="md:w-1/3 flex justify-center">

                    @if($committee->image)
                        <img src="{{ asset('storage/'.$committee->image) }}"
                             class="w-56 h-56 rounded-xl object-cover border shadow">
                    @else
                        <div class="w-56 h-56 rounded-xl bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-user text-6xl text-gray-400"></i>
                        </div>
                    @endif

                </div>

                <!-- Details -->
                <div class="flex-1">

                    <h2 class="text-3xl font-bold text-gray-800">
                        {{ $committee->name }}
                    </h2>

                    <p class="mt-2 text-lg text-indigo-600 font-semibold">
                        {{ $committee->club_position }}
                    </p>

                    <div class="mt-6 border rounded-lg divide-y">

                        <div class="flex justify-between px-5 py-4">
                            <span class="font-medium text-gray-600">
                                Committee
                            </span>

                            <span class="text-gray-800">
                                {{ ucwords(str_replace('_',' ',$committee->committee_type)) }}
                            </span>
                        </div>

                        <div class="flex justify-between px-5 py-4">
                            <span class="font-medium text-gray-600">
                                Club Position
                            </span>

                            <span>{{ $committee->club_position }}</span>
                        </div>

                        <div class="flex justify-between px-5 py-4">
                            <span class="font-medium text-gray-600">
                                Varsity Position
                            </span>

                            <span>
                                {{ $committee->varsity_position ?: 'Student' }}
                            </span>
                        </div>

                        <div class="flex justify-between px-5 py-4">
                            <span class="font-medium text-gray-600">
                                Facebook
                            </span>

                            <span>
                                @if($committee->facebook_link)
                                    <a href="{{ $committee->facebook_link }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline">
                                        Visit Profile
                                    </a>
                                @else
                                    —
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between px-5 py-4">
                            <span class="font-medium text-gray-600">
                                LinkedIn
                            </span>

                            <span>
                                @if($committee->linkedin_link)
                                    <a href="{{ $committee->linkedin_link }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline">
                                        Visit Profile
                                    </a>
                                @else
                                    —
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between px-5 py-4">
                            <span class="font-medium text-gray-600">
                                Added On
                            </span>

                            <span>
                                {{ $committee->created_at->format('d M Y') }}
                            </span>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 flex gap-3">

                        <a href="{{ route('committees.edit',$committee->id) }}"
                           class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                            Edit Member
                        </a>

                        <a href="{{ route('committees.index') }}"
                           class="px-5 py-2 border border-gray-300 hover:bg-gray-100 rounded-lg transition">
                            Back
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection