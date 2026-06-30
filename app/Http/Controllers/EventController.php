<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class EventController extends Controller
{
    /**
     * List events
     */
    public function index()
    {
        $events = Event::latest()->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store event
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
        ]);

        $event = Event::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'venue' => $request->venue,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'registration_fee' => $request->registration_fee,
            'registration_link' => $request->registration_link,
            'status' => $request->status ?? 'upcomming',
            'prerequisites' => $request->prerequisites,
            'banner_image' => $request->hasFile('banner_image') ? $request->file('banner_image')->store('events', 'public') : null,
        ]);


        if ($request->speakers) {
            foreach ($request->speakers as $speaker) {

                if (empty($speaker['name']))
                    continue;

                $imagePath = null;

                if (!empty($speaker['image'])) {
                    $imagePath = $speaker['image']->store('speakers', 'public');
                }

                $event->speakers()->create([
                    'name' => $speaker['name'],
                    'title' => $speaker['title'] ?? null,
                    'image' => $imagePath,
                ]);
            }
        }

        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('events', 'public');
        }

        /* AGENDA */
        if ($request->agenda) {
            foreach ($request->agenda as $agenda) {
                if (!empty($agenda['topic'])) {
                    $event->agendas()->create([
                        'start_time' => $agenda['start_time'],
                        'end_time' => $agenda['end_time'],
                        'topic' => $agenda['topic'],
                    ]);
                }
            }
        }

        /* HIGHLIGHTS */
        if ($request->highlights) {
            foreach ($request->highlights as $highlight) {
                if (!empty($highlight['text'])) {
                    $event->highlights()->create([
                        'text' => $highlight['text'],
                    ]);
                }
            }
        }

        /* TAGS */
        if ($request->tags) {
            $tags = json_decode($request->tags, true) ?? [];

            $event->tags = json_encode($tags);
            $event->save();
        }

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully!');
    }

    /**
     * Show event
     */
    public function show(Event $event)
    {
        $event->load([
            'speakers',
            'agendas',
            'highlights'
        ]);

        return view('admin.events.show', compact('event'));
    }



    /**
     * Edit event
     */

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }
    /**update event * */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
        ]);

        DB::transaction(function () use ($request, $event) {

            $event->update([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'venue' => $request->venue,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
                'registration_fee' => $request->registration_fee,
                'registration_link' => $request->registration_link,
                'status' => $request->status,
                'prerequisites' => $request->prerequisites,
            ]);

            /**
             * CLEAR OLD RELATIONS
             */
            $event->speakers()->delete();
            $event->agendas()->delete();
            $event->highlights()->delete();
            if ($request->hasFile('banner_image')) {
                $bannerPath = $request->file('banner_image')->store('events', 'public');

                $event->update([
                    'banner_image' => $bannerPath
                ]);
            }

            /*Speaker */

            $event->speakers()->delete();

            if ($request->speakers) {

                foreach ($request->speakers as $speakerData) {

                    if (empty($speakerData['name'])) {
                        continue;
                    }

                    $imagePath = null;

                    if (
                        isset($speakerData['image']) &&
                        $speakerData['image'] instanceof \Illuminate\Http\UploadedFile
                    ) {
                        $imagePath = $speakerData['image']->store('speakers', 'public');
                    }

                    $event->speakers()->create([
                        'name' => $speakerData['name'],
                        'title' => $speakerData['title'] ?? null,
                        'image' => $imagePath,
                    ]);
                }
            }
            if ($request->hasFile('banner_image')) {

                // optional: delete old image
                if ($event->banner_image) {
                    Storage::disk('public')->delete($event->banner_image);
                }

                $path = $request->file('banner_image')->store('events', 'public');

                $event->update([
                    'banner_image' => $path
                ]);
            }
            /**
             * RECREATE AGENDA
             */
            if ($request->agenda) {
                foreach ($request->agenda as $agenda) {
                    if (!empty($agenda['topic'])) {
                        $event->agendas()->create([
                            'start_time' => $agenda['start_time'],
                            'end_time' => $agenda['end_time'],
                            'topic' => $agenda['topic'],
                        ]);
                    }
                }
            }

            /**
             * RECREATE HIGHLIGHTS
             */
            if ($request->highlights) {
                foreach ($request->highlights as $highlight) {
                    if (!empty($highlight['text'])) {
                        $event->highlights()->create([
                            'text' => $highlight['text'],
                        ]);
                    }
                }
            }

            /**
             * TAGS (if we keep JSON for now)
             */
            if ($request->tags) {
                $tags = json_decode($request->tags, true) ?? [];

                $event->tags = json_encode($tags);
                $event->save();
            }

        });

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Delete event
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }
}