<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4 class="card-title mb-0">Liste des assurés</h4>
                        <small class="text-muted">Gérer les informations des assurés</small>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row justify-content-between mb-3">
                            <div class="col-md-6">
                                <form class="form-inline">
                                    <input type="text" id="search-input" class="form-control" placeholder="Rechercher par nom...">
                                </form>
                            </div>
                        </div>

                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Statut</th>
                                    <th>Role</th>
                    
                                    <th>Actions</th>
                                </tr>

                                 </thead>
                            <tbody>
                                @forelse ($employes as $employe)
                                    <tr>

                                        <td>{{ $employe->name }}</td>
                                        <td>{{ $employe->email }}</td>
                                        <td>
                                            <span class="badge bg-success">Actif</span>
                                        </td>
                                        <td>{{ $employe->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('employes.edit', $employe->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Modifier">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                <form action="{{ route('employes.destroy', $employe->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Supprimer">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                     @empty
                                    <tr>
                                        <td colspan="6" class="text-muted">Aucun utilisateur trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            {{ $employes->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>