@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">{{ isset($event) ? 'Edit Event' : 'Create New Event' }}</h1>
        
        <form method="POST" action="{{ isset($event) ? route('events.update', $event) : route('events.store') }}">
            @csrf
            @if(isset($event))
                @method('PUT')
            @endif
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Event Title</label>
                <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}" 
                       class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="5" 
                          class="w-full border rounded px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description', $event->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Date & Time</label>
                <input type="datetime-local" name="event_date" 
                       value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d\TH:i') : '') }}"
                       class="w-full border rounded px-3 py-2 @error('event_date') border-red-500 @enderror">
                @error('event_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Location</label>
                <input type="text" name="location" value="{{ old('location', $event->location ?? '') }}"
                       class="w-full border rounded px-3 py-2 @error('location') border-red-500 @enderror">
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Maximum Attendees</label>
                <input type="number" name="max_attendees" value="{{ old('max_attendees', $event->max_attendees ?? 50) }}"
                       class="w-full border rounded px-3 py-2 @error('max_attendees') border-red-500 @enderror">
                @error('max_attendees')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                {{ isset($event) ? 'Update Event' : 'Create Event' }}
            </button>
            <a href="{{ route('events.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
@endsection