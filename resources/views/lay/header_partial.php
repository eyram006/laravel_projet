{{-- resources/views/layouts/partials/header.blade.php --}}
<header class="header">
    <div class="header-left">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="logo">
            <i class="fas fa-shield-alt"></i>
            <span>AssuranceApp</span>
        </div>
    </div>
    <div class="header-right">
        <div class="role-badge" id="currentRole">{{ auth()->user()->role }}</div>
        <div class="user-profile" onclick="showUserMenu()">
            <div>
                <div style="font-weight: 600; font-size: 0.9rem;">{{ auth()->user()->name }}</div>
                <div style="font-size: 0.8rem; color: #6b7280;">{{ auth()->user()->email }}</div>
            </div>
            <i class="fas fa-chevron-down" style="margin-left: 10px; color: #6b7280;"></i>
        </div>
    </div>
</header>