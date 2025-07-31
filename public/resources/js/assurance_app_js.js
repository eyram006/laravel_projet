// ================================
// ASSURANCE APP - JAVASCRIPT COMPLET
// ================================

// Configuration des rôles et permissions
const roles = {
    'admin': {
        name: 'Administrateur',
        permissions: [ 'manage_policies', 'manage_users', 'view_logs', 'manage_settings']
    },
    'gestionnaire': {
        name: 'Gestionnaire',
        permissions: ['manage_assures', 'manage_claims', 'manage_policies', 'view_logs']
    },
    'employe': {
        name: 'Employé',
        permissions: ['manage_assures', 'manage_claims']
    },
    
    
};

// Rôle actuel (simulé - à remplacer par votre système d'auth)


let currentUserRole = document.getElementById('currentRole').textContent.trim();

    {/* Appel initial */}
    updateRoleDisplay();
    updateMenuPermissions();


// Données simulées des utilisateurs
// const usersData = [
//     {
//         id: 1,
//         firstName: 'Jean',
//         lastName: 'Dupont',
//         email: 'jean.dupont@entreprise.com',
//         role: 'admin',
//         status: 'active',
//         lastLogin: '2024-07-24 09:15',
//         department: 'Administration',
//         phone: '01 23 45 67 89'
//     },
//     {
//         id: 2,
//         firstName: 'Marie',
//         lastName: 'Martin',
//         email: 'marie.martin@entreprise.com',
//         role: 'manager',
//         status: 'active',
//         lastLogin: '2024-07-24 08:30',
//         department: 'Sinistres',
//         phone: '01 23 45 67 90'
//     },
//     {
//         id: 3,
//         firstName: 'Pierre',
//         lastName: 'Bernard',
//         email: 'pierre.bernard@entreprise.com',
//         role: 'agent',
//         status: 'inactive',
//         lastLogin: '2024-07-20 16:45',
//         department: 'Commercial',
//         phone: '01 23 45 67 91'
//     },
//     {
//         id: 4,
//         firstName: 'Sophie',
//         lastName: 'Rousseau',
//         email: 'sophie.rousseau@entreprise.com',
//         role: 'agent',
//         status: 'active',
//         lastLogin: '2024-07-24 07:20',
//         department: 'Support',
//         phone: '01 23 45 67 92'
//     },
//     {
//         id: 5,
//         firstName: 'Thomas',
//         lastName: 'Petit',
//         email: 'thomas.petit@entreprise.com',
//         role: 'viewer',
//         status: 'suspended',
//         lastLogin: '2024-07-15 14:10',
//         department: 'Audit',
//         phone: '01 23 45 67 93'
//     }
// ];

let currentEditingUser = null;

// ================================
// INITIALISATION
// ================================

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
    showView('dashboard');
});

function initializeApp() {
    updateRoleDisplay();
    updateMenuPermissions();
}

// ================================
// GESTION DES RÔLES ET PERMISSIONS
// ================================

function updateRoleDisplay() {
    const roleElement = document.getElementById('currentRole');
    roleElement.textContent = roles[currentUserRole].name;
}

function updateMenuPermissions() {
    const menuItems = document.querySelectorAll('[data-permission]');
    const userPermissions = roles[currentUserRole].permissions;

    menuItems.forEach(item => {
        const requiredPermission = item.getAttribute('data-permission');
        if (!userPermissions.includes(requiredPermission)) {
            item.classList.add('disabled');
        } else {
            item.classList.remove('disabled');
        }
    });
}

function hasPermission(permission) {
    return roles[currentUserRole].permissions.includes(permission);
}

function changeRole(newRole) {
    currentUserRole = newRole;
    initializeApp();
    showView('dashboard');
    showNotification(`Rôle changé vers: ${roles[newRole].name}`, 'success');
}

// ================================
// NAVIGATION ET SIDEBAR
// ================================

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (window.innerWidth <= 768) {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    } else {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    }
}

function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
}

// ================================
// GESTION DES VUES
// ================================

function showView(view) {
    const viewPermissions = {
        'assures': 'manage_assures',
        'demandes': 'manage_claims',
        'polices': 'manage_policies',
        'gestionnaires': 'manage_users',
        'logs': 'view_logs',
        'settings': 'manage_settings'
    };

    if (viewPermissions[view] && !hasPermission(viewPermissions[view])) {
        showAccessDenied();
        return;
    }

    // Mettre à jour le menu actif
    document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Charger le contenu
    const contentArea = document.getElementById('content-area');
    
    switch(view) {
        case 'dashboard':
            contentArea.innerHTML = getDashboardContent();
            break;
        case 'employes':
            contentArea.innerHTML = getAssuresContent();
            break;
        case 'demandes':
            contentArea.innerHTML = getDemandesContent();
            break;
        case 'polices':
            contentArea.innerHTML = getPolicesContent();
            break;
        case 'gestionnaires':
            contentArea.innerHTML = getGestionnairesContent();
            break;
        case 'logs':
            contentArea.innerHTML = getLogsContent();
            break;
        case 'settings':
            contentArea.innerHTML = getSettingsContent();
            break;
        default:
            contentArea.innerHTML = getDashboardContent();
    }

    if (window.innerWidth <= 768) {
        closeSidebar();
    }
}

function showAccessDenied() {
    const contentArea = document.getElementById('content-area');
    contentArea.innerHTML = `
        <div class="access-denied">
            <i class="fas fa-lock"></i>
            <h3>Accès refusé</h3>
            <p>Vous n'avez pas les permissions nécessaires pour accéder à cette section.</p>
            <p>Contactez votre administrateur si vous pensez que c'est une erreur.</p>
        </div>
    `;
}

// ================================
// CONTENU DES PAGES
// ================================

function getDashboardContent() {
    return `
        <div class="page-header">
            <h1 class="page-title">Tableau de bord</h1>
            <p class="page-subtitle">Vue d'ensemble de votre activité</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">1,247</div>
                <div class="stat-label">Assurés actifs</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #047857); color: white;">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-value">342</div>
                <div class="stat-label">Demandes en cours</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="stat-value">892</div>
                <div class="stat-label">Polices actives</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #dc2626, #b91c1c); color: white;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-value">23</div>
                <div class="stat-label">Alertes</div>
            </div>
        </div>

        <div class="content-card">
            <h3 style="margin-bottom: 20px;">Activité récente</h3>
            <p>Contenu du tableau de bord principal...</p>
            <p>Ici vous pouvez afficher des graphiques, des tableaux de bord, et des informations importantes.</p>
        </div>
    `;
}

function getAssuresContent() {
    fetch(url)
            .then(response => {
                if (!response.ok) throw new Error("Erreur serveur");
                return response.text();
            })
            .then(html => {
                document.querySelector('#content-area').innerHTML = html;
            })
            .catch(error => {
                document.querySelector('#content-area').innerHTML = "<p class='text-danger'>Erreur de chargement</p>";
                console.error(error);
            });
}

function getDemandesContent() {
    return `
        <div class="page-header">
            <h1 class="page-title">Gestion des demandes</h1>
            <p class="page-subtitle">Traiter les demandes de remboursement</p>
        </div>
        <div class="content-card">
            <h3>Demandes en attente</h3>
            <p>Interface de gestion des demandes - workflow, approbations, suivis...</p>
        </div>
    `;
}

function getPolicesContent() {
    return `
        <div class="page-header">
            <h1 class="page-title">Gestion des polices</h1>
            <p class="page-subtitle">Gérer les contrats d'assurance</p>
        </div>
        <div class="content-card">
            <h3>Polices d'assurance</h3>
            <p>Interface de gestion des polices - création, modification, renouvellement...</p>
        </div>
    `;
}

function getGestionnairesContent() {
    return `
        <div class="page-header">
            <h1 class="page-title">Gestion des gestionnaires</h1>
            <p class="page-subtitle">Administrer les utilisateurs du système</p>
        </div>

        <!-- Actions Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-3">
                <button class="btn btn-primary" onclick="openUserModal()">
                    <i class="fas fa-plus me-2"></i>Nouveau gestionnaire
                </button>
                <button class="btn btn-outline-secondary" onclick="exportUsers()">
                    <i class="fas fa-download me-2"></i>Exporter
                </button>
            </div>
            <div class="d-flex gap-2">
                <input type="search" class="form-control" placeholder="Rechercher..." style="width: 250px;" onkeyup="filterUsers(event)">
                <select class="form-select" style="width: 150px;" onchange="filterByRole(event)">
                    <option value="">Tous les rôles</option>
                    <option value="admin">Administrateur</option>
                    <option value="manager">Gestionnaire</option>
                    <option value="agent">Agent</option>
                    <option value="viewer">Consultation</option>
                </select>
            </div>
        </div>

        <!-- Users Table -->
        <div class="content-card">
            <div class="table-responsive">
                <table class="table table-hover" id="usersTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">
                                <input type="checkbox" class="form-check-input" onchange="toggleSelectAll(this)">
                            </th>
                            <th scope="col">Nom complet</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rôle</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Dernière connexion</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        ${generateUsersTableRows()}
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Affichage de 1 à 5 sur ${usersData.length} utilisateurs
                </div>
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Précédent</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    `;
}

function getLogsContent() {
    return `
        <div class="page-header">
            <h1 class="page-title">Gestion des logs</h1>
            <p class="page-subtitle">Consulter l'historique des actions</p>
        </div>
        <div class="content-card">
            <h3>Journaux d'activité</h3>
            <p>Interface de consultation des logs - filtres par date, utilisateur, action...</p>
        </div>
    `;
}

function getSettingsContent() {
    return `
        <div class="page-header">
            <h1 class="page-title">Paramètres</h1>
            <p class="page-subtitle">Configuration du système</p>
        </div>
        <div class="content-card">
            <h3>Configuration générale</h3>
            <p>Interface de paramétrage - préférences système, notifications, sécurité...</p>
        </div>
    `;
}

// ================================
// GESTION DES UTILISATEURS
// ================================

function generateUsersTableRows() {
    return usersData.map(user => {
        const initials = user.firstName.charAt(0) + user.lastName.charAt(0);
        const statusClass = user.status;
        const statusText = {
            'active': 'Actif',
            'inactive': 'Inactif',
            'suspended': 'Suspendu'
        }[user.status];

        const roleText = {
            'admin': 'Administrateur',
            'manager': 'Gestionnaire',
            'agent': 'Agent',
            'viewer': 'Consultation'
        }[user.role];

        return `
            <tr data-user-id="${user.id}">
                <td>
                    <input type="checkbox" class="form-check-input user-checkbox" value="${user.id}">
                </td>
                <td>
                    <div class="user-info">
                        <div class="user-avatar-table">${initials}</div>
                        <div class="user-details">
                            <h6>${user.firstName} ${user.lastName}</h6>
                            <small>${user.department || 'N/A'}</small>
                        </div>
                    </div>
                </td>
                <td>${user.email}</td>
                <td>
                    <span class="role-badge-table ${user.role}">${roleText}</span>
                </td>
                <td>
                    <span class="status-badge ${statusClass}">
                        <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                        ${statusText}
                    </span>
                </td>
                <td>
                    <small class="text-muted">${formatDate(user.lastLogin)}</small>
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-action edit" onclick="editUser(${user.id})" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action delete" onclick="deleteUser(${user.id})" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays === 1) return 'Aujourd\'hui';
    if (diffDays === 2) return 'Hier';
    if (diffDays <= 7) return `Il y a ${diffDays - 1} jours`;
    
    return date.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

function openUserModal(userId = null) {
    const modal = new bootstrap.Modal(document.getElementById('userModal'));
    const modalTitle = document.getElementById('userModalTitle');
    const form = document.getElementById('userForm');
    const passwordSection = document.getElementById('passwordSection');

    form.reset();
    currentEditingUser = userId;

    if (userId) {
        const user = usersData.find(u => u.id === userId);
        if (user) {
            modalTitle.textContent = 'Modifier le gestionnaire';
            document.getElementById('userFirstName').value = user.firstName;
            document.getElementById('userLastName').value = user.lastName;
            document.getElementById('userEmail').value = user.email;
            document.getElementById('userPhone').value = user.phone || '';
            document.getElementById('userRole').value = user.role;
            document.getElementById('userStatus').value = user.status;
            document.getElementById('userDepartment').value = user.department || '';

            passwordSection.style.display = 'none';
            document.getElementById('userPassword').required = false;
        }
    } else {
        modalTitle.textContent = 'Nouveau gestionnaire';
        document.getElementById('userStatus').value = 'active';
        passwordSection.style.display = 'block';
        document.getElementById('userPassword').required = true;
    }

    modal.show();
}

function editUser(userId) {
    openUserModal(userId);
}

function deleteUser(userId) {
    const user = usersData.find(u => u.id === userId);
    if (!user) return;

    if (confirm(`Êtes-vous sûr de vouloir supprimer l'utilisateur "${user.firstName} ${user.lastName}" ?\n\nCette action est irréversible.`)) {
        const index = usersData.findIndex(u => u.id === userId);
        if (index > -1) {
            usersData.splice(index, 1);
            refreshUsersTable();
            showNotification('Utilisateur supprimé avec succès', 'success');
        }
    }
}

function saveUser(event) {
    event.preventDefault();

    const formData = {
        firstName: document.getElementById('userFirstName').value,
        lastName: document.getElementById('userLastName').value,
        email: document.getElementById('userEmail').value,
        phone: document.getElementById('userPhone').value,
        role: document.getElementById('userRole').value,
        status: document.getElementById('userStatus').value,
        department: document.getElementById('userDepartment').value,
        notes: document.getElementById('userNotes').value
    };

    if (currentEditingUser) {
        const userIndex = usersData.findIndex(u => u.id === currentEditingUser);
        if (userIndex > -1) {
            usersData[userIndex] = { ...usersData[userIndex], ...formData };
            showNotification('Utilisateur modifié avec succès', 'success');
        }
    } else {
        const newUser = {
            id: Math.max(...usersData.map(u => u.id)) + 1,
            ...formData,
            lastLogin: 'Jamais connecté'
        };
        usersData.push(newUser);
        showNotification('Nouveau gestionnaire créé avec succès', 'success');
    }

    bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
    refreshUsersTable();
}

function refreshUsersTable() {
    const tbody = document.getElementById('usersTableBody');
    if (tbody) {
        tbody.innerHTML = generateUsersTableRows();
    }
}

function generatePassword() {
    const length = 12;
    const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
    let password = "";
    
    for (let i = 0; i < length; i++) {
        password += charset.charAt(Math.floor(Math.random() * charset.length));
    }
    
    document.getElementById('userPassword').value = password;
}

function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
}

function filterUsers(event) {
    const searchTerm = event.target.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
}

function filterByRole(event) {
    const selectedRole = event.target.value;
    const rows = document.querySelectorAll('#usersTable tbody tr');
    
    rows.forEach(row => {
        if (!selectedRole) {
            row.style.display = '';
        } else {
            const roleElement = row.querySelector('.role-badge-table');
            const userRole = roleElement.classList.contains(selectedRole);
            row.style.display = userRole ? '' : 'none';
        }
    });
}

function exportUsers() {
    const data = usersData.map(user => ({
        'Nom complet': `${user.firstName} ${user.lastName}`,
        'Email': user.email,
        'Rôle': {
            'admin': 'Administrateur',
            'manager': 'Gestionnaire',
            'agent': 'Agent',
            'viewer': 'Consultation'
        }[user.role],
        'Statut': {
            'active': 'Actif',
            'inactive': 'Inactif',
            'suspended': 'Suspendu'
        }[user.status],
        'Département': user.department || 'N/A'
    }));

    console.log('Export des utilisateurs:', data);
    showNotification('Export généré avec succès', 'info');
}

// ================================
// UTILITAIRES
// ================================

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} position-fixed`;
    notification.style.cssText = 'top: 90px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : 'info'}-circle me-2"></i>
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

function showUserMenu() {
    showNotification('Menu utilisateur - Fonctionnalité à implémenter', 'info');
}

function logout() {
    if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
        showNotification('Déconnexion en cours...', 'info');
        // Redirection vers la page de login
        // window.location.href = '/login';
    }
}

// ================================
// GESTION RESPONSIVE
// ================================

// Gestion responsive
window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
        closeSidebar();
    }
});

// ================================
// FONCTIONS AVANCÉES (À DÉVELOPPER)
// ================================

// Fonction pour gérer les tooltips Bootstrap
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Fonction pour valider les formulaires
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

// Fonction pour sauvegarder les données en localStorage (si nécessaire)
function saveToLocalStorage(key, data) {
    try {
        localStorage.setItem(key, JSON.stringify(data));
        return true;
    } catch (error) {
        console.error('Erreur lors de la sauvegarde:', error);
        return false;
    }
}

// Fonction pour charger les données depuis localStorage
function loadFromLocalStorage(key) {
    try {
        const data = localStorage.getItem(key);
        return data ? JSON.parse(data) : null;
    } catch (error) {
        console.error('Erreur lors du chargement:', error);
        return null;
    }
}

// Fonction pour formater les nombres
function formatNumber(number) {
    return new Intl.NumberFormat('fr-FR').format(number);
}

// Fonction pour formater les devises
function formatCurrency(amount, currency = 'EUR') {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: currency
    }).format(amount);
}

// Fonction de debounce pour les recherches
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Recherche avec debounce
const debouncedSearch = debounce(function(searchTerm) {
    // Logique de recherche
    console.log('Recherche:', searchTerm);
}, 300);

// ================================
// INITIALISATION FINALE
// ================================

// Initialisation des tooltips au chargement
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initializeTooltips, 100);
});