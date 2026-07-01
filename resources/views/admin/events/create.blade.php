@extends('layouts.admin')

@section('page-title', 'Create Event')

@section('content')

<h1 class="text-2xl font-bold mb-6">Create Event</h1>

<div class="grid grid-cols-3 gap-6 items-start">

    {{-- LEFT FORM --}}
    <form method="POST"
          action="{{ route('events.store') }}"
          enctype="multipart/form-data"
          class="col-span-2 bg-white p-6 rounded shadow space-y-6">

        @csrf

        {{-- BASIC INFO --}}
        <div class="grid grid-cols-2 gap-4">

            <input type="text"
                   name="title"
                   placeholder="Title"
                   class="border p-2 rounded">

            <input type="text"
                   name="subtitle"
                   placeholder="Subtitle"
                   class="border p-2 rounded">

        </div>

        {{-- Banner --}}
        <div>
            <label class="block mb-2 font-medium">
                Banner Image
            </label>

            <input type="file"
                   name="banner_image"
                   class="form-control">
        </div>

        <div>
            <img id="bannerPreview"
                 class="hidden w-full h-48 object-cover rounded border">
        </div>

        {{-- Description --}}
        <textarea name="description"
                  placeholder="Description"
                  class="w-full border p-2 rounded"
                  rows="5"></textarea>

        {{-- Date Time --}}
        <div class="grid grid-cols-2 gap-4">
            <p class="col-span-2 font-medium text-gray-700">
                Event Date & Time  </p>
            <input type="datetime-local" 
                   name="start_datetime"
                   class="border p-2 rounded">

            <input type="datetime-local" 
                   name="end_datetime"
                   class="border p-2 rounded">

        </div>

        {{-- Prerequisites --}}
        <input type="text"
               name="prerequisites"
               placeholder="Prerequisites"
               class="w-full border p-2 rounded">

        {{-- Venue --}}
        <input type="text"
               name="venue"
               placeholder="Venue"
               class="w-full border p-2 rounded">

        {{-- Registration Fee --}}
        <input type="text"
               name="registration_fee"
               placeholder="Registration Fee"
               class="w-full border p-2 rounded">

        {{-- Registration Link --}}
        <input type="text"
               name="registration_link"
               placeholder="Registration Link"
               class="w-full border p-2 rounded">

        {{-- Status --}}
        <select name="status"
                class="w-full border p-2 rounded">

            <option value="upcoming">Upcoming</option>
            <option value="completed">Completed</option>

        </select>

        {{-- ================= SPEAKERS ================= --}}
        <div>

            <h2 class="text-lg font-bold mb-2">
                Speakers
            </h2>

            <div id="speakers-wrapper"></div>

            <button
                type="button"
                onclick="addSpeaker()"
                class="bg-blue-500 text-white px-3 py-1 rounded mt-2">

                + Add Speaker

            </button>

        </div>

                {{-- ================= AGENDA ================= --}}
        <div>

            <h2 class="text-lg font-bold mb-2">
                Agenda
            </h2>

            <div id="agenda-wrapper"></div>

            <button
                type="button"
                onclick="addAgenda()"
                class="bg-green-500 text-white px-3 py-1 rounded mt-2">

                + Add Agenda

            </button>

        </div>

        {{-- ================= HIGHLIGHTS ================= --}}
        <div>

            <h2 class="text-lg font-bold mb-2">
                Highlights
            </h2>

            <div id="highlight-wrapper"></div>

            <button
                type="button"
                onclick="addHighlight()"
                class="bg-purple-500 text-white px-3 py-1 rounded mt-2">

                + Add Highlight

            </button>

        </div>

        {{-- ================= TAGS ================= --}}
        <div>

            <h2 class="text-lg font-bold mb-2">
                Tags
            </h2>

            <input
                type="text"
                id="tag-input"
                placeholder="Type tag and press Enter"
                class="w-full border p-2 rounded">

            <div
                id="tags-wrapper"
                class="flex flex-wrap gap-2 mt-2">
            </div>

            <input
                type="hidden"
                name="tags"
                id="tags-hidden">

        </div>

        {{-- Submit --}}
        <button
            type="submit"
            class="bg-black text-white px-6 py-2 rounded">

            Create Event

        </button>

    </form>

    {{-- ================= RIGHT LIVE PREVIEW ================= --}}
    <div class="bg-white p-4 rounded shadow space-y-4 sticky top-6 h-fit">

        <h2 class="text-xl font-bold">
            Live Preview
        </h2>

        <p><b>Title:</b> <span id="p-title">-</span></p>

        <p><b>Subtitle:</b> <span id="p-subtitle">-</span></p>

        <p><b>Prerequisites:</b> <span id="p-prerequisites">-</span></p>

        <p><b>Venue:</b> <span id="p-venue">-</span></p>

        <p><b>Start:</b> <span id="p-start_datetime">-</span></p>

        <p><b>End:</b> <span id="p-end_datetime">-</span></p>

        <p><b>Description:</b> <span id="p-description">-</span></p>

        <p><b>Registration Fee:</b> <span id="p-registration_fee">-</span></p>

        <p><b>Registration Link:</b> <span id="p-registration_link">-</span></p>

        <p><b>Tags:</b>
            <span id="p-tags">-</span>
        </p>

        <hr>

        <h3 class="font-bold">
            Speakers
        </h3>

        <div id="speakers-preview">
            -
        </div>

        <h3 class="font-bold mt-4">
            Agenda
        </h3>

        <div id="agenda-preview">
            -
        </div>

        <h3 class="font-bold mt-4">
            Highlights
        </h3>

        <div id="highlights-preview">
            -
        </div>

    </div>

</div>

{{-- ================= JAVASCRIPT ================= --}}
<script>

            let speakerIndex = 0;
        let agendaIndex = 0;
        let highlightIndex = 0;

        /* ==========================================================
           SPEAKERS
        ========================================================== */

        function addSpeaker() {

            document.getElementById('speakers-wrapper').insertAdjacentHTML('beforeend', `

                <div class="border p-3 my-2 space-y-2 speaker-item">

                    <input
                        type="text"
                        name="speakers[${speakerIndex}][name]"
                        placeholder="Name"
                        class="w-full border p-2 speaker-name">

                    <input
                        type="text"
                        name="speakers[${speakerIndex}][title]"
                        placeholder="Title"
                        class="w-full border p-2 speaker-title">

                    <input
                        type="file"
                        name="speakers[${speakerIndex}][image]"
                        accept="image/*"
                        class="w-full border p-2 speaker-image"
                        onchange="previewSpeakerImage(event, ${speakerIndex})">

                    <img
                        id="speaker-preview-${speakerIndex}"
                        class="hidden w-16 h-16 rounded-full object-cover mt-2">

                </div>

            `);

            speakerIndex++;

            updateSpeakersPreview();
        }

        /* ==========================================================
           AGENDA
        ========================================================== */

        function addAgenda() {

            document.getElementById('agenda-wrapper').insertAdjacentHTML('beforeend', `

                <div class="border p-3 my-2 grid grid-cols-3 gap-2 agenda-item">

                    <input
                        type="time"
                        name="agenda[${agendaIndex}][start_time]"
                        class="border p-2 agenda-start">

                    <input
                        type="time"
                        name="agenda[${agendaIndex}][end_time]"
                        class="border p-2 agenda-end">

                    <input
                        type="text"
                        name="agenda[${agendaIndex}][topic]"
                        placeholder="Topic"
                        class="border p-2 agenda-topic">

                </div>

            `);

            agendaIndex++;

            updateAgendaPreview();
        }

        /* ==========================================================
           HIGHLIGHTS
        ========================================================== */

        function addHighlight() {

            document.getElementById('highlight-wrapper').insertAdjacentHTML('beforeend', `

                <div class="border p-3 my-2 highlight-item">

                    <input
                        type="text"
                        name="highlights[${highlightIndex}][text]"
                        placeholder="Highlight"
                        class="w-full border p-2 highlight-text">

                </div>

            `);

            highlightIndex++;

            updateHighlightsPreview();
        }

                /* ==========================================================
           TAGS
        ========================================================== */

        let tags = [];

        document.getElementById('tag-input').addEventListener('keydown', function (e) {

            if (e.key === 'Enter') {

                e.preventDefault();

                const value = this.value.trim();

                if (!value) return;

                if (!tags.includes(value)) {
                    tags.push(value);
                }

                this.value = '';

                renderTags();
            }

        });

        function renderTags() {

            document.getElementById('tags-wrapper').innerHTML =
                tags.map((tag, index) => `
                    <span class="bg-gray-200 px-3 py-1 rounded-full flex items-center gap-2">
                        ${tag}
                        <button
                            type="button"
                            onclick="removeTag(${index})"
                            class="text-red-500 font-bold">
                            ×
                        </button>
                    </span>
                `).join('');

            document.getElementById('tags-hidden').value =
                JSON.stringify(tags);

            renderPreview(
                'p-tags',
                tags.length
                    ? tags.map(tag =>
                        `<span class="bg-gray-300 px-2 py-1 rounded mr-1">${tag}</span>`
                    ).join('')
                    : '-'
            );
        }

        function removeTag(index) {

            tags.splice(index, 1);

            renderTags();

        }


        /* ==========================================================
           BASIC INPUT LIVE PREVIEW
        ========================================================== */

        document.addEventListener('input', function (e) {

            const map = {

                title: 'p-title',

                subtitle: 'p-subtitle',

                description: 'p-description',

                start_datetime: 'p-start_datetime',

                end_datetime: 'p-end_datetime',

                prerequisites: 'p-prerequisites',

                venue: 'p-venue',

                registration_fee: 'p-registration_fee',

                registration_link: 'p-registration_link',

            };

            if (map[e.target.name]) {

                document.getElementById(map[e.target.name]).innerText =
                    e.target.value || '-';

            }

            updateSpeakersPreview();

            updateAgendaPreview();

            updateHighlightsPreview();

        });


        /* ==========================================================
           SPEAKER PREVIEW
        ========================================================== */

        function updateSpeakersPreview() {

            let html = '';

            document.querySelectorAll('.speaker-item').forEach(item => {

                const name =
                    item.querySelector('.speaker-name')?.value || '';

                const title =
                    item.querySelector('.speaker-title')?.value || '';

                if (!name && !title) return;

                html += `

                    <div class="border-b py-2">

                        <strong>${name}</strong>

                        ${title ? `<br><small>${title}</small>` : ''}

                    </div>

                `;

            });

            renderPreview('speakers-preview', html || '-');

        }


        function previewSpeakerImage(event, index) {

            const file = event.target.files[0];

            const img =
                document.getElementById(`speaker-preview-${index}`);

            if (!file) {

                img.classList.add('hidden');

                return;

            }

            img.src = URL.createObjectURL(file);

            img.classList.remove('hidden');

        }

                /* ==========================================================
           AGENDA PREVIEW
        ========================================================== */

        function updateAgendaPreview() {

            let html = '';

            document.querySelectorAll('.agenda-item').forEach(item => {

                const start =
                    item.querySelector('.agenda-start')?.value?.trim();

                const end =
                    item.querySelector('.agenda-end')?.value?.trim();

                const topic =
                    item.querySelector('.agenda-topic')?.value?.trim();

                // Skip empty rows
                if (!start && !end && !topic) return;

                html += `
                    <div class="border-b py-2">

                        <div class="text-sm text-gray-600">

                            ${
                                start && end
                                    ? `${start} - ${end}`
                                    : (start || end || '')
                            }

                        </div>

                        <div class="font-medium">

                            ${topic || 'No topic'}

                        </div>

                    </div>
                `;

            });

            renderPreview('agenda-preview', html || '-');

        }


        /* ==========================================================
           HIGHLIGHTS PREVIEW
        ========================================================== */

        function updateHighlightsPreview() {

            let html = '';

            document
                .querySelectorAll('.highlight-text')
                .forEach(input => {

                    if (!input.value.trim()) return;

                    html += `<li>${input.value}</li>`;

                });

            renderPreview(

                'highlights-preview',

                html
                    ? `<ul class="list-disc ml-5">${html}</ul>`
                    : '-'

            );

        }


        /* ==========================================================
           HELPER
        ========================================================== */

        function renderPreview(id, html) {

            const element = document.getElementById(id);

            if (element) {

                element.innerHTML = html;

            }

        }


        /* ==========================================================
           BANNER IMAGE PREVIEW
        ========================================================== */

        document
            .querySelector('input[name="banner_image"]')
            .addEventListener('change', function (e) {

                const file = e.target.files[0];

                const preview =
                    document.getElementById('bannerPreview');

                if (!file) {

                    preview.src = '';

                    preview.classList.add('hidden');

                    return;

                }

                preview.src = URL.createObjectURL(file);

                preview.classList.remove('hidden');

            });

    </script>

@endsection
</script>