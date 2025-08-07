<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un gestionnaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 40px 0;
        }

        .card {
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center rounded-top-4">
            <div>
                <h4 class="mb-0">🧑‍💼 Liste des gestionnaires</h4>
                <small class="text-muted">Gérer les informations des gestionnaires</small>
            </div>
           <!-- resources/views/gestionnaires/tableau.blade.php -->

<!-- Bouton pour ouvrir le modal -->
 <a href="#" class="btn btn-sm btn-outline-primary rounded-pill" title="ajouter"
   data-bs-toggle="modal" data-bs-target="#createGestionnaireModal">
   <i class="ri-user-add-line"></i>
   Ajouter
</a>

<div class="modal fade" id="createGestionnaireModal" tabindex="-1"
    aria-labelledby="createGestionnaireModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('gestionnaires.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createGestionnaireModalLabel">
                        Créer un nouveau gestionnaire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-4">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control form-control-lg" name="nom"
                            id="nom_create" placeholder="Entrer le nom" value="{{ old('nom') }}"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control form-control-lg" name="prenom"
                            id="prenom_create" placeholder="Entrer le prénom"
                            value="{{ old('prenom') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-lg" name="email"
                            id="email_create" placeholder="Entrer l'email"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="sexe" class="form-label">Sexe</label>
                        <select name="sexe" id="sexe" class="form-select form-select-lg" required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary btn-lg"
                            data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary btn-lg">Ajouter</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div> 

        </div> 

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 gap-3">
                <form class="input-group w-50">
                    <span class="input-group-text bg-white border-end-0 rounded-start-3">
                        <i class="ri-search-line"></i>
                    </span>
                    <input type="text" id="search-input" class="form-control border-start-0 rounded-end-3"
                        placeholder="Rechercher par nom...">
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light text-capitalize">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gestionnaires as $gestionnaire)
                            <tr>
                                <td>{{ $gestionnaire->nom }}</td>
                                <td>{{ $gestionnaire->prenom }}</td>
                                <td>{{ $gestionnaire->user->email }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-3">
                                        <a href="#" {{-- < type="button"    --}}
                                            class="btn btn-sm btn-outline-primary rounded-pill" title="Modifier"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editGestionnaireModal{{ $gestionnaire->id }}">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        {{-- formulaire edit --}}

                                        <div class="modal fade" id="editGestionnaireModal{{ $gestionnaire->id }}"tabindex="-1"
                                            aria-labelledby="editGestionnaireModalLabel{{ $gestionnaire->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST"
                                                        action="{{ route('gestionnaires.update', $gestionnaire->id) }}">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editGestionnaireModalLabel{{ $gestionnaire->id }}">
                                                                Modifier le gestionnaire</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            @if ($errors->any())
                                                                <div class="alert alert-danger">
                                                                    <ul class="mb-0">
                                                                        @foreach ($errors->all() as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif

                                                            <div class="mb-4">
                                                                <label for="nom" class="form-label">Nom</label>
                                                                <input type="text"
                                                                    class="form-control form-control-lg" name="nom"
                                                                    id="nom"
                                                                    value="{{ old('nom', $gestionnaire->nom) }}">
                                                            </div>

                                                            <div class="mb-4">
                                                                <label for="prenom" class="form-label">Prénom</label>
                                                                <input type="text"
                                                                    class="form-control form-control-lg" name="prenom"
                                                                    id="prenom"
                                                                    value="{{ old('prenom', $gestionnaire->prenom) }}">
                                                            </div>

                                                            <div class="mb-4">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email"
                                                                    class="form-control form-control-lg" name="email"
                                                                    id="email"
                                                                    value="{{ old('email', $gestionnaire->user->email) }}">
                                                            </div>

                                                            <div class="mb-4">
                                                                <label for="sexe" class="form-label">Sexe</label>
                                                                <select name="sexe" id="sexe"
                                                                    class="form-control form-control-lg" required>
                                                                    <option value="M"
                                                                        {{ old('sexe', $gestionnaire->sexe) === 'M' ? 'selected' : '' }}>
                                                                        Masculin</option>
                                                                    <option value="F"
                                                                        {{ old('sexe', $gestionnaire->sexe) === 'F' ? 'selected' : '' }}>
                                                                        Féminin</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <div class="d-flex justify-content-between">
                                                                <a class="btn btn-outline-secondary btn-lg"
                                                                    data-bs-dismiss="modal"> Annuler </a>
                                                                <button type="submit" class="btn btn-primary btn-lg">
                                                                    Mettre à jour </button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- suppression --}}

                                    <form action="{{ route('gestionnaires.destroy', $gestionnaire->id) }}"
                                        method="POST" onsubmit="return confirm('Confirmer la suppression ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                            title="Supprimer">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
            </div>
            </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-muted">Aucun gestionnaire trouvé.</td>
            </tr>
            @endforelse
            </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $gestionnaires->links() }}
        </div>
    </div>
</div>
</div>
</div>
</body>
</html>