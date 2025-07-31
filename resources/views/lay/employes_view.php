{{-- resources/views/employes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestion des employés - AssuranceApp')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Gestion des employés</h1>
                @can('create', App\Models\Employe::class)
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeModal">
                        <i class="fas fa-plus me-2"></i>Nouvel employé
                    </button>
                @endcan
            </div>
            
            {{-- Filtres et recherche --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rechercher</label>
                            <input type="text" class="form-control" placeholder="Nom, email, téléphone...">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Statut</label>
                            <select class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="active">Actif</option>
                                <option value="inactive">Inactif</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Département</label>
                            <select class="form-select">
                                <option value="">Tous les départements</option>
                                <option value="it">IT</option>
                                <option value="hr">RH</option>
                                <option value="finance">Finance</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-search"></i> Filtrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Tableau des employés --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des employés</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom complet</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Département</th>
                                    <th>Statut</th>
                                    <th>Date d'embauche</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employes ?? [] as $employe)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    {{ strtoupper(substr($employe->prenom, 0, 1) . substr($employe->nom, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $employe->prenom }} {{ $employe->nom }}</div>
                                                    <small class="text-muted">{{ $employe->poste ?? 'Non défini' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $employe->email }}</td>
                                        <td>{{ $employe->telephone ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $employe->departement ?? 'Non défini' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $employe->statut === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $employe->statut === 'active' ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </td>
                                        <td>{{ $employe->date_embauche ? $employe->date_embauche->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                @can('view', $employe)
                                                    <button class="btn btn-outline-info" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                @endcan
                                                @can('update', $employe)
                                                    <button class="btn btn-outline-primary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endcan
                                                @can('delete', $employe)
                                                    <button class="btn btn-outline-danger" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Aucun employé trouvé</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    @if(isset($employes) && $employes->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $employes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal pour créer/modifier un employé --}}
<div class="modal fade" id="employeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvel employé</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="employeForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom *</label>
                            <input type="text" class="form-control" name="prenom" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom *</label>
                            <input type="text" class="form-control" name="nom" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" name="telephone">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Poste</label>
                            <input type="text" class="form-control" name="poste">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Département</label>
                            <select class="form-select" name="departement">
                                <option value="">Sélectionner...</option>
                                <option value="it">IT</option>
                                <option value="hr">RH</option>
                                <option value="finance">Finance</option>
                                <option value="commercial">Commercial</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date d'embauche</label>
                            <input type="date" class="form-control" name="date_embauche">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Statut</label>
                            <select class="form-select" name="statut">
                                <option value="active">Actif</option>
                                <option value="inactive">Inactif</option>
                            </select>
                        </div>
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
@endsection

@push('styles')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Scripts spécifiques à la gestion des employés
    document.getElementById('employeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Logique de soumission du formulaire
        console.log('Formulaire employé soumis');
    });
</script>
@endpush