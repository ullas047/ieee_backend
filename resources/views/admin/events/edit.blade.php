@extends('layouts.admin')

@section('page-title', 'Edit Event')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Edit Event</h1>

    <div class="grid grid-cols-3 gap-6">

        {{-- LEFT FORM --}}
        <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data"
            class="col-span-2 bg-white p-6 rounded shadow space-y-6">

            @csrf
            @method('PUT')
            <div>
                <label class="block font-semibold mb-1">Banner Image</label>

                {{-- Existing image --}}
                @if($event->banner_image)
                    <img src="{{ asset('storage/' . $event->banner_image) }}"
                        class="w-full h-48 object-cover rounded mb-3 border">
                @endif

                {{-- New upload --}}
                <input type="file" name="banner_image" id="banner_image" class="border p-2 w-full" accept="image/*">

                {{-- Preview new image --}}

                {{-- Preview --}}
                <img id="bannerPreview" src="" class="hidden mt-3 w-full h-48 object-cover rounded border"
                    alt="Preview Image">
            </div>

            {{-- BASIC INFO --}}
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="title" value="{{ old('title', $event->title) }}" class="border p-2 rounded">

                <input type="text" name="subtitle" value="{{ old('subtitle', $event->subtitle) }}"
                    class="border p-2 rounded">
            </div>

            <textarea name="description"
                class="w-full border p-2 rounded">{{ old('description', $event->description) }}</textarea>

            <div class="grid grid-cols-2 gap-4">
                <input type="datetime-local" name="start_datetime"
                    value="{{ old('start_datetime', \Carbon\Carbon::parse($event->start_datetime)->format('Y-m-d\TH:i')) }}"
                    class="border p-2 rounded">

                <input type="datetime-local" name="end_datetime"
                    value="{{ old('end_datetime', \Carbon\Carbon::parse($event->end_datetime)->format('Y-m-d\TH:i')) }}"
                    class="border p-2 rounded">
            </div>
            <input type="text" name="prerequisites" value="{{ old('prerequisites', $event->prerequisites) }}"
                class="w-full border p-2 rounded" placeholder="Prerequisites">

            <input type="text" name="venue" value="{{ old('venue', $event->venue) }}" class="w-full border p-2 rounded">

            <input type="text" name="registration_fee" value="{{ old('registration_fee', $event->registration_fee) }}"
                class="w-full border p-2 rounded">

            <input type="text" name="registration_link" value="{{ old('registration_link', $event->registration_link) }}"
                class="w-full border p-2 rounded">

            <select name="status" class="w-full border p-2 rounded">
                <option value="upcomming" @selected($event->status == 'upcomming')>upcomming</option>
                <option value="completed" @selected($event->status == 'completed')>completed</option>
            </select>

            <h2 class="text-lg font-bold mb-2">Speakers</h2>

            <div id="speakers-wrapper">
                @foreach($event->speakers as $i => $speaker)
                    <div class="border p-3 my-2 space-y-2">

                        <input type="text" name="speakers[{{ $i }}][name]" value="{{ $speaker->name }}"
                            class="w-full border p-2">

                        <input type="text" name="speakers[{{ $i }}][title]" value="{{ $speaker->title }}"
                            class="w-full border p-2">

                        {{-- CURRENT IMAGE --}}
                        @if($speaker->image)
                            <img src="{{ asset('storage/' . $speaker->image) }}" class="w-16 h-16 rounded-full object-cover mb-2">
                        @endif

                        {{-- NEW IMAGE --}}
                        <input type="file" name="speakers[{{ $i }}][image]" class="w-full border p-2 speaker-image-input"
                            accept="image/*" onchange="previewSpeakerImage(event, {{ $i }})">

                        <img id="speaker-preview-{{ $i }}"
                            src="{{ $speaker->image ? asset('storage/' . $speaker->image) : '' }}"
                            class="w-16 h-16 rounded-full object-cover mt-2 {{ $speaker->image ? '' : 'hidden' }}"
                            alt="Speaker Preview">


                    </div>
                @endforeach
                <button type="button" onclick="addSpeaker()" class="bg-blue-500 text-white px-3 py-1 rounded mt-2">
                    + Add Speaker
                </button>
            </div>

            {{-- ================= AGENDA ================= --}}
            <div>
                <h2 class="text-lg font-bold mb-2">Agenda</h2>

                <div id="agenda-wrapper">

                    @foreach($event->agendas as $i => $agenda)
                        <div class="border p-3 my-2 grid grid-cols-3 gap-2">
                            <input type="time" name="agenda[{{ $i }}][start_time]" value="{{ $agenda->start_time }}"
                                class="border p-2">

                            <input type="time" name="agenda[{{ $i }}][end_time]" value="{{ $agenda->end_time }}"
                                class="border p-2">

                            <input type="text" name="agenda[{{ $i }}][topic]" value="{{ $agenda->topic }}" class="border p-2">
                        </div>
                    @endforeach

                </div>

                <button type="button" onclick="addAgenda()" class="bg-green-500 text-white px-3 py-1 rounded mt-2">
                    + Add Agenda
                </button>
            </div>

            {{-- ================= HIGHLIGHTS ================= --}}
            <div>
                <h2 class="text-lg font-bold mb-2">Highlights</h2>

                <div id="highlight-wrapper">

                    @foreach($event->highlights as $i => $highlight)
                        <div class="border p-3 my-2">
                            <input type="text" name="highlights[{{ $i }}][text]" value="{{ $highlight->text }}"
                                class="w-full border p-2">
                        </div>
                    @endforeach

                </div>
                <button type="button" onclick="addHighlight()" class="bg-purple-500 text-white px-3 py-1 rounded mt-2">
                    + Add Highlight
                </button>
                <div>
                    <h2 class="text-lg font-bold mb-2">Tags</h2>

                    <input type="text" id="tag-input" placeholder="Type tag and press Enter"
                        class="w-full border p-2 rounded">

                    <div id="tags-wrapper" class="flex flex-wrap gap-2 mt-2"></div>

                    <input type="hidden" name="tags" id="tags-hidden">
                </div>
            </div>

            <button class="bg-black text-white px-6 py-2 rounded">
                Update Event
            </button>
        </form>

    </div>

    {{-- JS --}}
    <script>
        let speakerIndex = {{ $event->speakers->count() }};
        let agendaIndex = {{ $event->agendas->count() }};
        let highlightIndex = {{ $event->highlights->count() }};

        function addSpeaker() {
            document.getElementById('speakers-wrapper').insertAdjacentHTML('beforeend', `
                                        <div class="border p-3 my-2 space-y-2">
                                            <input type="text" name="speakers[${speakerIndex}][name]" class="w-full border p-2" placeholder="Name">
                                            <input type="text" name="speakers[${speakerIndex}][title]" class="w-full border p-2" placeholder="Title">
                                            <input type="file" name="speakers[${speakerIndex}][image]" class="w-full border p-2" placeholder="Image">
                                        </div>
                                    `);
            speakerIndex++;
        }

        document.getElementById('banner_image').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const preview = document.getElementById('bannerPreview');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        });

        function previewSpeakerImage(event, index) {

            const file = event.target.files[0];
            const preview = document.getElementById(`speaker-preview-${index}`);

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        }


        function addAgenda() {
            document.getElementById('agenda-wrapper').insertAdjacentHTML('beforeend', `
                                        <div class="border p-3 my-2 grid grid-cols-3 gap-2">
                                            <input type="time" name="agenda[${agendaIndex}][start_time]" class="border p-2">
                                            <input type="time" name="agenda[${agendaIndex}][end_time]" class="border p-2">
                                            <input type="text" name="agenda[${agendaIndex}][topic]" class="border p-2" placeholder="Topic">
                                        </div>
                                    `);
            agendaIndex++;
        }

        function addHighlight() {
            document.getElementById('highlight-wrapper').insertAdjacentHTML('beforeend', `
                                        <div class="border p-3 my-2">
                                            <input type="text" name="highlights[${highlightIndex}][text]" class="w-full border p-2" placeholder="Highlight">
                                        </div>
                                    `);
            highlightIndex++;
        }
        let tags = @json($event->tags ? json_decode($event->tags) : []);

        renderTags();

        document.getElementById('tag-input').addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();

                let value = this.value.trim();
                if (!value) return;

                tags.push(value);
                this.value = '';

                renderTags();
            }
        });

        function renderTags() {
            document.getElementById('tags-wrapper').innerHTML =
                tags.map((tag, i) => `
                                            <span class="bg-gray-200 px-3 py-1 rounded-full flex items-center gap-2">
                                                ${tag}
                                                <button type="button" onclick="removeTag(${i})">x</button>
                                            </span>
                                        `).join('');

            document.getElementById('tags-hidden').value = JSON.stringify(tags);
        }

        function removeTag(index) {
            tags.splice(index, 1);
            renderTags();
        }
    </script>

@endsection