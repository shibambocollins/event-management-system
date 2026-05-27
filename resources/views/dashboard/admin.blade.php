@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Admin Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 30px;">
        <div style="background: #dbeafe; border-radius: 8px; padding: 15px; text-align: center;">
            <p style="font-size: 28px; font-weight: bold; color: #2563eb; margin: 0;">{{ $events->count() }}</p>
            <p style="color: #374151; margin: 5px 0 0 0;">Total Events</p>
        </div>
        <div style="background: #fef3c7; border-radius: 8px; padding: 15px; text-align: center;">
            <p style="font-size: 28px; font-weight: bold; color: #d97706; margin: 0;">{{ $pendingRegistrations }}</p>
            <p style="color: #374151; margin: 5px 0 0 0;">Pending Approvals</p>
        </div>
        <div style="background: #dcfce7; border-radius: 8px; padding: 15px; text-align: center;">
            <p style="font-size: 28px; font-weight: bold; color: #16a34a; margin: 0;">{{ $totalRegistrations }}</p>
            <p style="color: #374151; margin: 5px 0 0 0;">Total Registrations</p>
        </div>
    </div>
    
    <!-- All Events -->
    <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">All Events</h2>
    @if($events->count() > 0)
        <div style="background: white; border-radius: 8px; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f3f4f6;">
                    <tr>
                        <th style="padding: 10px; text-align: left;">Event Title</th>
                        <th style="padding: 10px; text-align: left;">Date</th>
                        <th style="padding: 10px; text-align: left;">Organizer</th>
                        <th style="padding: 10px; text-align: left;">Registrations</th>
                        <th style="padding: 10px; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 10px;">{{ $event->title }}</td>
                        <td style="padding: 10px;">{{ $event->event_date->format('M j, Y') }}</td>
                        <td style="padding: 10px;">{{ $event->organizer->name ?? 'Unknown' }}</td>
                        <td style="padding: 10px;">{{ $event->registrations_count }}</td>
                        <td style="padding: 10px;">
                            <a href="{{ route('events.show', $event) }}" style="color: #3b82f6; text-decoration: none;">
                                Manage
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="background: white; border-radius: 8px; padding: 15px;">
            <p style="color: #666;">No events created yet.</p>
        </div>
    @endif
</div>
@endsection