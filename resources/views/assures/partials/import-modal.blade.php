{{-- <!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-file-excel me-2"></i>Import des Assurés
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <!-- Zone d'alerte pour les résultats -->
                <div id="alertContainer"></div>
                
                <form id="importForm" enctype="multipart/form-data">
                    <!-- Sélection du client -->
                    <div class="mb-4">
                        <label for="client_id" class="form-label fw-bold">
                            <i class="fas fa-building me-2"></i>Client
                        </label>
                        <select name="client_id" id="client_id" class="form-select" required>
                            <option value="">Sélectionner un client</option>
                            <option value="1">Client Test 1</option>
                            <option value="2">Client Test 2</option>
                        </select>
                    </div>

                    <!-- Zone d'upload -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-cloud-upload-alt me-2"></i>Fichier Excel
                        </label>
                        <div class="upload-zone" id="uploadZone">
                            <div class="upload-content">
                                <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                                <h5>Glissez votre fichier ici</h5>
                                <p class="text-muted mb-3">ou cliquez pour sélectionner</p>
                                <button type="button" class="btn btn-outline-primary" id="selectFileBtn">
                                    <i class="fas fa-folder-open me-2"></i>Parcourir
                                </button>
                                <input type="file" id="fileInput" name="file" accept=".xlsx,.xls,.csv" style="display: none;" required>
                            </div>
                        </div>
                        
                        <div id="fileInfo" class="file-info" style="display: none;">
                            <div class="d-flex align-items-center">
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

                    <!-- Barre de progression -->
                    <div class="progress-container">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Progression</span>
                            <span id="progressText">0%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                 role="progressbar" style="width: 0%" id="progressBar"></div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="instructions">
                        <h6><i class="fas fa-info-circle me-2"></i>Instructions</h6>
                        <ul class="mb-0 small">
                            <li><strong>Colonnes requises:</strong> Nom, Prénoms, Sexe, Email, Contact, Adresse, Date de Naissance, Ancienneté, Statut</li>
                            <li><strong>Format des dates:</strong> DD/MM/YYYY, YYYY-MM-DD ou DD-MM-YYYY</li>
                            <li><strong>Sexe:</strong> M ou F uniquement</li>
                            <li><strong>Email:</strong> Format valide et unique par client</li>
                            <li><strong>Taille max:</strong> 10MB</li>
                        </ul>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="button" class="btn btn-import text-white" id="importBtn" disabled>
                    <span class="spinner-container">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    </span>
                    <i class="fas fa-upload me-2"></i>Importer les Assurés
                </button>
            </div>
        </div>
    </div>
</div> --}}
