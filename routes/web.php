<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
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
//                     employeController
Route::get('/employes', [EmployeController::class, 'index'])->name('employes.index');

Route::get('/employes/{id}/edit', [EmployeController::class, 'edit'])->name('employes.edit');

Route::put('/employes/{id}', [EmployeController::class, 'update'])->name('employes.update');

Route::delete('/employes{id}/destroy', [EmployeController::class,'destroy'])->name('employes.destroy');

Route::get('/employes/create', [EmployeController::class, 'create'])->name('employes.create');

Route::post('/employes', [EmployeController::class,'store'])->name('employes.store');

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

Route::get('/gestionnaires/create', [GestionnaireController::class, 'create'])->name('gestionnaires.create');

Route::post('/gestionnaires', [GestionnaireController::class, 'store'])->name('gestionnaires.store');

Route::delete('/gestionnaires/{id}/destroy', [GestionnaireController::class,'destroy'])->name('gestionnaires.destroy');


// Route::resource('gestionnaires',GestionnaireController::class);


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