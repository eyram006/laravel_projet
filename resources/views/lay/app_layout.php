{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AssuranceApp')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('resources/css/style.css') }}">
    @vite('resources/css/style.css')

    <style>
        .btn-outline-primary:hover i, 
        .btn-outline-danger:hover i {
            transform: scale(1.2);
            transition: transform 0.2s ease-in-out;
        }
    </style>

    @stack('styles')
</head>
<body>
    @include('layouts.partials.header')
    
    @include('layouts.partials.sidebar')
    
    <!-- Overlay pour mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Main Content -->
    <main class="main-content" id="cc">
        <div id="content-area">
            @yield('content')
        </div>
    </main>

    @include('layouts.partials.modals.user-modal')

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript personnalisé -->
    <script src="{{ asset('resources/js/assurance_app_js.js') }}"></script>

    @stack('scripts')
</body>
</html>