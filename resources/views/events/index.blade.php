@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Upcoming Events</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">{{ $event->title }}</h2>
                    <p class="text-gray-600 mb-2">{{ Str::limit($event->description, 100) }}</p>
                    <p class="text-sm text-gray-500 mb-1">
                        📍 {{ $event->location }}
                    </p>
                    <p class="text-sm text-gray-500 mb-1">
                        📅 {{ $event->event_date->format('F j, Y g:i A') }}
                    </p>
                    <p class="text-sm text-gray-500 mb-4">
                        👥 {{ $event->approved_count }}/{{ $event->max_attendees }} attending
                    </p>
                    <a href="{{ route('events.show', $event) }}" 
                       class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No events found.</p>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $events->links() }}
    </div>
@endsection