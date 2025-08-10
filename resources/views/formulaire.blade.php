<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire Médical</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #f5f5f5;
    }
    .container {
      max-width: 800px;
      margin-top: 50px;
    }
    .form-group label {
      font-weight: bold;
    }
    .form-control:focus {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    .btn-primary {
      background-color: #dc3545;
      border-color: #dc3545;
    }
    .btn-primary:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
    .gyneco-section {
      display: none;
    }
    .error-message {
      color: #dc3545;
      font-size: 0.8rem;
      margin-top: 0.25rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-center text-danger mb-4">Formulaire Médical</h1>
    <form id="medical-form">
      <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" class="form-control" id="prenom" required>
        <div class="error-message" id="prenom-error"></div>
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
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <button type="button" class="btn btn-primary" id="add-beneficiary">Ajouter un bénéficiaire</button>
      </div>
    </form>
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
    form.addEventListener('submit', (event) => {
      event.preventDefault();

      // Récupérer les données du formulaire
      const formData = new FormData(form);
      const jsonData = {};
      for (const [key, value] of formData.entries()) {
        jsonData[key] = value;
      }

      // Envoyer les données au serveur (par exemple, en utilisant Axios)
      console.log(jsonData);
    });

    const addBeneficiaryButton = document.getElementById('add-beneficiary');
    addBeneficiaryButton.addEventListener('click', () => {
      // Ouvrir un nouveau formulaire ou rediriger vers une page de gestion des bénéficiaires
      console.log('Ajouter un bénéficiaire');
    });
  </script>
</body>
</html>
