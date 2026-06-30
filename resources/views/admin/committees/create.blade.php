@extends('layouts.admin')

@section('title', 'Add Committee Member')

@section('content')

    <div class="max-w-6xl mx-auto px-6 py-8">

        <!-- Heading -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Add Committee Member
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Enter the committee member information below.
                </p>
            </div>

            <a href="{{ route('committees.index') }}"
                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition">
                ← Back
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                <ul class="list-disc list-inside text-red-600 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('committees.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left -->
                <div class="lg:col-span-2 bg-white shadow rounded-lg p-6">

                    <div class="grid md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Committee Type
                            </label>

                            <select name="committee_type"
                                class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                                <option value="">Select Committee</option>

                                <optgroup label="Main Branch">
                                    <option value="advisor_panel">Advisor Panel</option>
                                    <option value="alumni_panel">Alumni Panel</option>
                                    <option value="executive_panel">Executive Panel</option>
                                    <option value="developer">Developer Team</option>
                                </optgroup>

                                <optgroup label="Societies">
                                    <option value="computer_society">Computer Society</option>
                                    <option value="robotics_automation_society">Robotics & Automation Society</option>
                                    <option value="power_energy_society">Power & Energy Society</option>
                                    <option value="women_in_engineering">Women In Engineering</option>
                                </optgroup>

                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Committee Year
                            </label>

                            <select name="year"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                @for($y = date('Y') + 1; $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ old('year', $committee->year ?? date('Y')) == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Member Name
                            </label>

                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Club Position
                            </label>

                            <input type="text" name="club_position" value="{{ old('club_position') }}"
                                class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                University Position
                            </label>

                            <input type="text" name="varsity_position" value="{{ old('varsity_position') }}"
                                placeholder="Leave empty if Student"
                                class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2">
                                Facebook Link
                            </label>

                            <input type="url" name="facebook_link" value="{{ old('facebook_link') }}"
                                class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2">
                                LinkedIn Link
                            </label>

                            <input type="url" name="linkedin_link" value="{{ old('linkedin_link') }}"
                                class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                    </div>

                </div>

                <!-- Right -->
                <div class="bg-white shadow rounded-lg p-6">

                    <label class="block text-sm font-medium mb-4">
                        Profile Image
                    </label>

                    <img id="preview-image" src="https://via.placeholder.com/250x250?text=Photo"
                        class="w-48 h-48 rounded-lg object-cover border mx-auto mb-5">

                    <input type="file" id="imageInput" name="image" accept="image/*" class="w-full text-sm">

                    <button type="submit"
                        class="mt-8 w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition">
                        Save Member
                    </button>

                </div>

            </div>

        </form>

    </div>

    <script>
        document.getElementById('imageInput').addEventListener('change', function (e) {

            const file = e.target.files[0];

            if (file) {
                document.getElementById('preview-image').src =
                    URL.createObjectURL(file);
            }

        });
    </script>

@endsection