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
      max-width: 1000px;
      margin-top: 30px;
      position: relative;
      z-index: 1;
    }

    .form-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 25px;
      box-shadow: var(--card-shadow);
      border: 1px solid rgba(255, 255, 255, 0.2);
      overflow: hidden;
      transform: translateY(30px);
      opacity: 0;
      animation: slideInUp 0.8s ease-out forwards;
    }

    @keyframes slideInUp {
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .form-header {
      background: linear-gradient(135deg, var(--primary-red), var(--secondary-red));
      color: white;
      padding: 40px 30px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .form-header::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: pulse 4s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.1); opacity: 0.8; }
    }

    .form-header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 10px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
      position: relative;
      z-index: 1;
    }

    .form-header p {
      font-size: 1.1rem;
      opacity: 0.9;
      margin: 0;
      position: relative;
      z-index: 1;
    }

    .logo-container {
      margin: 20px 0;
      text-align: center;
      position: relative;
      z-index: 1;
    }

    .logo-container img {
      max-width: 200px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      transition: var(--transition);
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }

    .logo-container img:hover {
      transform: scale(1.05) rotate(2deg);
      box-shadow: 0 15px 35px rgba(0,0,0,0.25);
    }

    .form-content {
      padding: 40px;
    }

    .section-divider {
      border: none;
      height: 3px;
      background: linear-gradient(90deg, transparent, var(--primary-red), transparent);
      margin: 30px 0;
      border-radius: 5px;
    }

    .section-title {
      font-size: 1.4rem;
      font-weight: 600;
      color: var(--primary-red);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .form-group {
      margin-bottom: 20px;
      position: relative;
      transform: translateX(-20px);
      opacity: 0;
      animation: slideInRight 0.6s ease-out forwards;
    }

    .form-group:nth-child(odd) { animation-delay: 0.1s; }
    .form-group:nth-child(even) { animation-delay: 0.2s; }

    @keyframes slideInRight {
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    .form-group label {
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.9rem;
      letter-spacing: 0.5px;
    }

    .form-group label i {
      color: var(--primary-red);
      font-size: 1rem;
    }

    .form-control, .form-check-input {
      border: 2px solid #e9ecef;
      border-radius: 12px;
      padding: 10px 14px;
      font-size: 0.9rem;
      transition: var(--transition);
      background: rgba(255, 255, 255, 0.9);
      position: relative;
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
      background: linear-gradient(135deg, var(--secondary-red), var(--dark-red));
      transform: translateY(-3px);
      box-shadow: 0 15px 35px rgba(220, 53, 69, 0.4);
    }

    .form-check {
      margin: 8px 0;
      padding: 10px 15px;
      background: rgba(248, 249, 250, 0.8);
      border-radius: 10px;
      transition: var(--transition);
      border: 2px solid transparent;
      display: flex;
      align-items: center;
    }

    .form-check:hover {
      background: rgba(220, 53, 69, 0.05);
      border-color: rgba(220, 53, 69, 0.2);
      transform: translateX(5px);
    }

    .form-check-input:checked {
      background-color: var(--primary-red);
      border-color: var(--primary-red);
    }

    .form-check-label {
      font-weight: 500;
      cursor: pointer;
      color: #495057;
      margin-left: 8px;
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
      color: var(--primary-red);
      font-size: 0.85rem;
      margin-top: 5px;
      padding: 8px 12px;
      background: var(--light-red);
      border-radius: 8px;
      border-left: 4px solid var(--primary-red);
      animation: shake 0.5s ease-in-out;
      display: none;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }

    .text-center {
      text-align: center;
      padding: 30px 0;
      background: rgba(248, 249, 250, 0.5);
      margin: 30px -40px -40px -40px;
      border-radius: 0 0 25px 25px;
    }

    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(220, 53, 69, 0.9);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loading-spinner {
      width: 50px;
      height: 50px;
      border: 5px solid rgba(255, 255, 255, 0.3);
      border-top: 5px solid white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .floating-icons {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
    }

    .floating-icon {
      position: absolute;
      font-size: 20px;
      color: rgba(255, 255, 255, 0.1);
      animation: floatRandom 15s linear infinite;
    }

    @keyframes floatRandom {
      0% {
        transform: translateY(100vh) rotate(0deg);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      90% {
        opacity: 1;
      }
      100% {
        transform: translateY(-100px) rotate(360deg);
        opacity: 0;
      }
    }

    .radio-group {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .radio-group .form-check {
      margin: 0;
      min-width: 120px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .container {
        margin: 10px;
        max-width: none;
      }
      
      .form-content {
        padding: 20px;
      }
      
      .form-header h1 {
        font-size: 2rem;
      }
      
      .btn {
        padding: 10px 20px;
        margin: 5px;
        font-size: 0.9rem;
      }

      .col-md-6 {
        margin-bottom: 15px;
      }
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 12px;
    }

    ::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, var(--primary-red), var(--secondary-red));
      border-radius: 10px;
      border: 2px solid transparent;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(135deg, var(--secondary-red), var(--dark-red));
    }

    .json-output {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
      max-height: 300px;
      overflow-y: auto;
    }

    .json-output pre {
      margin: 0;
      font-size: 0.85rem;
    }

    .is-invalid {
      border-color: var(--primary-red) !important;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
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
      
      <div class="form-content">
        <form id="medical-form" method="POST" action="{{ route('demandes.store') }}">
          @csrf
          
          <!-- Informations Personnelles -->
          <div class="section-title">
            <i class="fas fa-user"></i> Informations Personnelles
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nom"><i class="fas fa-user"></i> Nom</label>
                <input type="text" class="form-control" name="donnees_medicales[informations_personnelles][nom]" id="nom" required>
                <div class="error-message" id="nom-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="prenom"><i class="fas fa-user"></i> Prénom</label>
                <input type="text" class="form-control" name="donnees_medicales[informations_personnelles][prenom]" id="prenom" required>
                <div class="error-message" id="prenom-error"></div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="date-naissance"><i class="fas fa-calendar-alt"></i> Date de naissance</label>
                <input type="date" class="form-control" name="donnees_medicales[informations_personnelles][date_naissance]" id="date-naissance" required>
                <div class="error-message" id="date-naissance-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><i class="fas fa-venus-mars"></i> Sexe</label>
                <div class="radio-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="donnees_medicales[informations_personnelles][sexe]" id="sexe-m" value="M" required>
                    <label class="form-check-label" for="sexe-m">Masculin</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="donnees_medicales[informations_personnelles][sexe]" id="sexe-f" value="F" required>
                    <label class="form-check-label" for="sexe-f">Féminin</label>
                  </div>
                </div>
                <div class="error-message" id="sexe-error"></div>
              </div>
            </div>
          </div>

          <hr class="section-divider">
          
          <!-- Informations Socio-démographiques -->
          <div class="section-title">
            <i class="fas fa-home"></i> Informations Socio-démographiques
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="situation-matrimoniale"><i class="fas fa-rings-wedding"></i> Situation matrimoniale</label>
                <select class="form-control" name="donnees_medicales[informations_sociodemographiques][situation_matrimoniale]" id="situation-matrimoniale" required>
                  <option value="">Sélectionnez</option>
                  <option value="celibataire">Célibataire</option>
                  <option value="marie">Marié(e)</option>
                 
                </select>
                <div class="error-message" id="situation-matrimoniale-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="niveau-etudes"><i class="fas fa-graduation-cap"></i> Niveau d'études</label>
                <select class="form-control" name="donnees_medicales[informations_sociodemographiques][niveau_etudes]" id="niveau-etudes" required>
                  <option value="">Sélectionnez</option>
                  <option value="sans_education">Sans éducation formelle</option>
                  <option value="primaire">Primaire</option>
                  <option value="secondaire">Secondaire</option>
                  <option value="superieur">Supérieur</option>
                  <option value="universitaire">Universitaire</option>
                </select>
                <div class="error-message" id="niveau-etudes-error"></div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="quartier"><i class="fas fa-map-marker-alt"></i> Quartier</label>
                <input type="text" class="form-control" name="donnees_medicales[informations_sociodemographiques][quartier]" id="quartier" required>
                <div class="error-message" id="quartier-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="employeur"><i class="fas fa-building"></i> Employeur/Souscripteur</label>
                <input type="text" class="form-control" name="donnees_medicales[informations_sociodemographiques][employeur]" id="employeur" required>
                <div class="error-message" id="employeur-error"></div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="profession"><i class="fas fa-briefcase"></i> Profession</label>
                <input type="text" class="form-control" name="donnees_medicales[informations_sociodemographiques][profession]" id="profession" required>
                <div class="error-message" id="profession-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> E-mail</label>
                <input type="email" class="form-control" name="donnees_medicales[informations_sociodemographiques][email]" id="email" required>
                <div class="error-message" id="email-error"></div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="telephone"><i class="fas fa-phone"></i> Téléphone</label>
                <input type="tel" class="form-control" name="donnees_medicales[informations_sociodemographiques][telephone]" id="telephone" required>
                <div class="error-message" id="telephone-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="personne-prevenir"><i class="fas fa-user-friends"></i> Personne à prévenir</label>
                <input type="text" class="form-control" name="donnees_medicales[contact_urgence][personne_a_prevenir]" id="personne-prevenir" required>
                <div class="error-message" id="personne-prevenir-error"></div>
              </div>
            </div>
          </div>

          <hr class="section-divider">
          
          <!-- Couverture Santé -->
          <div class="section-title">
            <i class="fas fa-shield-alt"></i> Couverture Santé
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><i class="fas fa-shield-alt"></i> Avez-vous déjà bénéficié d'une couverture santé ?</label>
                <div class="radio-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="donnees_medicales[couverture_sante][deja_beneficie]" id="couverture-sante-oui" value="oui" required>
                    <label class="form-check-label" for="couverture-sante-oui">Oui</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="donnees_medicales[couverture_sante][deja_beneficie]" id="couverture-sante-non" value="non" required>
                    <label class="form-check-label" for="couverture-sante-non">Non</label>
                  </div>
                </div>
                <div class="error-message" id="couverture-sante-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="periode-couverture"><i class="fas fa-calendar-alt"></i> Si oui, sur quelle période ?</label>
                <input type="text" class="form-control" name="donnees_medicales[couverture_sante][periode]" id="periode-couverture">
                <div class="error-message" id="periode-couverture-error"></div>
              </div>
            </div>
          </div>

          <hr class="section-divider">
          
          <!-- Antécédents Médicaux -->
          <div class="section-title">
            <i class="fas fa-notes-medical"></i> Antécédents Médicaux
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="maladie-6mois"><i class="fas fa-thermometer-half"></i> Maladie survenue il y a moins de 6 mois</label>
                <input type="text" class="form-control" name="donnees_medicales[antecedents_medicaux][maladie_6_mois]" id="maladie-6mois" placeholder="Précisez ou tapez 'Aucune'">
                <div class="error-message" id="maladie-6mois-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="maladie-chronique"><i class="fas fa-heartbeat"></i> Maladie chronique</label>
                <input type="text" class="form-control" name="donnees_medicales[antecedents_medicaux][maladie_chronique]" id="maladie-chronique" placeholder="Précisez ou tapez 'Aucune'" required>
                <div class="error-message" id="maladie-chronique-error"></div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="traitement-cours"><i class="fas fa-pills"></i> Traitement en cours</label>
                <input type="text" class="form-control" name="donnees_medicales[antecedents_medicaux][traitement_en_cours]" id="traitement-cours" placeholder="Précisez ou tapez 'Aucun'" required>
                <div class="error-message" id="traitement-cours-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="depenses-sante"><i class="fas fa-money-bill-wave"></i> Coût mensuel estimatif (FCFA)</label>
                <input type="number" class="form-control" name="donnees_medicales[antecedents_medicaux][depenses_mensuelles_sante]" id="depenses-sante" min="0" required>
                <div class="error-message" id="depenses-sante-error"></div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><i class="fas fa-glasses"></i> Portez-vous des lunettes ?</label>
                <div class="radio-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="donnees_medicales[antecedents_medicaux][porte_lunettes]" id="lunettes-oui" value="oui" required>
                    <label class="form-check-label" for="lunettes-oui">Oui</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="donnees_medicales[antecedents_medicaux][porte_lunettes]" id="lunettes-non" value="non" required>
                    <label class="form-check-label" for="lunettes-non">Non</label>
                  </div>
                </div>
                <div class="error-message" id="lunettes-error"></div>
              </div>
            </div>
          </div>
          
          <!-- Section Gynécologique (affichée si sexe = F) -->
          <div class="gyneco-section">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="age-regles"><i class="fas fa-calendar-day"></i> Age aux 1ères règles</label>
                  <input type="number" class="form-control" name="donnees_medicales[gynecologie][age_premieres_regles]" id="age-regles" min="0">
                  <div class="error-message" id="age-regles-error"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="methode-contraceptive"><i class="fas fa-shield-alt"></i> Méthode contraceptive</label>
                  <select class="form-control" name="donnees_medicales[gynecologie][methode_contraceptive]" id="methode-contraceptive">
                    <option value="">Sélectionnez</option>
                    <option value="aucune">Aucune</option>
                    <option value="pilule">Pilule</option>
                    <option value="preservatif">Préservatif</option>
                    <option value="diu">DIU (Stérilet)</option>
                    <option value="implant">Implant</option>
                    <option value="injection">Injection</option>
                    <option value="autre">Autre</option>
                  </select>
                  <div class="error-message" id="methode-contraceptive-error"></div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="maladie-seins"><i class="fas fa-ribbon"></i> Maladie des seins</label>
                  <input type="text" class="form-control" name="donnees_medicales[gynecologie][maladie_seins]" id="maladie-seins" placeholder="Précisez ou tapez 'Aucune'">
                  <div class="error-message" id="maladie-seins-error"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="autre-maladie-genitale"><i class="fas fa-venus"></i> Autre maladie génitale</label>
                  <input type="text" class="form-control" name="donnees_medicales[gynecologie][autre_maladie_genitale]" id="autre-maladie-genitale" placeholder="Précisez ou tapez 'Aucune'">
                  <div class="error-message" id="autre-maladie-genitale-error"></div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="maladie-col-uterus"><i class="fas fa-venus"></i> Maladie du col de l'utérus</label>
                  <input type="text" class="form-control" name="donnees_medicales[gynecologie][maladie_col_uterus]" id="maladie-col-uterus" placeholder="Précisez ou tapez 'Aucune'">
                  <div class="error-message" id="maladie-col-uterus-error"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nb-grossesses"><i class="fas fa-baby"></i> Nombre de grossesses</label>
                  <input type="number" class="form-control" name="donnees_medicales[gynecologie][nombre_grossesses]" id="nb-grossesses" min="0" value="0">
                  <div class="error-message" id="nb-grossesses-error"></div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nb-accouchements"><i class="fas fa-baby-carriage"></i> Nombre d'accouchements</label>
                  <input type="number" class="form-control" name="donnees_medicales[gynecologie][nombre_accouchements]" id="nb-accouchements" min="0" value="0">
                  <div class="error-message" id="nb-accouchements-error"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="annee-cesarienne"><i class="fas fa-procedures"></i> Si césarienne, préciser année et cause</label>
                  <input type="text" class="form-control" name="donnees_medicales[gynecologie][cesarienne_details]" id="annee-cesarienne" placeholder="Ex: 2020 - Présentation par le siège">
                  <div class="error-message" id="annee-cesarienne-error"></div>
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="derniere-grossesse"><i class="fas fa-notes-medical"></i> Particularités à la dernière grossesse</label>
              <textarea class="form-control" name="donnees_medicales[gynecologie][particularites_derniere_grossesse]" id="derniere-grossesse" rows="3" placeholder="Décrivez ou tapez 'Aucune'"></textarea>
              <div class="error-message" id="derniere-grossesse-error"></div>
            </div>
          </div>
          
          <hr class="section-divider">
          
          <!-- Allergies et Antécédents -->
          <div class="section-title">
            <i class="fas fa-exclamation-triangle"></i> Allergies et Antécédents
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="allergies"><i class="fas fa-exclamation-triangle"></i> Allergies</label>
                <textarea class="form-control" name="donnees_medicales[allergies_antecedents][allergies]" id="allergies" rows="3" placeholder="Listez vos allergies ou tapez 'Aucune'" required></textarea>
                <div class="error-message" id="allergies-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="antecedents-chirurgicaux"><i class="fas fa-cut"></i> Antécédents chirurgicaux</label>
                <textarea class="form-control" name="donnees_medicales[allergies_antecedents][antecedents_chirurgicaux]" id="antecedents-chirurgicaux" rows="3" placeholder="Décrivez vos antécédents chirurgicaux ou tapez 'Aucun'" required></textarea>
                <div class="error-message" id="antecedents-chirurgicaux-error"></div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="antecedents-familiaux"><i class="fas fa-users"></i> Antécédents familiaux</label>
            <textarea class="form-control" name="donnees_medicales[allergies_antecedents][antecedents_familiaux]" id="antecedents-familiaux" rows="3" placeholder="Décrivez les antécédents médicaux familiaux significatifs" required></textarea>
            <div class="error-message" id="antecedents-familiaux-error"></div>
          </div>
          
          <!-- Mode de Vie -->
          <div class="section-title">
            <i class="fas fa-leaf"></i> Mode de Vie
          </div>
            
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="consommation-alcool"><i class="fas fa-wine-bottle"></i> Consommation alcoolique / semaine (verres)</label>
                <input type="number" class="form-control" name="donnees_medicales[mode_vie][consommation_alcool_semaine]" id="consommation-alcool" min="0" value="0" required>
                <div class="error-message" id="consommation-alcool-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="consommation-cola"><i class="fas fa-glass-whiskey"></i> Consommation de cola / jour (verres)</label>
                <input type="number" class="form-control" name="donnees_medicales[mode_vie][consommation_cola_jour]" id="consommation-cola" min="0" value="0" required>
                <div class="error-message" id="consommation-cola-error"></div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="annees-tabagisme"><i class="fas fa-calendar-times"></i> Nombre d'années de tabagisme</label>
                <input type="number" class="form-control" name="donnees_medicales[mode_vie][annees_tabagisme]" id="annees-tabagisme" min="0" value="0" required>
                <div class="error-message" id="annees-tabagisme-error"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="cigarettes-jour"><i class="fas fa-smoking-ban"></i> Cigarettes fumées / jour</label>
                <input type="number" class="form-control" name="donnees_medicales[mode_vie][cigarettes_par_jour]" id="cigarettes-jour" min="0" value="0" required>
                <div class="error-message" id="cigarettes-jour-error"></div>
              </div>
            </div>
          </div>
          
          <div class="text-center">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Enregistrer la demande
            </button>
            <button type="button" class="btn btn-primary" id="preview-json">
              <i class="fas fa-eye"></i> Aperçu JSON
            </button>
          </div>
          
          <!-- Aperçu JSON -->
          <div class="json-output" id="json-preview" style="display: none;">
            <h5><i class="fas fa-code"></i> Aperçu des données JSON :</h5>
            <pre id="json-content"></pre>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Animation des éléments au scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.animationPlayState = 'running';
        }
      });
    }, observerOptions);

    // Observer tous les form-groups
    document.querySelectorAll('.form-group').forEach(group => {
      observer.observe(group);
    });

    // Logique gynécologique
    const sexeInputs = document.querySelectorAll('input[name="donnees_medicales[informations_personnelles][sexe]"]');
    const gynecologieSection = document.querySelector('.gyneco-section');

    sexeInputs.forEach(input => {
      input.addEventListener('change', () => {
        if (input.value === 'F' && input.checked) {
          gynecologieSection.style.display = 'block';
          gynecologieSection.style.animationPlayState = 'running';
          
          // Rendre les champs gynécologiques obligatoires
          gynecologieSection.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
            field.setAttribute('required', 'required');
          });
        } else if (input.value === 'M' && input.checked) {
          gynecologieSection.style.display = 'none';
          
          // Retirer l'obligation des champs gynécologiques
          gynecologieSection.querySelectorAll('input, select, textarea').forEach(field => {
            field.removeAttribute('required');
            field.value = ''; // Vider les champs
          });
        }
      });
    });

    // Fonction pour collecter toutes les données du formulaire
    function collectFormData() {
      const formData = new FormData(document.getElementById('medical-form'));
      const jsonData = {
        donnees_medicales: {
          informations_personnelles: {},
          informations_sociodemographiques: {},
          couverture_sante: {},
          contact_urgence: {},
          antecedents_medicaux: {},
          gynecologie: {},
          allergies_antecedents: {},
          mode_vie: {}
        }
      };

      // Parcourir tous les champs du formulaire
      for (let [name, value] of formData.entries()) {
        if (name.startsWith('donnees_medicales[')) {
          // Extraire la structure des noms de champs
          const match = name.match(/donnees_medicales\[([^\]]+)\]\[([^\]]+)\]/);
          if (match) {
            const section = match[1];
            const field = match[2];
            
            if (!jsonData.donnees_medicales[section]) {
              jsonData.donnees_medicales[section] = {};
            }
            
            jsonData.donnees_medicales[section][field] = value;
          }
        }
      }

      // Nettoyer les sections vides
      Object.keys(jsonData.donnees_medicales).forEach(section => {
        if (Object.keys(jsonData.donnees_medicales[section]).length === 0) {
          delete jsonData.donnees_medicales[section];
        }
      });

      return jsonData;
    }

    // Aperçu JSON
    const previewButton = document.getElementById('preview-json');
    const jsonPreview = document.getElementById('json-preview');
    const jsonContent = document.getElementById('json-content');

    previewButton.addEventListener('click', () => {
      const data = collectFormData();
      jsonContent.textContent = JSON.stringify(data, null, 2);
      
      if (jsonPreview.style.display === 'none') {
        jsonPreview.style.display = 'block';
        previewButton.innerHTML = '<i class="fas fa-eye-slash"></i> Masquer JSON';
      } else {
        jsonPreview.style.display = 'none';
        previewButton.innerHTML = '<i class="fas fa-eye"></i> Aperçu JSON';
      }
    });

    // Animation des inputs au focus
    document.querySelectorAll('.form-control').forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
      });
    });

    // Animation des boutons radio et checkbox
    document.querySelectorAll('.form-check-input').forEach(input => {
      input.addEventListener('change', function() {
        if (this.checked) {
          this.parentElement.style.background = 'rgba(220, 53, 69, 0.1)';
          this.parentElement.style.borderColor = 'rgba(220, 53, 69, 0.3)';
          this.parentElement.style.transform = 'scale(1.05)';
        } else {
          this.parentElement.style.background = 'rgba(248, 249, 250, 0.8)';
          this.parentElement.style.borderColor = 'transparent';
          this.parentElement.style.transform = 'scale(1)';
        }
      });
    });

    // Logique du formulaire
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
</body>
</html>