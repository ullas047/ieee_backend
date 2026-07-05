@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Committee Members
            </h1>
            <p class="text-gray-500 mt-1">
                Manage all committee members from here.
            </p>
        </div>

        <a href="{{ route('committees.create') }}"
           class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>
            Add Member
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

<form method="GET" class="mb-6 flex flex-wrap gap-4 items-center">

    {{-- Year --}}
    <select
        name="year"
        onchange="this.form.submit()"
        class="rounded-lg border-gray-300"
    >
        @foreach($years as $year)
            <option
                value="{{ $year }}"
                {{ request('year', date('Y')) == $year ? 'selected' : '' }}
            >
                {{ $year }}
            </option>
        @endforeach
    </select>

    {{-- Committee --}}
    <select
        name="committee_type"
        onchange="this.form.submit()"
        class="rounded-lg border-gray-300"
    >

        <option value="all">All Committees</option>

        @foreach($committeeTypes as $type)
            <option
                value="{{ $type }}"
                {{ request('committee_type') == $type ? 'selected' : '' }}
            >
                {{ ucwords(str_replace('_',' ', $type)) }}
            </option>
        @endforeach

    </select>

    {{-- Reset --}}
    <a

        href="{{ route('committees.index') }}"
        class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300"
    >
        Reset
    </a>

</form>


    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-600">
                            Member
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-600">
                            Committee
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-600">
                            Club Position
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-600">
                            Varsity Position
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-gray-600">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                @forelse($committees as $committee)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4">

                            <div class="flex items-center">

                                @if($committee->image)

                                    <img src="{{ asset('storage/'.$committee->image) }}"
                                         class="w-14 h-14 rounded-full object-cover border">

                                @else

                                    <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>

                                @endif

                                <div class="ml-4">
                                    <div class="font-semibold text-gray-800">
                                        {{ $committee->name }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        {{ $committee->club_position }}
                                    </div>
                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-4">

                            <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm">
                                {{ ucwords(str_replace('_',' ',$committee->committee_type)) }}
                            </span>

                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $committee->club_position }}
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $committee->varsity_position ?: '-' }}
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('committees.show',$committee->id) }}"
                                   class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('committees.edit',$committee->id) }}"
                                   class="w-9 h-9 rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-500 hover:text-white flex items-center justify-center transition">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('committees.destroy',$committee->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            onclick="return confirm('Delete this member?')"
                                            class="w-9 h-9 rounded-lg bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition flex items-center justify-center">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center py-12 text-gray-500">

                            <i class="fas fa-users text-5xl mb-4 text-gray-300"></i>

                            <p class="text-lg">
                                No committee members found.
                            </p>

                            <a href="{{ route('committees.create') }}"
                               class="inline-block mt-4 text-indigo-600 hover:text-indigo-800 font-semibold">

                                + Add First Member

                            </a>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-6">
        {{ $committees->links() }}
    </div>

</div>

@endsection