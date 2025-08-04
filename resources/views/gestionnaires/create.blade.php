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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card bg-white">
                <h2 class="text-center mb-4">Ajouter un gestionnaire</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('gestionnaires.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control form-control-lg" name="nom" id="nom" value="{{ old('nom') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control form-control-lg" name="prenom" id="prenom" value="{{ old('prenom') }}" required>
                    </div>

                     <div class="mb-3">
        <label for="email">Adresse email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

                    <div class="mb-4">
                        <label for="sexe" class="form-label">Sexe</label>
                        <select name="sexe" id="sexe" class="form-select form-select-lg" required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>


                    {{-- <div class="mb-4">
                        <label for="user_id" class="form-label">Utilisateur lié</label>
                        <select name="user_id" id="user_id" class="form-select form-select-lg" required>
                            <option value="">-- Sélectionnez un utilisateur --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg">Annuler</a>
                        <button type="submit" class="btn btn-primary btn-lg">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
