{{-- resources/views/layouts/partials/sidebar.blade.php --}}
<nav class="sidebar" id="sidebar">
    <div class="sidebar-menu">
        <div class="menu-section">Tableau de bord</div>
        <a href="#" class="menu-item active" onclick="showView('dashboard')">
            <i class="fas fa-tachometer-alt"></i>
            <span>Vue d'ensemble</span>
        </a>

        @role('gestionnaire')
            <div class="menu-section">Gestion</div>
            <a href="#" class="menu-item" onclick="showView('assures')" data-permission="manage_assures">
                <i class="fas fa-users"></i>
                <span>Gestion des assurés</span>
            </a>
        @endrole

        <a href="#" class="menu-item" onclick="showView('demandes')" data-permission="manage_claims">
            <i class="fas fa-file-alt"></i>
            <span>Gestion des demandes</span>
        </a>
        
        <a href="#" class="menu-item" onclick="showView('polices')" data-permission="manage_policies">
            <i class="fas fa-file-contract"></i>
            <span>Gestion des polices</span>
        </a>
        
        <a href="#" class="menu-item" onclick="showView('gestionnaires')" data-permission="manage_users">
            <i class="fas fa-user-tie"></i>
            <span>Gestion des gestionnaires</span>
        </a>
        
        <div class="menu-section">Administration</div>
        <a href="#" class="menu-item" onclick="showView('logs')" data-permission="view_logs">
            <i class="fas fa-list-alt"></i>
            <span>Gestion des logs</span>
        </a>
        
        <a href="#" class="menu-item" onclick="showView('settings')" data-permission="manage_settings">
            <i class="fas fa-cog"></i>
            <span>Paramètres</span>
        </a>

        <div class="menu-section">Compte</div>
        <a href="{{ route('logout') }}" class="menu-item" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i>
            <span>Déconnexion</span>
        </a>
    </div>
</nav>