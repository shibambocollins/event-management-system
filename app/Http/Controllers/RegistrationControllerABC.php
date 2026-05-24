<?php

namespace App\Http\Controllers;

use App\Models\EventABC;
use App\Models\RegistrationABC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationControllerABC extends Controller
{
    public function register(EventABC $event)
    {
        // Check if event exists and is not in the past
        if ($event->event_date < now()) {
            return back()->with('error', 'Cannot register for past events.');
        }
        
        // Check if event is full
        if ($event->isFull()) {
            return back()->with('error', 'This event is full! Maximum capacity of ' . $event->max_attendees . ' reached.');
        }
        
        // Check if already registered
        $existing = RegistrationABC::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($existing) {
            return back()->with('error', 'You are already registered for this event!');
        }
        
        // Create registration
        DB::beginTransaction();
        try {
            $registration = RegistrationABC::create([
                'event_id' => $event->id,
                'user_id' => Auth::id(),
                'status' => Auth::user()->isAdmin() ? 'approved' : 'pending'
            ]);
            
            DB::commit();
            
            $message = Auth::user()->isAdmin() 
                ? 'You are registered for this event!' 
                : 'Registration submitted. Waiting for organizer approval.';
                
            return back()->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Registration failed. Please try again.');
        }
    }
    
    public function cancel(EventABC $event)
    {
        $registration = RegistrationABC::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();
            
        if (!$registration) {
            return back()->with('error', 'No registration found.');
        }
        
        $registration->delete();
        
        return back()->with('success', 'Registration cancelled successfully.');
    }
    
    public function approve(RegistrationABC $registration)
    {
        $event = $registration->event;
        
        // Check permission
        if (Auth::id() !== $event->organizer_id && !Auth::user()->isAdmin()) {
            abort(403, 'Only the event organizer can approve registrations.');
        }
        
        // Check if event still has capacity
        if ($event->isFull()) {
            return back()->with('error', 'Event is full, cannot approve more attendees.');
        }
        
        $registration->update(['status' => 'approved']);
        
        return back()->with('success', 'Registration approved!');
    }
    
    public function decline(RegistrationABC $registration)
    {
        $event = $registration->event;
        
        if (Auth::id() !== $event->organizer_id && !Auth::user()->isAdmin()) {
            abort(403, 'Only the event organizer can decline registrations.');
        }
        
        $registration->update(['status' => 'declined']);
        
        return back()->with('success', 'Registration declined.');
    }
}