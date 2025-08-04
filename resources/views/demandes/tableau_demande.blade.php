{{-- resources/views/demandes/index.blade.php --}}
<div class="container-fluid py-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center rounded-top-4">
            <div>
                <h4 class="mb-0">📄 Liste des demandes</h4>
                <small class="text-muted">Gérer les demandes envoyées par les employés</small>
            </div>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 gap-3">
                <form class="input-group w-50">
                    <span class="input-group-text bg-white border-end-0 rounded-start-3">
                        <i class="ri-search-line"></i>
                    </span>
                    <input type="text" id="search-input" class="form-control border-start-0 rounded-end-3" placeholder="Rechercher par nom...">
                </form>
            </div>

            <div class="d-flex justify-content-end mb-3">
   <div class="d-flex justify-content-end mb-3">
   <a href="/demandes/create" class="btn btn-success rounded-pill">
    <i class="ri-add-line"></i> Nouvelle demande
</a>

</div>

</div>


<div class="table-responsive">
    <table class="table table-hover align-middle text-center">
        <thead class="table-light text-capitalize">
            <tr>
                <th>Nom de l'employé</th>
                <th>Prénom de l'employé</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($demandes as $demande)
                <tr>
                    <td>{{ $demande->employe->nom ?? 'Non défini' }}</td>
                    <td>{{ $demande->employe->prenom ?? 'Non défini' }}</td>
                    <td>
                        @php
                            $badge = match ($demande->statut->value) {
                                'accepté' => 'success',
                                'refusé' => 'danger',
                                'en attente' => 'warning',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ ucfirst($demande->statut->value) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('demandes.show', $demande) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="ri-eye-line"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-muted">Aucune demande trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
