<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssureController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;

Route::redirect('/', '/dashboard')->name('dashboard');

Route::get('/', [AuthController::class, 'index']);

Route::middleware(["auth"])->prefix('/')->group(function () {
    Route::resources(['dashboard' => DashboardController::class,]);
})->name('dashboard');



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

Route::get('/demandes/{id}/show', [DemandeController::class, 'show'])->name('demandes.show');



Route::get('/gestionnaires', [GestionnaireController::class, 'index'])->name('gestionnaires.index');

Route::get('/gestionnaires/{id}/edit', [GestionnaireController::class, 'edit'])->name('gestionnaires.edit');

Route::put('/gestionnaires/{id}', [GestionnaireController::class, 'update'])->name('gestionnaires.update');

Route::get('/gestionnaires/{id}/show', [GestionnaireController::class, 'show'])->name('gestionnaires.show');

//Route::get('/gestionnaires/create', [GestionnaireController::class, 'create'])->name('gestionnaires.create');

Route::post('/gestionnaires', [GestionnaireController::class, 'store'])->name('gestionnaires.store');

Route::delete('/gestionnaires/{id}/destroy', [GestionnaireController::class,'destroy'])->name('gestionnaires.destroy');


// Route::resource('gestionnaires',GestionnaireController::class);

Route::get('assures-export', [AssureController::class, 'export'])->name('assures.export');
Route::post('/assures/import', [AssureController::class, 'import'])->name('assures.import');
Route::get('/assures/import', [AssureController::class, 'showImport'])->name('assures.import.show');

Route::get('/form',function(){
    return view('formulaire');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//     Route::middleware(['auth', 'can:is-gestionnaire'])->prefix('demandes')->group(function () {
//                             //demandeController
//     Route::get('/', [DemandeController::class, 'index'])->name('demandes.index');
// });

require __DIR__ . '/auth.php';

//Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });