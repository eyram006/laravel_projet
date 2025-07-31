<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;

Route::redirect('/', '/dashboard');

Route::middleware(["auth"])->prefix('/')->group(function () {
    Route::resources([ 'dashboard'=> DashboardController::class,
    ]);
});



//Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
                            //employeController
   Route::get('/employes', [EmployeController::class, 'index'])->name('employes.index');

    Route::get('/employes/{id}/edit', [EmployeController::class, 'edit'])->name('employes.edit');
   
    Route::put('/employes/{id}/update', [EmployeController::class, 'update'])->name('employes.update');

Route::get('/employes-tableau', [EmployeController::class, 'index'])->name('employes.tableau');
   // });
                                 //demandeController
    //  Route::get('/', [DemandeController::class, 'index'])->name('demandes.index');

    // Route::get('/{id}/edit', [DemandeControllerController::class, 'edit'])->name('demandes.edit');
   
    // Route::put('/{id}/update', [DemandeControllerController::class, 'update'])->name('demandes.update');

//     Route::middleware(['auth', 'can:is-gestionnaire'])->prefix('demandes')->group(function () {
//                             //demandeController
//     Route::get('/', [DemandeController::class, 'index'])->name('demandes.index');
// });



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

 

require __DIR__.'/auth.php';

//Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });