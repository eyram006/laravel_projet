 
{{-- <body class="bg-light"> --}}
{{-- 
<div class="container-fluid py-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center rounded-top-4">
            <div>
                <h4 class="mb-0">👨‍💼 Liste des employés</h4>
                <small class="text-muted">Gérer les informations des employés</small>
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
            </div> --}}

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light text-capitalize">
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employes as $employe)
                            <tr>
                                <td>{{ $employe->nom }}</td>
                                <td>{{ $employe->email }}</td>
                                <td><span class="badge bg-success">Actif</span></td>
                                
                                <td>
                                    <div class="d-flex justify-content-center gap-3">
                                        <a href="{{ route('employes.edit', $employe->id) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="Modifier">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        
                                        {{-- <form action="{{ route('employes.edit', $employe->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Supprimer">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>  --}}
                                       
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted">Aucun employé trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {{ $employes->links() }}
            </div>
        {{-- </div>
    </div>
</div> --}}

