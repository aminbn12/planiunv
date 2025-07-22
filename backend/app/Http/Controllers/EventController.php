<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'date' => $event->date->format('Y-m-d'),
                'time' => $event->time->format('H:i'),
                'location' => $event->location,
                'organizer' => $event->organizer,
                'type' => $event->type,
            ];
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'location' => 'required|string',
            'organizer' => 'nullable|string',
            'type' => 'required|in:meeting,exam,conference,other',
        ]);

        $event = Event::create($request->all());

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'date' => $event->date->format('Y-m-d'),
            'time' => $event->time->format('H:i'),
            'location' => $event->location,
            'organizer' => $event->organizer,
            'type' => $event->type,
        ], 201);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'date' => $event->date->format('Y-m-d'),
            'time' => $event->time->format('H:i'),
            'location' => $event->location,
            'organizer' => $event->organizer,
            'type' => $event->type,
        ]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'location' => 'required|string',
            'organizer' => 'nullable|string',
            'type' => 'required|in:meeting,exam,conference,other',
        ]);

        $event->update($request->all());

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'date' => $event->date->format('Y-m-d'),
            'time' => $event->time->format('H:i'),
            'location' => $event->location,
            'organizer' => $event->organizer,
            'type' => $event->type,
        ]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Événement supprimé avec succès']);
    }
}