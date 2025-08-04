<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Modifier gestionnaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f58b8bff;
            padding: 40px 0;
        }

        .card {
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(144, 2, 2, 0.64);
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
                <h2 class="text-center mb-4">Modifier le gestionnaire</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('gestionnaires.update', $gestionnaire->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control form-control-lg" name="nom" id="nom"
                               value="{{ old('nom', $gestionnaire->nom) }}" >
                    </div>

                    <div class="mb-4">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control form-control-lg" name="prenom" id="prenom"
                               value="{{ old('prenom', $gestionnaire->prenom) }}" >
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-lg" name="email" id="email"
                               value="{{ old('email', $gestionnaire->user->email) }}" >
                    </div>

                    <div class="mb-4">
                        <label for="sexe" class="form-label">Sexe</label>
                        <select name="sexe" id="sexe" class="form-control form-control-lg" required>
                            <option value="M" {{ old('sexe', $gestionnaire->sexe) === 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('sexe', $gestionnaire->sexe) === 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg">Annuler</a>
                        <button type="submit" class="btn btn-primary btn-lg">Mettre à jour</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>
