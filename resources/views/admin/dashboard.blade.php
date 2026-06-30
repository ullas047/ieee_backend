@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold">
            Total Events
        </h3>

        <p class="text-3xl font-bold mt-2">
            {{ $totalEvents }}
        </p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold">
            Upcoming Events
        </h3>

        <p class="text-3xl font-bold mt-2">
            {{ $upcomingEvents }}
        </p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold">
            Completed Events
        </h3>

        <p class="text-3xl font-bold mt-2">
            {{ $completedEvents }}
        </p>
    </div>

</div>

@endsection