<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;

class EventApiController extends Controller
{
public function index(Request $request)
{
    $query = Event::with([
        'speakers',
        'agendas',
        'highlights'
    ]);

    if ($request->filled('tag')) {
        $query->whereJsonContains('tags', $request->tag);
    }

    $events = $query
        ->latest()
        ->paginate($request->pageSize ?? 6);

    return EventResource::collection($events);
}

    public function show($id)
    {
        $event = Event::with(['speakers', 'agendas', 'highlights'])->findOrFail($id);

        return new EventResource($event);
    }
}
