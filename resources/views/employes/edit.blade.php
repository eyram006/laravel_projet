<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Modifier utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f88282e1;
            padding: 40px 0;
        }

        .card {
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(93, 3, 3, 0.1);
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
                    <h2 class="text-center mb-4">Modifier l'employe</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('employes.update', $employe->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control form-control-lg" name="name" id="name"
                                value="{{ old('name', $employe->name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control form-control-lg" name="email" id="email"
                                value="{{ old('email', $employe->email) }}" required>
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