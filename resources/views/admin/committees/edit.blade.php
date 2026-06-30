@extends('layouts.admin')

@section('title', 'Edit Committee Member')

@section('content')
<div class="max-w-5xl mx-auto py-8">

    <div class="bg-white rounded-xl shadow border">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">
                    Edit Committee Member
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Update committee member information
                </p>
            </div>

            <a href="{{ route('committees.index') }}"
               class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100 transition">
                ← Back
            </a>
        </div>

        <form action="{{ route('committees.update',$committee->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Committee -->
                <div>
                    <label class="block mb-2 font-medium text-gray-700">
                        Committee Type
                    </label>

                    <select name="committee_type"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        <optgroup label="Main Branch">
                            <option value="advisor_panel" {{ $committee->committee_type=='advisor_panel' ? 'selected' : '' }}>Advisor Panel</option>

                            <option value="alumni_panel" {{ $committee->committee_type=='alumni_panel' ? 'selected' : '' }}>Alumni Panel</option>

                            <option value="executive_panel" {{ $committee->committee_type=='executive_panel' ? 'selected' : '' }}>Executive Panel</option>

                            <option value="developer" {{ $committee->committee_type=='developer' ? 'selected' : '' }}>Developer</option>
                        </optgroup>

                        <optgroup label="Societies">
                            <option value="computer_society" {{ $committee->committee_type=='computer_society' ? 'selected' : '' }}>
                                Computer Society
                            </option>

                            <option value="robotics_automation_society" {{ $committee->committee_type=='robotics_automation_society' ? 'selected' : '' }}>
                                Robotics & Automation Society
                            </option>

                            <option value="power_energy_society" {{ $committee->committee_type=='power_energy_society' ? 'selected' : '' }}>
                                Power & Energy Society
                            </option>

                            <option value="women_in_engineering" {{ $committee->committee_type=='women_in_engineering' ? 'selected' : '' }}>
                                Women In Engineering
                            </option>
                        </optgroup>

                    </select>
                </div>

                <!-- Name -->
                <div>
                    <label class="block mb-2 font-medium text-gray-700">
                        Member Name
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name',$committee->name) }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Club Position -->
                <div>
                    <label class="block mb-2 font-medium text-gray-700">
                        Club Position
                    </label>

                    <input type="text"
                           name="club_position"
                           value="{{ old('club_position',$committee->club_position) }}"
                           class="w-full rounded-lg border-gray-300">
                </div>

                <!-- Varsity Position -->
                <div>
                    <label class="block mb-2 font-medium text-gray-700">
                        University Position
                    </label>

                    <input type="text"
                           name="varsity_position"
                           value="{{ old('varsity_position',$committee->varsity_position) }}"
                           class="w-full rounded-lg border-gray-300">
                </div>

                <!-- Facebook -->
                <div>
                    <label class="block mb-2 font-medium text-gray-700">
                        Facebook Link
                    </label>

                    <input type="url"
                           name="facebook_link"
                           value="{{ old('facebook_link',$committee->facebook_link) }}"
                           class="w-full rounded-lg border-gray-300">
                </div>

                <!-- Linkedin -->
                <div>
                    <label class="block mb-2 font-medium text-gray-700">
                        LinkedIn Link
                    </label>

                    <input type="url"
                           name="linkedin_link"
                           value="{{ old('linkedin_link',$committee->linkedin_link) }}"
                           class="w-full rounded-lg border-gray-300">
                </div>

            </div>

            <!-- Image -->
            <div class="mt-8">

                <label class="block mb-3 font-medium text-gray-700">
                    Profile Image
                </label>

                <div class="flex items-center gap-6">

                    @if($committee->image)
                        <img id="preview"
                             src="{{ asset('storage/'.$committee->image) }}"
                             class="w-36 h-36 rounded-xl object-cover border shadow">
                    @else
                        <img id="preview"
                             src="https://placehold.co/150x150"
                             class="w-36 h-36 rounded-xl object-cover border shadow">
                    @endif

                    <div class="flex-1">
                        <input type="file"
                               name="image"
                               id="imageInput"
                               class="block w-full text-sm text-gray-700
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg
                                      file:border-0
                                      file:bg-blue-600
                                      file:text-white
                                      hover:file:bg-blue-700">
                    </div>

                </div>

            </div>

            <!-- Buttons -->
            <div class="mt-8 flex justify-end gap-3">

                <a href="{{ route('committees.index') }}"
                   class="px-5 py-2 rounded-lg border text-gray-700 hover:bg-gray-100">
                    Cancel
                </a>

                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                    Update Member
                </button>

            </div>

        </form>

    </div>

</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if(file){
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
});
</script>
@endsection