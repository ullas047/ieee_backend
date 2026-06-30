@extends('layouts.admin')

@section('page-title', 'Events')

@section('content')

    <div class="bg-white rounded shadow p-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Events</h1>

            <a href="{{ route('events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Create Event
            </a>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- EMPTY STATE --}}
        @if($events->count() == 0)
            <div class="text-center py-10 text-gray-500">
                No events found. Create your first event 🚀
            </div>
        @else

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200">

                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Title</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($events as $event)
                            <tr class="hover:bg-gray-50">

                                <td class="p-3 border font-semibold">
                                    {{ $event->title }}
                                </td>

                                <td class="p-3 border">
                                    @if($event->status == 'completed')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">
                                            Completed
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">
                                            upcomming
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3 border text-center space-x-2">

                                    <a href="{{ route('events.show', $event) }}"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        View
                                    </a>

                                    <a href="{{ route('events.edit', $event) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        Edit
                                    </a>

                                    <button type="button" onclick="confirmDelete({{ $event->id }})"
                                        class="bg-red-600 text-white px-3 py-1 rounded">
                                        Delete
                                    </button>

                                    <form id="delete-form-{{ $event->id }}" action="{{ route('events.destroy', $event) }}"
                                        method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="mt-6">
                {{ $events->links() }}
            </div>


        @endif

    </div>
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                showToast("{{ session('success') }}", "success");
            });
        </script>
    @endif
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this event?")) {
                document.getElementById('delete-form-' + id).submit();
                showToast("Event deleted successfully", "success");
            }
        }
    </script>

@endsection