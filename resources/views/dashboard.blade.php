{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - AssuranceApp')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Tableau de bord</h1>
            
            {{-- Contenu du dashboard ici --}}
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Bienvenue sur votre dashboard sunuSante !
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
  
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar" x-data="{ fetchContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => document.getElementById('content-area').innerHTML = html)
        .catch(error => console.error(error));
}}">
        <div class="sidebar-menu">
            <div class="menu-section">Tableau de bord</div>
            <a href="#" class="menu-item active" onclick="showView('dashboard')">
                <i class="fas fa-tachometer-alt"></i>
                <span>Vue d'ensemble</span>
            </a>

            {{-- tableau assure --}}

            @hasanyrole('gestionnaire|client')
                <div class="menu-section">Gestion</div>
                <a href="#" class="menu-item" @click.prevent="fetchContent('{{ route('assures.index') }}')" >
                    {{-- <a href="{{ route('assures.index') }}" class="menu-item" onclick="showView('assures')" data-permission="manage_assures"> --}}
                    <i class="fas fa-users"></i>
                    <span>Gestion des assurés </span>
                </a>
              @endhasanyrole

                    {{-- tableau demandes --}}
             @hasanyrole('gestionnaire|client')
            <a href="#" class="menu-item" @click.prevent="fetchContent('{{ route('demandes.index') }}')" >
                <i class="fas fa-file-alt"></i>
                <span>Gestion des demandes </span>
            </a>
           @endhasanyrole
             

            {{-- @role('gestionnaire')
            <a href="#" class="menu-item" onclick="showView('polices')" >
                <i class="fas fa-file-contract"></i>
                <span>Gestion des contrats </span>
            </a>
             @endrole --}}
                        {{-- tableau gestionnaires() --}}
            {{-- @role('admin') --}}
             @hasanyrole('client|gestionnaire')
            <a href="#" class="menu-item" @click.prevent="fetchContent('{{ route('gestionnaires.index') }}')" >
                <i class="fas fa-user-tie"></i>
                <span>Gestion des gestionnaires </span>
            </a>
             @endhasanyrole

            @role('admin')
            {{-- tableau User --}}
            <div class="menu-section">Administration</div>
            <a href="#" class="menu-item" onclick="showView('logs')" data-permission="view_logs">
                <i class="fas fa-list-alt"></i>
                <span>Gestion des logs</span>
            </a>
             @endrole

            <a href="#" class="menu-item" onclick="showView('settings')" data-permission="manage_settings">
                <i class="fas fa-cog"></i>
                <span>Paramètres</span>
            </a>

            <div class="menu-section">Compte</div>
            <a href="{{ route('logout') }}  " class="menu-item" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </nav>

    <!-- Overlay pour mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Main Content -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

    <main class="main-content" id="cc">
        <div id="content-area">
            <!-- Le contenu sera chargé ici dynamiquement -->
        </div>
    </main>

    <!-- Boutons de test pour démonstration -->
    <div class="role-test-buttons">
        <div class="dropdown">

            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="changeRole('admin')">Administrateur</a></li>
                <li><a class="dropdown-item" href="#" onclick="changeRole('manager')">Gestionnaire</a></li>
                <li><a class="dropdown-item" href="#" onclick="changeRole('viewer')">Consultation</a></li>
            </ul>
        </div>
    </div>

    <!-- Modal Création/Modification Utilisateur -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalTitle">Nouveau gestionnaire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="userForm" onsubmit="saveUser(event)">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prénom *</label>
                                <input type="text" class="form-control" id="userFirstName" required>
=======
            
            {{-- Exemple de cartes statistiques --}}
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">Employés</div>
                                    <div class="h4 mb-0">{{ $totalEmployees ?? '0' }}</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-file-alt fa-2x text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">Demandes</div>
                                    <div class="h4 mb-0">{{ $totalDemandes ?? '0' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-file-contract fa-2x text-warning"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">Polices</div>
                                    <div class="h4 mb-0">{{ $totalPolices ?? '0' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-tie fa-2x text-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">Gestionnaires</div>
                                    <div class="h4 mb-0">{{ $totalGestionnaires ?? '0' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Scripts spécifiques au dashboard
    console.log('Dashboard loaded');
</script>
@endpush
