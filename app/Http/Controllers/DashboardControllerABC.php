<?php

namespace App\Http\Controllers;

use App\Models\EventABC;
use App\Models\RegistrationABC;
use Illuminate\Support\Facades\Auth;

class DashboardControllerABC extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        if ($user->role === 'admin') {
            $events = EventABC::withCount('registrations')->get();
            $pendingRegistrations = RegistrationABC::where('status', 'pending')->count();
            $totalRegistrations = RegistrationABC::count();
            
            return view('dashboard.admin', compact('events', 'pendingRegistrations', 'totalRegistrations'));
        }
        
        if ($user->role === 'organizer') {
            $myEvents = EventABC::where('organizer_id', $user->id)
                ->withCount('registrations')
                ->get();
                
            $pendingApprovals = RegistrationABC::whereHas('event', function($query) use ($user) {
                $query->where('organizer_id', $user->id);
            })->where('status', 'pending')->get();
            
            return view('dashboard.organizer', compact('myEvents', 'pendingApprovals'));
        }
        
        // Default attendee
        $myRegistrations = RegistrationABC::with('event')
            ->where('user_id', $user->id)
            ->get();
            
        $upcomingEvents = EventABC::where('event_date', '>', now())
            ->orderBy('event_date')
            ->limit(5)
            ->get();
            
        return view('dashboard.attendee', compact('myRegistrations', 'upcomingEvents'));
    }
}