<!-- page dashbord sans css -->

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AssuranceApp</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        .btn-outline-primary:hover i,
        .btn-outline-danger:hover i {
            transform: scale(1.2);
            transition: transform 0.2s ease-in-out;
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="resources/css/style.css">

    @vite('resources/css/style.css')


</head>

<body>
    <!-- Header -->
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

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar" x-data>
        <div class="sidebar-menu">
            <div class="menu-section">Tableau de bord</div>
            <a href="#" class="menu-item active" onclick="showView('dashboard')">
                <i class="fas fa-tachometer-alt"></i>
                <span>Vue d'ensemble</span>
            </a>

            {{-- tableau employe --}}
            {{-- <a href="{{ route('employes.index') }}" class="menu-item" onclick="showView('employes')" data-permission="manage_assures"> --}}

            @role('gestionnaire')
                <div class="menu-section">Gestion</div>
                <a href="#" class="menu-item" @click.prevent="fetchContent('{{ route('employes.index') }}')" >
                    {{-- <a href="{{ route('employes.index') }}" class="menu-item" onclick="showView('employes')" data-permission="manage_assures"> --}}
                    <i class="fas fa-users"></i>
                    <span>Gestion des employés 👨‍💼</span>
                </a>
                {{-- <div id="main-content" class="container-fluid mt-4"></div> --}}
            @endrole

            @role('gestionnaire','employe')
            {{-- tableau demandes --}}
            <a href="#" class="menu-item" onclick="showView('demandes')" >
                <i class="fas fa-file-alt"></i>
                <span>Gestion des demandes</span>
            </a>
             @endrole

            @role('gestionnaire')
            <a href="#" class="menu-item" onclick="showView('polices')" >
                <i class="fas fa-file-contract"></i>
                <span>Gestion des polices</span>
            </a>
             @endrole

            @role('admin')
            <a href="#" class="menu-item" onclick="showView('gestionnaires')" >
                <i class="fas fa-user-tie"></i>
                <span>Gestion des gestionnaires</span>
            </a>
            @endrole

            @role('admin')
            {{-- tableau User --}}
            <div class="menu-section">Administration</div>
            <a href="#" class="menu-item" onclick="showView('logs')" data-permission="view_logs">
                <i class="fas fa-list-alt"></i>
                <span>Gestion des logs</span>
            </a>

            <a href="#" class="menu-item" onclick="showView('settings')" data-permission="manage_settings">
                <i class="fas fa-cog"></i>
                <span>Paramètres</span>
            </a>

             @endrole

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
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom *</label>
                                <input type="text" class="form-control" id="userLastName" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" id="userEmail" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" id="userPhone">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rôle *</label>
                                <select class="form-select" id="userRole" required>
                                    <option value="">Sélectionner un rôle</option>
                                    <option value="admin">Administrateur</option>
                                    <option value="manager">Gestionnaire</option>
                                    <option value="agent">Agent</option>
                                    <option value="viewer">Consultation</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Statut</label>
                                <select class="form-select" id="userStatus">
                                    <option value="active">Actif</option>
                                    <option value="inactive">Inactif</option>
                                    <option value="suspended">Suspendu</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3" id="passwordSection">
                            <label class="form-label">Mot de passe temporaire *</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="userPassword" required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="generatePassword()">
                                    <i class="fas fa-key"></i> Générer
                                </button>
                            </div>
                            <div class="form-text">L'utilisateur devra changer ce mot de passe à sa première connexion
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Département</label>
                            <input type="text" class="form-control" id="userDepartment"
                                placeholder="Ex: Sinistres, Commercial, Support...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" id="userNotes" rows="3" placeholder="Notes administratives..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript personnalisé -->
    <script src="{{ asset('resources/js/assurance_app_js.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>

</html>
