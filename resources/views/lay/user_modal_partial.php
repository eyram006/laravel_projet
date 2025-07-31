{{-- resources/views/layouts/partials/modals/user-modal.blade.php --}}
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle">Nouveau gestionnaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="userForm" onsubmit="saveUser(event)">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom *</label>
                            <input type="text" class="form-control" id="userFirstName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="userLastName" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" id="userEmail" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="userPhone">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rôle *</label>
                            <select class="form-select" id="userRole" required>
                                <option value="">Sélectionner un rôle</option>
                                <option value="admin">Administrateur</option>
                                <option value="manager">Gestionnaire</option>
                                <option value="agent">Agent</option>
                                <option value="viewer">Consultation</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Statut</label>
                            <select class="form-select" id="userStatus">
                                <option value="active">Actif</option>
                                <option value="inactive">Inactif</option>
                                <option value="suspended">Suspendu</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3" id="passwordSection">
                        <label class="form-label">Mot de passe temporaire *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="userPassword" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="generatePassword()">
                                <i class="fas fa-key"></i> Générer
                            </button>
                        </div>
                        <div class="form-text">L'utilisateur devra changer ce mot de passe à sa première connexion</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Département</label>
                        <input type="text" class="form-control" id="userDepartment" placeholder="Ex: Sinistres, Commercial, Support...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="userNotes" rows="3" placeholder="Notes administratives..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>