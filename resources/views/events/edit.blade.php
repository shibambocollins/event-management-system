@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px;">
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Edit Event</h1>
    
    <form method="POST" action="{{ route('events.update', $event) }}">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 16px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Event Title</label>
            <input type="text" name="title" value="{{ old('title', $event->title) }}" 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            @error('title')
                <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
            @enderror
        </div>
        
        <div style="margin-bottom: 16px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Description</label>
            <textarea name="description" rows="5" 
                      style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">{{ old('description', $event->description) }}</textarea>
            @error('description')
                <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
            @enderror
        </div>
        
        <div style="margin-bottom: 16px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Date & Time</label>
            <input type="datetime-local" name="event_date" 
                   value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}"
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            @error('event_date')
                <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
            @enderror
        </div>
        
        <div style="margin-bottom: 16px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Location</label>
            <input type="text" name="location" value="{{ old('location', $event->location) }}"
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            @error('location')
                <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
            @enderror
        </div>
        
        <div style="margin-bottom: 16px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Maximum Attendees</label>
            <input type="number" name="max_attendees" value="{{ old('max_attendees', $event->max_attendees) }}"
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            @error('max_attendees')
                <p style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</p>
            @enderror
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
                Update Event
            </button>
            <a href="{{ route('events.show', $event) }}" style="background: #6b7280; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection