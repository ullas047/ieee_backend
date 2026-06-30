<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Resources\EventResource;

class EventApiController extends Controller
{
    public function index()
    {
        return EventResource::collection(
            Event::with(['speakers', 'agendas', 'highlights'])
                ->latest()
                ->get()
        );
    }

    public function show($id)
    {
        $event = Event::with(['speakers', 'agendas', 'highlights'])->findOrFail($id);

        return new EventResource($event);
    }
}
