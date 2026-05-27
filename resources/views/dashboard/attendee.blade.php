@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">My Dashboard</h1>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <!-- My Registrations -->
        <div>
            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">My Registrations</h2>
            @if($myRegistrations->count() > 0)
                @foreach($myRegistrations as $reg)
                <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 15px; margin-bottom: 10px;">
                    <h3 style="font-weight: bold; font-size: 16px; margin-bottom: 5px;">{{ $reg->event->title ?? 'Unknown Event' }}</h3>
                    <p style="color: #666; font-size: 14px;">{{ $reg->event->event_date->format('F j, Y g:i A') ?? 'Date TBA' }}</p>
                    <p style="font-size: 14px; margin-top: 5px;">Status: 
                        <span style="font-weight: bold; 
                            @if($reg->status === 'approved') color: #16a34a;
                            @elseif($reg->status === 'pending') color: #ca8a04;
                            @else color: #dc2626; @endif">
                            {{ ucfirst($reg->status) }}
                        </span>
                    </p>
                    <a href="{{ route('events.show', $reg->event_id) }}" style="color: #3b82f6; font-size: 14px; text-decoration: none; display: inline-block; margin-top: 5px;">
                        View Event →
                    </a>
                </div>
                @endforeach
            @else
                <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 15px;">
                    <p style="color: #666;">You haven't registered for any events yet.</p>
                    <a href="{{ route('events.index') }}" style="color: #3b82f6; text-decoration: none; display: inline-block; margin-top: 5px;">
                        Browse Events →
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Upcoming Events -->
        <div>
            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">Upcoming Events</h2>
            @if($upcomingEvents->count() > 0)
                @foreach($upcomingEvents as $event)
                <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 15px; margin-bottom: 10px;">
                    <h3 style="font-weight: bold; font-size: 16px; margin-bottom: 5px;">{{ $event->title }}</h3>
                    <p style="color: #666; font-size: 14px;">{{ $event->event_date->format('F j, Y g:i A') }}</p>
                    <p style="color: #666; font-size: 14px;">📍 {{ $event->location }}</p>
                    <p style="font-size: 14px; margin-top: 5px;">Available: {{ $event->max_attendees - $event->approved_count }} spots left</p>
                    <a href="{{ route('events.show', $event) }}" style="color: #3b82f6; font-size: 14px; text-decoration: none; display: inline-block; margin-top: 5px;">
                        View Details →
                    </a>
                </div>
                @endforeach
            @else
                <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 15px;">
                    <p style="color: #666;">No upcoming events at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection