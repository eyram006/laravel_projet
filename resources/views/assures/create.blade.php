<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un assuré</title>
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
                <h2 class="text-center mb-4">Ajouter un assuré</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('assures.store') }}">
                    @csrf

                    {{-- Nom --}}
                    <div class="mb-4">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control form-control-lg" name="nom" id="nom" value="{{ old('nom') }}" required>
                    </div>

                    {{-- Prénoms --}}
                    <div class="mb-4">
                        <label for="prenoms" class="form-label">Prénoms</label>
                        <input type="text" class="form-control form-control-lg" name="prenoms" id="prenoms" value="{{ old('prenoms') }}" required>
                    </div>

                    {{-- Sexe --}}
                    <div class="mb-4">
                        <label for="sexe" class="form-label">Sexe</label>
                        <select name="sexe" id="sexe" class="form-select form-select-lg" required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" class="form-control form-control-lg" name="email" id="email" value="{{ old('email') }}" required>
                    </div>

                    {{-- Contact --}}
                    <div class="mb-4">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control form-control-lg" name="contact" id="contact" value="{{ old('contact') }}" required>
                    </div>

                    {{-- Adresse --}}
                    <div class="mb-4">
                        <label for="addresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control form-control-lg" name="addresse" id="addresse" value="{{ old('addresse') }}">
                    </div>

                    {{--
