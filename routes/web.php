<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssureController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\GestionnaireController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Controllers\ImportAssuresController;
// Routes publiques (accessibles sans authentification)
//Route::get('/', [AuthController::class, 'index'])->name('home');
// J'ai commenté cette route pour résoudre le conflit
// Route::get('/connexion', [AuthController::class, 'showLogin'])->name('connexion.show');


// Routes protégées (nécessitent une authentification)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
  Route::get('/', function(){
    return view('auth_page');
  }) ->name('connexion.show');
    // Routes des assurés
    Route::get('/assures', [AssureController::class, 'index'])->name('assures.index');
    Route::get('/assures/{id}/edit', [AssureController::class, 'edit'])->name('assures.edit');
    Route::put('/assures/{id}', [AssureController::class, 'update'])->name('assures.update');
    // Correction du paramètre dans l'URL
    Route::delete('/assures/{id}/destroy', [AssureController::class,'destroy'])->name('assures.destroy');
    Route::get('/assures/create', [AssureController::class, 'create'])->name('assures.create');
    Route::post('/assures', [AssureController::class,'store'])->name( 'assures.store');
//  Route::resource('assures', AssureController::class);
    // Routes des demandes
    Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index'); 
    Route::get('/demandes/{id}/edit', [DemandeController::class, 'edit'])->name('demandes.edit');
    Route::put('/demandes/{id}/update', [DemandeController::class, 'update'])->name('demandes.update');
    
    // Routes des gestionnaires
    Route::get('/gestionnaires', [GestionnaireController::class, 'index'])->name('gestionnaires.index');
    Route::get('/gestionnaires/{id}/edit', [GestionnaireController::class, 'edit'])->name('gestionnaires.edit');
    Route::put('/gestionnaires/{id}', [GestionnaireController::class, 'update'])->name('gestionnaires.update');
    Route::get('/gestionnaires/{id}/show', [GestionnaireController::class, 'show'])->name('gestionnaires.show');
    Route::post('/gestionnaires', [GestionnaireController::class, 'store'])->name('gestionnaires.store');
    Route::delete('/gestionnaires/{id}/destroy', [GestionnaireController::class,'destroy'])->name('gestionnaires.destroy');
    
    // Autres routes protégées
    Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');
    Route::get('/assures-export', [AssureController::class, 'export'])->name('assures.export');
    Route::post('/assures-import', [AssureController::class, 'import'])->name('assures.import');
    Route::get('/assures-import', [AssureController::class, 'showImport'])->name('assures.import.show');
    Route::get('/form', function(){ return view('formulaire'); })->name('formulaire_demande');
    Route::get('/demandes/{demande}', [DemandeController::class, 'show'])->name('demandes.show');
});

Route::post('/assures', [ImportAssuresController::class, 'import'])->name('assures.import');

Route::redirect('/', '/dashboard')->name('dashboard');

Route::get('/', [AuthController::class, 'index']);

Route::middleware(["auth"])->group(function () {
    Route::resources(['dashboard' => DashboardController::class,]);

    // Logs et paramètres (pages Blade dédiées)
    Route::get('/logs', fn () => view('logs.index'))->name('logs.index')->middleware('role:admin');
    Route::get('/settings', fn () => view('settings.index'))->name('settings.index');
});



// Route::middleware(['auth'])->group(function () {
//                     assureController
Route::get('/assures', [AssureController::class, 'index'])->name('assures.index');

Route::get('/assures/{id}/edit', [AssureController::class, 'edit'])->name('assures.edit');

Route::put('/assures/{id}', [AssureController::class, 'update'])->name('assures.update');

Route::delete('/assures{id}/destroy', [AssureController::class,'destroy'])->name('assures.destroy');

Route::get('/assures/create', [AssureController::class, 'create'])->name('assures.create');

Route::post('/assures', [AssureController::class,'store'])->name('assures.store');

  //});
                        //demandeController
Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index'); 

Route::get('/demandes/{id}/edit', [DemandeController::class, 'edit'])->name('demandes.edit');

Route::put('/demandes/{id}/update', [DemandeController::class, 'update'])->name('demandes.update');

//Route::get('/demandes/{id}/show', [DemandeController::class, 'show'])->name('demandes.show');



Route::get('/gestionnaires', [GestionnaireController::class, 'index'])->name('gestionnaires.index');

Route::get('/gestionnaires/{id}/edit', [GestionnaireController::class, 'edit'])->name('gestionnaires.edit');

Route::put('/gestionnaires/{id}', [GestionnaireController::class, 'update'])->name('gestionnaires.update');

Route::get('/gestionnaires/{id}/show', [GestionnaireController::class, 'show'])->name('gestionnaires.show');

//Route::get('/gestionnaires/create', [GestionnaireController::class, 'create'])->name('gestionnaires.create');

Route::post('/gestionnaires', [GestionnaireController::class, 'store'])->name('gestionnaires.store');

Route::delete('/gestionnaires/{id}/destroy', [GestionnaireController::class,'destroy'])->name('gestionnaires.destroy');


// Route::resource('gestionnaires',GestionnaireController::class);

Route::post('', [DemandeController::class, 'store'])->name('demandes.store');

Route::get('assures-export', [AssureController::class, 'export'])->name('assures.export');
Route::post('assures-import', [AssureController::class, 'import'])->name('assures.import');
Route::get('/import', [AssureController::class, 'showImport'])->name('assures.import.show');

Route::get('/form',function(){
    return view('formulaire');
})->name('formulaire_demande');

 Route::get('/{demande}', [DemandeController::class, 'show'])->name('demandes.show');



require __DIR__ . '/auth.php';
