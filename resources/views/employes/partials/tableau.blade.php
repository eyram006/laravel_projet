 <body class="bg-light">

     <div class="container-fluid py-4">
         <div class="card shadow rounded-4 border-0">
             <div class="card-header bg-white d-flex justify-content-between align-items-center rounded-top-4">
                 <div>
                     <h4 class="mb-0">👨‍💼 Liste des employés</h4>
                     <small class="text-muted">Gérer les informations des employés</small>
                 </div>

                 {{-- <a href="{{ route('employes.create') }}"
                     class="btn btn-primary d-flex align-items-center gap-2 rounded-pill shadow-sm px-4 py-2">
                     <i class="ri-user-add-line"></i>
                     Ajouter
                 </a> --}}

                 <a href="#" class="btn btn-sm btn-outline-primary rounded-pill" title="ajouter"
                     data-bs-toggle="modal" data-bs-target="#createEmployeModal">
                     <i class="ri-user-add-line"></i>
                     Ajouter
                 </a>

                 <div class="modal fade" id="createEmployeModal" tabindex="-1"
                     aria-labelledby="createEmployeModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <form method="POST" action="{{ route('employes.store') }}">
                                 @csrf

                                 <div class="modal-header">
                                     <h5 class="modal-title" id="createEmployeModalLabel">
                                         creer un nouvel employé</h5>
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
                                         <label for="prenoms" class="form-label">Prénoms</label>
                                         <input type="text" class="form-control form-control-lg" name="prenoms"
                                             id="prenoms_create" placeholder="Entrer les prénoms"
                                             value="{{ old('prenoms') }}" required>
                                     </div>

                                     <div class="mb-3">
                                         <label for="email_create" class="form-label">Adresse email</label>
                                         <input type="email" name="email" class="form-control" id="email_create"
                                             required>
                                     </div>

                                     <div class="mb-4">
                                         <label for="sexe" class="form-label">Sexe</label>
                                         <select name="sexe" id="sexe" class="form-select form-select-lg"
                                             required>
                                             <option value="">-- Sélectionnez --</option>
                                             <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin
                                             </option>
                                             <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin
                                             </option>
                                         </select>
                                     </div>

                                     <div class="mb-4">
                                         <label for="contact" class="form-label">Contact</label>
                                         <input type="text" name="contact" id="contact"
                                             class="form-control form-control-lg"
                                             placeholder="Entrer le contact(+228 12345677)"
                                             value="{{ old('contact') }}">
                                     </div>

                                     <div class="mb-4">
                                         <label for="addresse" class="form-label">Adresse</label>
                                         <input type="text" name="addresse" id="addresse"
                                             class="form-control form-control-lg"
                                             placeholder="Entrer la ville de residence" value="{{ old('addresse') }}">
                                     </div>
                                     <div class="mb-4">
                                         <label for="entreprise_id" class="form-label">Entreprise</label>
                                         <select name="entreprise_id" id="entreprise_id"
                                             class="form-select form-select-lg" required>
                                             <option value="">-- Sélectionnez l'entreprise correspondante--
                                             </option>
                                             @foreach ($entreprises as $entreprise)
                                                 <option value="{{ $entreprise->id }}"
                                                     {{ old('entreprise_id') == $entreprise->id ? 'selected' : '' }}>
                                                     {{ $entreprise->raison_social }}
                                                 </option>
                                             @endforeach
                                         </select>
                                     </div>

                                     <div class="mb-4 form-check">
                                         <input type="checkbox" name="is_principal" id="is_principal"
                                             class="form-check-input" value="1"
                                             {{ old('is_principal') ? 'checked' : '' }}>
                                         <label for="is_principal" class="form-check-label">Assuré principal</label>
                                     </div>
                                     {{-- </div> --}}

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
                             <th>Entreprise</th>

                             <th>Actions</th>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse ($employes as $employe)
                             <tr>
                                 <td>{{ $employe->nom }}</td>
                                 <td>{{ $employe->prenoms }}</td>
                                 <td>{{ $employe->email }}</td>
                                 <td>{{ $employe->entreprise->raison_social ?? 'Non assigné' }}</td>
                                 {{-- <td><span class="badge bg-success">Actif</span></td> --}}
                                 <td>
                                     <div class="d-flex justify-content-center gap-3">
                                         <a href="#" {{-- < type="button"    --}}
                                             class="btn btn-sm btn-outline-primary rounded-pill" title="Modifier"
                                             data-bs-toggle="modal"
                                             data-bs-target="#editEmployeModal{{ $employe->id }}">
                                             <i class="ri-pencil-line"></i>
                                         </a>
                                         {{-- formulaire edit --}}

                                         <div class="modal fade" id="editEmployeModal{{ $employe->id }}"
                                             tabindex="-1"
                                             aria-labelledby="editEmployeModalLabel{{ $employe->id }}"
                                             aria-hidden="true">
                                             <div class="modal-dialog">
                                                 <div class="modal-content">
                                                     <form method="POST"
                                                         action="{{ route('employes.update', $employe->id) }}">
                                                         @csrf
                                                         @method('PUT')

                                                         <div class="modal-header">
                                                             <h5 class="modal-title"
                                                                 id="editEmployeModalLabel{{ $employe->id }}">
                                                                 Modifier l'employé</h5>
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
                                                                     class="form-control form-control-lg"
                                                                     name="nom" id="nom"
                                                                     placeholder="Entrer le nom"
                                                                     value="{{ old('nom', $employe->nom) }}">
                                                             </div>

                                                             <div class="mb-4">
                                                                 <label for="prenoms"
                                                                     class="form-label">Prénom</label>
                                                                 <input type="text"
                                                                     class="form-control form-control-lg"
                                                                     name="prenoms" id="prenoms"
                                                                     placeholder="Entrer les prénoms"
                                                                     value="{{ old('prenoms', $employe->prenoms) }}">
                                                             </div>

                                                             <div class="mb-4">
                                                                 <label for="email"
                                                                     class="form-label">Email</label>
                                                                 <input type="email"
                                                                     class="form-control form-control-lg"
                                                                     name="email" id="email"
                                                                     placeholder="Entrer l'email"
                                                                     value="{{ old('email', $employe->email) }}">
                                                             </div>

                                                             <div class="mb-4">
                                                                 <label for="sexe" class="form-label">Sexe</label>
                                                                 <select name="sexe" id="sexe"
                                                                     class="form-control form-control-lg" required>
                                                                     <option value="M"
                                                                         {{ old('sexe', $employe->sexe) === 'M' ? 'selected' : '' }}>
                                                                         Masculin</option>
                                                                     <option value="F"
                                                                         {{ old('sexe', $employe->sexe) === 'F' ? 'selected' : '' }}>
                                                                         Féminin</option>
                                                                 </select>
                                                             </div>

                                                             <div class="mb-4">
                                                                 <label for="contact"
                                                                     class="form-label">Contact</label>
                                                                 <input type="text" name="contact"
                                                                     id="contact_edit"
                                                                     class="form-control form-control-lg"
                                                                     placeholder="Entrer le contact"
                                                                     value="{{ old('contact', $employe->contact) }}">
                                                             </div>
                                                             <div class="mb-4">
                                                                 <label for="addresse"
                                                                     class="form-label">ville</label>
                                                                 <input type="text" name="addresse"
                                                                     id="addresse_edit"
                                                                     class="form-control form-control-lg"
                                                                     placeholder="Entrer la ville"
                                                                     value="{{ old('addresse', $employe->addresse) }}">
                                                             </div>

                                                             <div class="mb-4">
                                                                 <label for="entreprise_id"
                                                                     class="form-label">Entreprise</label>
                                                                 <select name="entreprise_id" id="entreprise_id"
                                                                     class="form-select form-select-lg" required>
                                                                     <option value=""> Sélectionnez l'entreprise
                                                                         --</option>
                                                                     @foreach ($entreprises as $entreprise)
                                                                         <option value="{{ $entreprise->id }}"
                                                                             {{ old('entreprise_id', $employe->entreprise_id ?? '') == $entreprise->id ? 'selected' : '' }}>
                                                                             {{ $entreprise->raison_social }}
                                                                         </option>
                                                                     @endforeach
                                                                 </select>
                                                             </div>

                                                             <div class="mb-4 form-check">
                                                                 <input type="checkbox" name="is_principal"
                                                                     id="is_principal_edit" class="form-check-input"
                                                                     value="1"
                                                                     {{ old('is_principal', $employe->is_principal) ? 'checked' : '' }}>
                                                                 <label for="is_principal_edit"
                                                                     class="form-check-label">assure principal</label>
                                                             </div>

                                                         </div>

                                                         <div class="modal-footer">
                                                             <div class="d-flex justify-content-between">
                                                                 <a class="btn btn-outline-secondary btn-lg"
                                                                     data-bs-dismiss="modal"> Annuler </a>
                                                                 <button type="submit"
                                                                     class="btn btn-primary btn-lg">
                                                                     Enregistrer </button>
                                                             </div>
                                                     </form>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     {{-- suppression --}}


                                     <form action="{{ route('employes.destroy', $employe->id) }}" method="POST"
                                         onsubmit="return confirm('Confirmer la suppression ?');">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                             title="Supprimer">
                                             <i class="ri-delete-bin-line"></i>
                                         </button>

             </div>
             </form>
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
     </div>
     </div>
     {{-- </div>
 </div> --}}
     <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 </body>
