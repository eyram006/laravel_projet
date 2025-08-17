<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire Médical</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-red: #dc3545;
      --secondary-red: #c82333;
      --light-red: #f8d7da;
      --dark-red: #bd2130;
      --gradient-bg: linear-gradient(135deg, #f55e5efd 0%, #f82626ff 100%);
      --card-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background: var(--gradient-bg);
      min-height: 100vh;
      padding: 20px 0;
      position: relative;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>') no-repeat center center;
      background-size: cover;
      pointer-events: none;
      z-index: -1;
    }

    .container {
      max-width: 800px;
      margin-top: 50px;
    }
    .form-group label {
      font-weight: bold;
    }
    .form-control:focus {
      border-color: var(--primary-red);
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
      background: white;
      transform: translateY(-2px);
    }

    .form-control:hover {
      border-color: #ced4da;
      background: white;
    }

    .input-group-text {
      background: var(--primary-red);
      color: white;
      border: none;
      border-radius: 12px 0 0 12px;
    }

    .btn {
      border-radius: 50px;
      padding: 12px 30px;
      font-weight: 600;
      font-size: 1rem;
      letter-spacing: 0.5px;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      border: none;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s ease;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-red), var(--secondary-red));
      color: white;
      margin: 10px;
    }

    .btn-primary:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
    .gyneco-section {
      display: none;
      background: linear-gradient(135deg, #ffeaa7, #fab1a0);
      padding: 30px;
      border-radius: 20px;
      margin: 20px 0;
      border: 3px solid rgba(220, 53, 69, 0.2);
      animation: expandSection 0.5s ease-out;
      box-shadow: inset 0 2px 10px rgba(0,0,0,0.1);
    }

    @keyframes expandSection {
      from {
        opacity: 0;
        transform: scaleY(0);
        transform-origin: top;
      }
      to {
        opacity: 1;
        transform: scaleY(1);
      }
    }

    .gyneco-section::before {
      content: '♀️ Section Gynécologique';
      display: block;
      font-weight: 700;
      font-size: 1.2rem;
      color: var(--primary-red);
      text-align: center;
      margin-bottom: 20px;
      padding: 10px;
      background: rgba(255,255,255,0.3);
      border-radius: 10px;
    }

    .error-message {
      color: #dc3545;
      font-size: 0.8rem;
      margin-top: 0.25rem;
    }
  </style>
</head>
<body>
  <div class="floating-icons">
    <div class="floating-icon" style="left: 10%; animation-delay: 0s;">🏥</div>
    <div class="floating-icon" style="left: 20%; animation-delay: 3s;">💊</div>
    <div class="floating-icon" style="left: 30%; animation-delay: 6s;">🩺</div>
    <div class="floating-icon" style="left: 40%; animation-delay: 9s;">❤️</div>
    <div class="floating-icon" style="left: 50%; animation-delay: 12s;">🏥</div>
    <div class="floating-icon" style="left: 60%; animation-delay: 2s;">💊</div>
    <div class="floating-icon" style="left: 70%; animation-delay: 5s;">🩺</div>
    <div class="floating-icon" style="left: 80%; animation-delay: 8s;">❤️</div>
    <div class="floating-icon" style="left: 90%; animation-delay: 11s;">🏥</div>
  </div>

  <div class="loading-overlay">
    <div class="loading-spinner"></div>
  </div>

  <div class="container">
    <div class="form-card">
      <div class="form-header">
        <h1><i class="fas fa-heartbeat"></i> Formulaire Médical</h1>
        <p>Questionnaire de santé confidentiel</p>
      </div>
      
      <div class="logo-container">
        <img src="{{ asset('images/logo-sunuSante.jpg') }}" alt="Logo Sunu Santé" class="img-fluid">
      </div>
      <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" class="form-control" id="nom" required>
        <div class="error-message" id="nom-error"></div>
      </div>
      <div class="form-group">
        <label for="date-naissance">Date de naissance</label>
        <input type="date" class="form-control" id="date-naissance" max="2025-08-10" required>
        <div class="error-message" id="date-naissance-error"></div>
      </div>
      <div class="form-group">
        <label for="sexe">Sexe</label>
        <select class="form-control" id="sexe" required>
          <option value="">Sélectionnez votre sexe</option>
          <option value="M">Masculin</option>
          <option value="F">Féminin</option>
        </select>
        <div class="error-message" id="sexe-error"></div>
      </div>
      <div class="form-group">
        <label for="situation-matrimoniale">Situation matrimoniale</label>
        <input type="text" class="form-control" id="situation-matrimoniale" required>
        <div class="error-message" id="situation-matrimoniale-error"></div>
      </div>
      <div class="form-group">
        <label for="niveau-etudes">Niveau d'études</label>
        <input type="text" class="form-control" id="niveau-etudes" required>
        <div class="error-message" id="niveau-etudes-error"></div>
      </div>
      <div class="form-group">
        <label for="quartier">Quartier</label>
        <input type="text" class="form-control" id="quartier" required>
        <div class="error-message" id="quartier-error"></div>
      </div>
      <div class="form-group">
        <label for="employeur">Employeur/Souscripteur</label>
        <input type="text" class="form-control" id="employeur" required>
        <div class="error-message" id="employeur-error"></div>
      </div>
      <div class="form-group">
        <label for="profession">Profession</label>
        <input type="text" class="form-control" id="profession" required>
        <div class="error-message" id="profession-error"></div>
      </div>
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" class="form-control" id="email" required>
        <div class="error-message" id="email-error"></div>
      </div>
      <div class="form-group">
        <label for="telephone">Téléphone</label>
        <input type="tel" class="form-control" id="telephone" required>
        <div class="error-message" id="telephone-error"></div>
      </div>
      <div class="form-group">
        <label for="couverture-sante">Avez-vous déjà bénéficié d'une couverture santé ?</label>
        <div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="couverture-sante" id="couverture-sante-oui" value="oui" required>
            <label class="form-check-label" for="couverture-sante-oui">Oui</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="couverture-sante" id="couverture-sante-non" value="non" required>
            <label class="form-check-label" for="couverture-sante-non">Non</label>
          </div>
        </div>
        <div class="error-message" id="couverture-sante-error"></div>
      </div>
      <div class="form-group">
        <label for="periode-couverture">Si oui, sur quelle période ?</label>
        <input type="text" class="form-control" id="periode-couverture">
        <div class="error-message" id="periode-couverture-error"></div>
      </div>
      <div class="form-group">
        <label for="personne-prevenir">Personne à prévenir</label>
        <input type="text" class="form-control" id="personne-prevenir" required>
        <div class="error-message" id="personne-prevenir-error"></div>
      </div>
      <div class="form-group">
        <label for="maladie-6mois">Maladie survenue il y a moins de 6 mois</label>
        <input type="text" class="form-control" id="maladie-6mois" required>
        <div class="error-message" id="maladie-6mois-error"></div>
      </div>
      <div class="form-group">
        <label for="maladie-chronique">Maladie chronique</label>
        <input type="text" class="form-control" id="maladie-chronique" required>
        <div class="error-message" id="maladie-chronique-error"></div>
      </div>
      <div class="form-group">
        <label for="traitement-cours">Traitement en cours</label>
        <input type="text" class="form-control" id="traitement-cours" required>
        <div class="error-message" id="traitement-cours-error"></div>
      </div>
      <div class="form-group">
        <label for="depenses-sante">Coût mensuel estimatif de vos dépenses en santé</label>
        <input type="number" class="form-control" id="depenses-sante" required>
        <div class="error-message" id="depenses-sante-error"></div>
      </div>
      <div class="form-group">
        <label for="lunettes">Portez-vous des lunettes ?</label>
        <div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="lunettes" id="lunettes-oui" value="oui" required>
            <label class="form-check-label" for="lunettes-oui">Oui</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="lunettes" id="lunettes-non" value="non" required>
            <label class="form-check-label" for="lunettes-non">Non</label>
          </div>
        </div>
        <div class="error-message" id="lunettes-error"></div>
      </div>
      <div class="gyneco-section">
        <div class="form-group">
          <label for="age-regles">Age aux 1ères règles</label>
          <input type="number" class="form-control" id="age-regles" required>
          <div class="error-message" id="age-regles-error"></div>
        </div>
        <div class="form-group">
          <label for="methode-contraceptive">Méthode contraceptive</label>
          <input type="text" class="form-control" id="methode-contraceptive" required>
          <div class="error-message" id="methode-contraceptive-error"></div>
        </div>
        <div class="form-group">
          <label for="maladie-seins">Maladie des seins</label>
          <input type="text" class="form-control" id="maladie-seins" required>
          <div class="error-message" id="maladie-seins-error"></div>
        </div>
        <div class="form-group">
          <label for="autre-maladie-genitale">Autre maladie génitale</label>
          <input type="text" class="form-control" id="autre-maladie-genitale" required>
          <div class="error-message" id="autre-maladie-genitale-error"></div>
        </div>
        <div class="form-group">
          <label for="maladie-col-uterus">Maladie du col de l'utérus</label>
          <input type="text" class="form-control" id="maladie-col-uterus" required>
          <div class="error-message" id="maladie-col-uterus-error"></div>
        </div>
        <div class="form-group">
          <label for="nb-grossesses">Nombre de grossesses</label>
          <input type="number" class="form-control" id="nb-grossesses" required>
          <div class="error-message" id="nb-grossesses-error"></div>
        </div>
        <div class="form-group">
          <label for="nb-accouchements">Nombre d'accouchements</label>
          <input type="number" class="form-control" id="nb-accouchements" required>
          <div class="error-message" id="nb-accouchements-error"></div>
        </div>
        <div class="form-group">
          <label for="derniere-grossesse">Particularités à la dernière grossesse</label>
          <textarea class="form-control" id="derniere-grossesse" rows="3" required></textarea>
          <div class="error-message" id="derniere-grossesse-error"></div>
        </div>
        <div class="form-group">
          <label for="annee-cesarienne">Si césarienne, préciser année et cause</label>
          <input type="text" class="form-control" id="annee-cesarienne" required>
          <div class="error-message" id="annee-cesarienne-error"></div>
        </div>
      </div>
      <div class="form-group">
        <label for="allergies">Allergies</label>
        <input type="text" class="form-control" id="allergies" required>
        <div class="error-message" id="allergies-error"></div>
      </div>
      <div class="form-group">
        <label for="antecedents-chirurgicaux">Antécédents chirurgicaux</label>
        <textarea class="form-control" id="antecedents-chirurgicaux" rows="3" required></textarea>
        <div class="error-message" id="antecedents-chirurgicaux-error"></div>
      </div>
      <div class="form-group">
        <label for="mode-vie">Mode de vie</label>
        <div class="row">
          <div class="col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="mode-vie-alcool" value="alcool">
              <label class="form-check-label" for="mode-vie-alcool">Alcool</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="mode-vie-tabac" value="tabac">
              <label class="form-check-label" for="mode-vie-tabac">Tabac</label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="mode-vie-cola" value="cola">
              <label class="form-check-label" for="mode-vie-cola">Cola</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="consommation-alcool">Consommation alcoolique / semaine</label>
              <input type="number" class="form-control" id="consommation-alcool"
              name="consommation-alcool" 
         min="0"              
         required           
         oninput="this.value = this.value < 0 ? 0 : this.value">
              <div class="error-message" id="consommation-alcool-error"></div>
            </div>
          </div>
         <div class="form-group">
  <label for="annees-tabagisme">Nombre d'années de tabagisme</label>
  <input type="number" 
         class="form-control" 
         id="annees-tabagisme" 
         name="annees_tabagisme" 
         min="0"              
         required           
         oninput="this.value = this.value < 0 ? 0 : this.value"> 
  <div class="error-message" id="annees-tabagisme-error"></div>
</div>

          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="cigarettes-jour">Cigarettes fumées / jour</label>
              <input type="number" class="form-control" id="cigarettes-jour" 
              name="cigarettes_jour" 
         min="0"              
         required           
         oninput="this.value = this.value < 0 ? 0 : this.value">
              <div class="error-message" id="cigarettes-jour-error"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="antecedents-familiaux">Antécédents familiaux</label>
        <textarea class="form-control" id="antecedents-familiaux" rows="3" required></textarea>
        <div class="error-message" id="antecedents-familiaux-error"></div>

      </div>
    </div>
  </div>

  <script>
    const sexeInput = document.getElementById('sexe');
    const gynecologieSection = document.querySelector('.gyneco-section');

    sexeInput.addEventListener('change', () => {
      if (sexeInput.value === 'F') {
        gynecologieSection.style.display = 'block';
      } else {
        gynecologieSection.style.display = 'none';
      }
    });

    const form = document.getElementById('medical-form');
    const loadingOverlay = document.querySelector('.loading-overlay');

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      
      // Validation basique
      const requiredFields = form.querySelectorAll('[required]');
      let isValid = true;
      
      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add('is-invalid');
          const errorElement = document.getElementById(field.id + '-error');
          if (errorElement) {
            errorElement.style.display = 'block';
            errorElement.textContent = 'Ce champ est obligatoire';
          }
        } else {
          field.classList.remove('is-invalid');
          const errorElement = document.getElementById(field.id + '-error');
          if (errorElement) {
            errorElement.style.display = 'none';
          }
        }
      });

      if (!isValid) {
        alert('Veuillez remplir tous les champs obligatoires');
        return;
      }
      
      // Afficher l'overlay de chargement
      loadingOverlay.style.display = 'flex';
      
      // Collecter les données
      const formData = collectFormData();
      console.log('Données à envoyer:', formData);
      
      // Simuler l'envoi (à remplacer par votre logique d'envoi réelle)
      setTimeout(() => {
        loadingOverlay.style.display = 'none';
        alert('Formulaire enregistré avec succès!');
        
        // Animation de succès
        form.style.transform = 'scale(0.95)';
        setTimeout(() => {
          form.style.transform = 'scale(1)';
        }, 200);
      }, 2000);
    });

    // Animation des icônes flottantes
    function createFloatingIcon() {
      const icons = ['🏥', '💊', '🩺', '❤️', '🔬', '💉', '🏥'];
      const icon = document.createElement('div');
      icon.className = 'floating-icon';
      icon.textContent = icons[Math.floor(Math.random() * icons.length)];
      icon.style.left = Math.random() * 100 + '%';
      icon.style.animationDuration = (Math.random() * 10 + 10) + 's';
      icon.style.animationDelay = Math.random() * 2 + 's';
      
      document.querySelector('.floating-icons').appendChild(icon);
      
      // Supprimer l'icône après l'animation
      setTimeout(() => {
        if (icon.parentNode) {
          icon.parentNode.removeChild(icon);
        }
      }, 17000);
    }

    // Créer des icônes flottantes périodiquement
    setInterval(createFloatingIcon, 3000);

    // Animation de démarrage
    window.addEventListener('load', () => {
      document.body.style.opacity = '1';
    });

    // Validation en temps réel
    document.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
      field.addEventListener('blur', function() {
        validateField(this);
      });
    });

    function validateField(field) {
      const errorElement = document.getElementById(field.id + '-error');
      if (field.value.trim() === '') {
        field.classList.add('is-invalid');
        if (errorElement) {
          errorElement.style.display = 'block';
          errorElement.textContent = 'Ce champ est obligatoire';
        }
      } else {
        field.classList.remove('is-invalid');
        if (errorElement) {
          errorElement.style.display = 'none';
        }
      }
    }

    // Animation de pulsation pour les champs obligatoires vides
    setInterval(() => {
      document.querySelectorAll('input[required]:invalid, select[required]:invalid, textarea[required]:invalid').forEach(field => {
        if (field.value.trim() === '') {
          field.style.animation = 'pulse 0.5s ease-in-out';
          setTimeout(() => {
            field.style.animation = '';
          }, 500);
        }
      });
    }, 5000);

    // Validation de l'email
    const emailField = document.getElementById('email');
    emailField.addEventListener('blur', function() {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const errorElement = document.getElementById('email-error');
      
      if (this.value && !emailPattern.test(this.value)) {
        this.classList.add('is-invalid');
        errorElement.style.display = 'block';
        errorElement.textContent = 'Format d\'email invalide';
      } else if (this.value) {
        this.classList.remove('is-invalid');
        errorElement.style.display = 'none';
      }
    });

    // Validation du téléphone
    const phoneField = document.getElementById('telephone');
    phoneField.addEventListener('blur', function() {
      const phonePattern = /^[\d\s\-\+\(\)]{8,15}$/;
      const errorElement = document.getElementById('telephone-error');
      
      if (this.value && !phonePattern.test(this.value)) {
        this.classList.add('is-invalid');
        errorElement.style.display = 'block';
        errorElement.textContent = 'Format de téléphone invalide';
      } else if (this.value) {
        this.classList.remove('is-invalid');
        errorElement.style.display = 'none';
      }
    });
  </script>

  <style>
    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
      70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
      100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    
    .is-invalid {
      border-color: var(--primary-red) !important;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
  </style>
</body>
</html>