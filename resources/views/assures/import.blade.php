{{-- @extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-file-excel me-2"></i>Import des Assurés
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Zone d'alerte pour les résultats -->
                    @if(session('import_results'))
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Résultats de l'import</h6>
                            <ul class="mb-0">
                                <li><strong>Ajoutés:</strong> {{ session('import_results')['ajoutes'] }}</li>
                                <li><strong>Ignorés:</strong> {{ session('import_results')['ignores'] }}</li>
                                @php $erreurs = data_get(session('import_results'), 'erreurs', []); @endphp
                                @if(is_array($erreurs) && count($erreurs) > 0)
                                    <li><strong>Erreurs:</strong></li>
                                    <ul>
                                        @foreach($erreurs as $erreur)
                                            <li>Ligne {{ data_get($erreur, 'ligne', '?') }}: {{ implode(', ', data_get($erreur, 'erreurs', [])) }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('assures.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf
                        
                        <!-- Zone d'upload -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-cloud-upload-alt me-2"></i>Fichier Excel
                            </label>
                            <div class="upload-zone" id="uploadZone">
                                <div class="upload-content text-center p-4 border-2 border-dashed border-secondary rounded">
                                    <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                                    <h5>Glissez votre fichier ici</h5>
                                    <p class="text-muted mb-3">ou cliquez pour sélectionner</p>
                                    <button type="button" class="btn btn-outline-primary" id="selectFileBtn">
                                        <i class="fas fa-folder-open me-2"></i>Parcourir
                                    </button>
                                    <input type="file" id="fileInput" name="fichier" accept=".xlsx,.xls,.csv" style="display: none;" required>
                                </div>
                            </div>
                            
                            <div id="fileInfo" class="file-info mt-3" style="display: none;">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <i class="fas fa-file-check text-success me-2"></i>
                                    <div class="flex-grow-1">
                                        <strong id="fileName"></strong>
                                        <div class="text-muted small" id="fileSize"></div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="removeFile">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="instructions mb-4">
                            <h6><i class="fas fa-info-circle me-2"></i>Instructions</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Colonnes requises:</h6>
                                    <ul class="small">
                                        <li><strong>nom</strong> - Nom de famille (obligatoire)</li>
                                        <li><strong>prenoms</strong> - Prénoms (obligatoire)</li>
                                        <li><strong>sexe</strong> - M ou F uniquement (obligatoire)</li>
                                        <li><strong>email</strong> - Format valide et unique (obligatoire)</li>
                                        <li><strong>contact</strong> - Numéro de téléphone</li>
                                        <li><strong>addresse</strong> - Adresse complète</li>
                                        <li><strong>date_de_naissance</strong> - Format DD/MM/YYYY, YYYY-MM-DD ou DD-MM-YYYY</li>
                                        <li><strong>anciennete</strong> - Ancienneté</li>
                                        <li><strong>statut</strong> - Statut de l'assuré</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary">Format du fichier:</h6>
                                    <ul class="small">
                                        <li><strong>Extensions supportées:</strong> .xlsx, .xls, .csv</li>
                                        <li><strong>Taille maximale:</strong> 10MB</li>
                                        <li><strong>Première ligne:</strong> Doit contenir les en-têtes des colonnes</li>
                                        <li><strong>Encodage:</strong> UTF-8 recommandé</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton d'import -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg" id="importBtn">
                                <i class="fas fa-upload me-2"></i>Importer les Assurés
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template Excel -->
<div class="mt-4">
    <div class="card">
        <div class="card-header">
            <h6><i class="fas fa-download me-2"></i>Télécharger un template Excel</h6>
        </div>
        <div class="card-body">
            <p class="mb-3">Téléchargez ce fichier Excel pour voir le format attendu et l'utiliser comme modèle.</p>
            <a href="{{ route('assures.export') }}" class="btn btn-outline-success">
                <i class="fas fa-download me-2"></i>Télécharger le template
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');
    const selectFileBtn = document.getElementById('selectFileBtn');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFile = document.getElementById('removeFile');
    const importBtn = document.getElementById('importBtn');

    // Gestion du drag & drop
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadZone.classList.add('border-primary');
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('border-primary');
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('border-primary');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });

    // Sélection de fichier
    selectFileBtn.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleFile(this.files[0]);
        }
    });

    // Suppression de fichier
    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        fileInfo.style.display = 'none';
        uploadZone.style.display = 'block';
        importBtn.disabled = true;
    });

    function handleFile(file) {
        // Validation du type de fichier
        const allowedTypes = ['.xlsx', '.xls', '.csv'];
        const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
        
        if (!allowedTypes.includes(fileExtension)) {
            alert('Type de fichier non supporté. Veuillez utiliser un fichier Excel (.xlsx, .xls) ou CSV.');
            return;
        }

        // Validation de la taille
        if (file.size > 10 * 1024 * 1024) { // 10MB
            alert('Fichier trop volumineux. Taille maximale: 10MB');
            return;
        }

        // Affichage des informations du fichier
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        
        uploadZone.style.display = 'none';
        fileInfo.style.display = 'block';
        importBtn.disabled = false;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
@endpush

@push('styles')
<style>
.upload-zone {
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-zone:hover {
    background-color: #f8f9fa;
}

.upload-zone.border-primary {
    border-color: #007bff !important;
    background-color: #f8f9fa;
}

.file-info {
    background-color: #f8f9fa;
    border-radius: 0.375rem;
}

.instructions {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
    border-left: 4px solid #007bff;
}

.instructions h6 {
    color: #007bff;
    margin-bottom: 1rem;
}

.instructions ul {
    margin-bottom: 0;
}

.instructions li {
    margin-bottom: 0.25rem;
}
</style>
@endpush

 --}}
