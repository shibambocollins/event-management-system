@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Organizer Dashboard</h1>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <!-- My Events -->
        <div>
            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">My Events</h2>
            @if($myEvents->count() > 0)
                @foreach($myEvents as $event)
                <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 15px; margin-bottom: 10px;">
                    <h3 style="font-weight: bold; font-size: 16px; margin-bottom: 5px;">{{ $event->title }}</h3>
                    <p style="color: #666; font-size: 14px;">{{ $event->event_date->format('F j, Y g:i A') }}</p>
                    <p style="color: #666; font-size: 14px;">📍 {{ $event->location }}</p>
                    <p style="font-size: 14px; margin-top: 5px;">
                        Registrations: {{ $event->registrations_count }}
                        ({{ $event->approved_count }} approved)
                    </p>
                    <div style="margin-top: 8px;">
                        <a href="{{ route('events.show', $event) }}" style="color: #3b82f6; font-size: 14px; text-decoration: none; margin-right: 10px;">
                            Manage Event →
                        </a>
                        <a href="{{ route('events.edit', $event) }}" style="color: #eab308; font-size: 14px; text-decoration: none;">
                            Edit
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 15px;">
                    <p style="color: #666;">You haven't created any events yet.</p>
                    <a href="{{ route('events.create') }}" style="color: #22c55e; text-decoration: none; display: inline-block; margin-top: 5px;">
                        Create Your First Event →
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Pending Approvals -->
        <div>
            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">Pending Approvals</h2>
            @if($pendingApprovals->count() > 0)
                @foreach($pendingApprovals as $reg)
                <div style="background: #fef3c7; border: 1px solid #fde68a; border-radius: 8px; padding: 15px; margin-bottom: 10px;">
                    <p style="font-weight: bold;">{{ $reg->user->name ?? 'Unknown User' }}</p>
                    <p style="font-size: 14px; color: #666;">wants to join</p>
                    <p style="font-weight: 500; color: #3b82f6;">{{ $reg->event->title }}</p>
                    <div style="margin-top: 10px;">
                        <form action="{{ route('registrations.approve', $reg) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background: #22c55e; color: white; padding: 4px 12px; border-radius: 4px; border: none; cursor: pointer; font-size: 14px; margin-right: 5px;">
                                ✓ Approve
                            </button>
                        </form>
                        <form action="{{ route('registrations.decline', $reg) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background: #ef4444; color: white; padding: 4px 12px; border-radius: 4px; border: none; cursor: pointer; font-size: 14px;">
                                ✗ Decline
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            @else
                <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 15px;">
                    <p style="color: #666;">No pending approvals.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection