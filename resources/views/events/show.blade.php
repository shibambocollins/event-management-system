@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px;">
    
    <!-- Header with title and action buttons -->
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
        <h1 style="font-size: 28px; font-weight: bold; margin: 0;">{{ $event->title }}</h1>
        
        @auth
            @if(auth()->id() === $event->organizer_id || (auth()->user()->role ?? '') === 'admin')
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('events.edit', $event) }}" 
                       style="background: #eab308; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
                        Edit
                    </a>
                    <form action="{{ route('events.destroy', $event) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #dc2626; color: white; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;"
                                onclick="return confirm('Delete this event?')">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
    
    <!-- Description -->
    <div style="margin-bottom: 20px;">
        <p style="color: #374151; white-space: pre-wrap;">{{ $event->description }}</p>
    </div>
    
    <!-- Event Details -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 24px; background: #f9fafb; padding: 16px; border-radius: 8px;">
        <div>
            <p style="font-size: 12px; color: #6b7280;">Location</p>
            <p style="font-weight: 600;">{{ $event->location }}</p>
        </div>
        <div>
            <p style="font-size: 12px; color: #6b7280;">Date & Time</p>
            <p style="font-weight: 600;">{{ $event->event_date->format('F j, Y g:i A') }}</p>
        </div>
        <div>
            <p style="font-size: 12px; color: #6b7280;">Organizer</p>
            <p style="font-weight: 600;">{{ $event->organizer->name ?? 'Unknown' }}</p>
        </div>
        <div>
            <p style="font-size: 12px; color: #6b7280;">Capacity</p>
            <p style="font-weight: 600; @if(isset($isFull) && $isFull) color: #dc2626; @endif">
                {{ $approvedCount ?? 0 }} / {{ $event->max_attendees }}
                @if(isset($isFull) && $isFull) (Full) @endif
            </p>
        </div>
    </div>
    
    <!-- Registration Section -->
    @auth
        <div style="border-top: 1px solid #e5e7eb; padding-top: 24px;">
            @if(isset($isRegistered) && $isRegistered)
                <div style="background: #dbeafe; padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                    <p style="color: #1e40af;">
                        Your registration status: 
                        <strong>{{ ucfirst($registration->status ?? 'pending') }}</strong>
                    </p>
                    @if(($registration->status ?? '') !== 'approved')
                        <form action="{{ route('registrations.cancel', $event) }}" method="POST" style="margin-top: 8px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: #dc2626; background: none; border: none; cursor: pointer; padding: 0;">
                                Cancel Registration
                            </button>
                        </form>
                    @endif
                </div>
            @elseif($event->event_date > now())
                @if(!isset($isFull) || !$isFull)
                    <form action="{{ route('registrations.register', $event) }}" method="POST">
                        @csrf
                        <button type="submit" style="background: #22c55e; color: white; padding: 8px 24px; border-radius: 4px; border: none; cursor: pointer;">
                            Register for Event
                        </button>
                    </form>
                @else
                    <p style="color: #dc2626; font-weight: bold;">Event is full!</p>
                @endif
            @else
                <p style="color: #6b7280;">Event has passed.</p>
            @endif
        </div>
    @else
        <div style="border-top: 1px solid #e5e7eb; padding-top: 24px;">
            <a href="{{ route('login') }}" style="background: #3b82f6; color: white; padding: 8px 24px; border-radius: 4px; text-decoration: none;">
                Login to Register
            </a>
        </div>
    @endauth
    
    <!-- Registrations List (Only for organizers/admins) -->
    @auth
        @php
            $canManage = (auth()->id() === $event->organizer_id || (auth()->user()->role ?? '') === 'admin');
        @endphp
        
        @if($canManage)
            <div style="border-top: 1px solid #e5e7eb; margin-top: 24px; padding-top: 24px;">
                <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 16px;">Registrations</h2>
                
                @php
                    // Get registrations directly
                    $registrationsList = \App\Models\RegistrationABC::where('event_id', $event->id)
                        ->with('user')
                        ->get();
                @endphp
                
                @if($registrationsList->count() > 0)
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f3f4f6;">
                                    <th style="padding: 10px; text-align: left;">Attendee</th>
                                    <th style="padding: 10px; text-align: left;">Email</th>
                                    <th style="padding: 10px; text-align: left;">Status</th>
                                    <th style="padding: 10px; text-align: left;">Registered On</th>
                                    <th style="padding: 10px; text-align: left;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrationsList as $reg)
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 10px;">{{ $reg->user->name ?? 'N/A' }}</td>
                                        <td style="padding: 10px;">{{ $reg->user->email ?? 'N/A' }}</td>
                                        <td style="padding: 10px;">
                                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; 
                                                @if($reg->status === 'approved') background: #dcfce7; color: #166534;
                                                @elseif($reg->status === 'pending') background: #fef3c7; color: #92400e;
                                                @else background: #fee2e2; color: #991b1b; @endif">
                                                {{ ucfirst($reg->status) }}
                                            </span>
                                        </td>
                                        <td style="padding: 10px;">{{ $reg->created_at->format('M j, Y') }}</td>
                                        <td style="padding: 10px;">
                                            @if($reg->status === 'pending')
                                                <form action="{{ route('registrations.approve', $reg) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" style="background: #22c55e; color: white; padding: 4px 12px; border-radius: 4px; border: none; cursor: pointer; font-size: 12px; margin-right: 4px;">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('registrations.decline', $reg) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" style="background: #ef4444; color: white; padding: 4px 12px; border-radius: 4px; border: none; cursor: pointer; font-size: 12px;">
                                                        Decline
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: #6b7280;">No registrations yet.</p>
                @endif
            </div>
        @endif
    @endauth
</div>
@endsection