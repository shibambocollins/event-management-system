<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; background: #f3f4f6; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 1rem; }
        .btn { padding: 0.5rem 1rem; border-radius: 0.25rem; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3b82f6; color: white; }
        .btn-primary:hover { background: #2563eb; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-success { background: #22c55e; color: white; }
        .btn-success:hover { background: #16a34a; }
        .card { background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1.5rem; }
        .alert-success { background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 0.75rem; border-radius: 0.25rem; margin-bottom: 1rem; }
        .alert-error { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem; border-radius: 0.25rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav style="background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; height: 64px;">
                <!-- Logo/Brand -->
                <div style="display: flex; align-items: center;">
                    <a href="{{ route('dashboard') }}" style="font-size: 20px; font-weight: bold; color: #1f2937; text-decoration: none;">
                        Event Manager
                    </a>
                    <div style="display: flex; margin-left: 40px; gap: 16px;">
                        <a href="{{ route('events.index') }}" style="color: #4b5563; text-decoration: none; hover:color: #1f2937;">
                            Events
                        </a>
                        <a href="{{ route('events.calendar') }}" style="color: #4b5563; text-decoration: none; hover:color: #1f2937;">
                            Calendar
                        </a>
                        @auth
                            @if(auth()->user() && (auth()->user()->isOrganizer() || auth()->user()->isAdmin()))
                                <a href="{{ route('events.create') }}" style="color: #16a34a; text-decoration: none; hover:color: #15803d;">
                                    Create Event
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                
                <!-- User Menu -->
                <div style="display: flex; align-items: center; gap: 16px;">
                    @auth
                        <span style="color: #4b5563;">{{ auth()->user()->name }}</span>
                        
                        <!-- Role Badge -->
                        <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;
                            @if(auth()->user()->isAdmin()) background: #fee2e2; color: #991b1b;
                            @elseif(auth()->user()->isOrganizer()) background: #dbeafe; color: #1e40af;
                            @else background: #e5e7eb; color: #374151; @endif">
                            {{ ucfirst(auth()->user()->role ?? 'Attendee') }}
                        </span>
                        
                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" style="color: #dc2626; background: none; border: none; cursor: pointer; text-decoration: none;">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" style="color: #3b82f6; text-decoration: none;">Login</a>
                        <a href="{{ route('register') }}" style="color: #22c55e; text-decoration: none;">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container" style="padding-top: 24px; padding-bottom: 24px;">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </main>
</body>
</html>