<?php

namespace App\Http\Controllers;

use App\Models\EventABC;
use App\Models\RegistrationABC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventControllerABC extends Controller
{
    public function index()
    {
        $events = EventABC::with('organizer')
            ->orderBy('event_date', 'asc')
            ->paginate(10);
        
        return view('events.index', compact('events'));
    }
    
    public function create()
    {
        if (!Auth::user()->isOrganizer() && !Auth::user()->isAdmin()) {
            abort(403, 'Only organizers and admins can create events.');
        }
        
        return view('events.create');
    }
    
    public function store(Request $request)
    {
        if (!Auth::user()->isOrganizer() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'event_date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'max_attendees' => 'required|integer|min:1|max:1000',
        ]);
        
        $validated['organizer_id'] = Auth::id();
        
        EventABC::create($validated);
        
        return redirect()->route('events.index')
            ->with('success', 'Event created successfully!');
    }
    
    // THIS METHOD IS MISSING - ADD IT
    public function show(EventABC $event)
{
    // Count approved registrations
    $approvedCount = \App\Models\RegistrationABC::where('event_id', $event->id)
        ->where('status', 'approved')
        ->count();
    
    $isFull = $approvedCount >= $event->max_attendees;
    
    // Check if current user is registered
    $isRegistered = false;
    $registration = null;
    
    if (Auth::check()) {
        $registration = \App\Models\RegistrationABC::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();
        $isRegistered = !is_null($registration);
    }
    
    return view('events.show', compact('event', 'isRegistered', 'registration', 'isFull', 'approvedCount'));
}
    public function edit(EventABC $event)
    {
        if (Auth::id() !== $event->organizer_id && !Auth::user()->isAdmin()) {
            abort(403, 'You can only edit your own events.');
        }
        
        return view('events.edit', compact('event'));
    }
    
    public function update(Request $request, EventABC $event)
    {
        if (Auth::id() !== $event->organizer_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'event_date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'max_attendees' => 'required|integer|min:1|max:1000',
        ]);
        
        $event->update($validated);
        
        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated successfully!');
    }
    
    public function destroy(EventABC $event)
    {
        if (Auth::id() !== $event->organizer_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $event->registrations()->delete();
        $event->delete();
        
        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }
    
    public function calendar()
{
    // Get all events
    $events = EventABC::with('organizer')->get();
    
    $calendarEvents = [];
    
    foreach ($events as $event) {
        // Count approved registrations directly from database
        $approvedCount = \App\Models\RegistrationABC::where('event_id', $event->id)
            ->where('status', 'approved')
            ->count();
        
        $isFull = $approvedCount >= $event->max_attendees;
        
        $calendarEvents[] = [
            'title' => $event->title,
            'start' => $event->event_date->format('Y-m-d H:i:s'),
            'url' => route('events.show', $event),
            'backgroundColor' => $isFull ? '#ef4444' : '#3b82f6',
        ];
    }
    
    return view('events.calendar', compact('calendarEvents'));
}
}