## projet_final — Documentation technique

Application Laravel pour la gestion d’assurance (assurés, bénéficiaires, demandes, gestionnaires, cartes) avec un front Vue 3 via Inertia.js, Vite et Tailwind CSS. Import/Export Excel pris en charge.

### Aperçu fonctionnel
- **Authentification**: basée sur Laravel Breeze (vues Blade), routes `connexion`/`logout` (`routes/auth.php`).
- **Tableau de bord**: `DashboardController@index` sert la vue `resources/views/dashboard.blade.php`, avec les rôles de l’utilisateur connecté.
- **Modules métier**:
  - **Assurés** (`Assure`), **Bénéficiaires** (`Beneficiare`), **Demandes** (`Demande`), **Gestionnaires** (`Gestionnaire`), **Clients** (`Client`), **Cartes** (`Carte`).
  - Import/Export assurés: `assures-import` (POST), `assures-export` (GET).
- **Rôles & permissions**: via Spatie Permission (trait `HasRoles` sur `User`).

### Stack technique
- **Backend**
  - PHP 8.2, Laravel 12 (`laravel/framework`).
  - Inertia Laravel (`inertiajs/inertia-laravel`) avec SSR activé (`config/inertia.php`).
  - Spatie Permission (`spatie/laravel-permission`).
  - Maatwebsite Excel (`maatwebsite/excel`, `phpoffice/phpspreadsheet`).
  - Tighten Ziggy (`tightenco/ziggy`) pour exposer les routes Laravel au front Vue.
  - Tests avec Pest (`pestphp/pest`, plugin Laravel) et `phpunit.xml` présent.
- **Frontend**
  - Vue 3 (`vue`), Inertia Vue 3 (`@inertiajs/vue3`).
  - Vite 7 (`vite`) et plugin Laravel (`laravel-vite-plugin`).
  - Tailwind CSS (plugin Vite `@tailwindcss/vite`).
  - Utilitaires: `@vueuse/core`, `lucide-vue-next`, `reka-ui`, `class-variance-authority`, `tailwind-merge`, `tw-animate-css`.

### Architecture et interactions
- **Routing HTTP**: `routes/web.php`
  - Redirection `/` → `/dashboard` et ressource `dashboard` protégée par `auth`.
  - Routes métier: `assures`, `demandes`, `gestionnaires`, import/export.
  - Note: plusieurs routes métier ne sont pas (encore) sous middleware `auth` (commenté). À sécuriser selon le besoin.
- **Contrôleurs**: exemple `DashboardController` charge l’utilisateur (avec ses rôles) et renvoie une vue Blade. D’autres contrôleurs (Assure, Demande, Gestionnaire) gèrent CRUD + import/export.
- **Modèles & relations** (extraits clés):
  - `User` (HasRoles) ↔ `Client`/`Assure`/`Beneficiare`/`Gestionnaire` (liens 1–1 ou 1–n selon le cas).
  - `Client` 1–n `Assure`; `Assure` 1–n `Beneficiare`, 1–1 `Demande`, 1–1 `Carte`.
  - `Demande` n–1 `Assure` et n–1 `Gestionnaire`.
- **Front Vue + Inertia**
  - Entrée: `resources/js/app.ts` (SPA Inertia) et `resources/js/ssr.ts` (SSR Inertia).
  - Résolution des pages: Inertia attend des composants sous `resources/js/pages/**/*.vue` et SSR est configuré sur `http://127.0.0.1:13714`.
  - `ZiggyVue` est enregistré pour utiliser les routes Laravel côté Vue.
  - Le projet contient de nombreux composants Vue (`resources/js/components/**`) et des vues Blade. Le rendu est donc hybride: Blade pour plusieurs écrans et Vue/Inertia prêt pour un rendu SPA/SSR.

### Structure des répertoires (haut niveau)
- `app/Http/Controllers/*`: Auth, Dashboard, et contrôleurs métier.
- `app/Models/*`: `User`, `Client`, `Assure`, `Beneficiare`, `Demande`, `Gestionnaire`, `Carte`.
- `app/Enums/*`: `RoleEnum`, `StatutEnum`, `Type_beneficiaireEnum` (casts utilisés dans certains modèles).
- `resources/views/*`: Vues Blade (auth, dashboard, gestionnaires, demandes, assures, layouts…).
- `resources/js/*`: bootstrap Inertia/Vue (`app.ts`, `ssr.ts`), composables (`useAppearance.ts`), composants Vue.
- `database/migrations/*`: tables utilisateurs, permissions, et tables métier (clients, gestionnaires, demandes, assures, bénéficiaires, cartes).
- `database/seeders/*`: `RoleSeeder`, `UserSeeder`, `ClientSeeder`, etc.

### Installation
Prérequis: PHP 8.2+, Composer, Node 18+, npm, base de données (MySQL/PostgreSQL/SQLite), extensions PHP pour `phpoffice/phpspreadsheet`.

1) Dépendances
```bash
composer install
npm install
```

2) Environnement
```bash
copy .env.example .env   # PowerShell/Windows
php artisan key:generate
# Configurez DB_* dans .env
```

3) Base de données
```bash
php artisan migrate --seed
```

### Démarrage en développement
- Mode classique (serveur + file d’attente + Vite):
```bash
composer run dev
```
- Avec SSR Inertia et logs en continu:
```bash
composer run dev:ssr
```

Accès: `http://127.0.0.1:8000` (par défaut). Le service SSR écoute `http://127.0.0.1:13714` conformément à `config/inertia.php`.

### Commandes utiles
- Tests: `composer test` ou `php artisan test`
- Lint/format front: `npm run lint`, `npm run format`, `npm run format:check`
- Build production: `npm run build`

### Import/Export Excel (Assurés)
- Export: `GET /assures-export` → génère un fichier avec en-têtes prédéfinies.
- Import: `POST /assures-import` (format attendu: colonnes `Nom, Prénoms, Sexe, Email, Contact, Adresse, Date de Naissance, Ancienneté, Statut`).
  - La logique d’import détaillée est esquissée dans `app/Imports/AssuresImport.php` (structure prête, parties de validation/mapping commentées à compléter selon vos règles métier).

### Authentification & rôles
- Auth: vues Blade (`resources/views/auth_*.blade.php` et `auth_page.blade.php`).
- Connexion: `GET/POST /connexion`. Déconnexion: `GET /logout`.
- Rôles/permissions: package Spatie installé, `User` utilise `HasRoles`. Pensez à exécuter les seeders pour créer les rôles de base.

### Notes et points d’attention
- Plusieurs routes métier dans `routes/web.php` ne sont pas protégées par `auth` (middleware commenté). Recommandé: regrouper sous `Route::middleware(['auth'])->group(...)`.
- Inertia SSR est activé; assurez-vous que vos pages existent sous `resources/js/pages/` comme attendu par `app.ts` et `ssr.ts`.
- Tailwind: le projet inclut le plugin Vite `@tailwindcss/vite` (éco-système Tailwind 4). Vérifiez la configuration Tailwind si vous migrez depuis v3.

### Licence
MIT (suivant la configuration par défaut de Laravel starter).


