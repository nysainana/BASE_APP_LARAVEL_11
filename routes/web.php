<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocieteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => to_route("dashboard"));

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');

    Route::middleware(["permission.auto"])->group(function () {
        Route::get("/dashboard", [DashboardController::class, 'index'])->name("dashboard");

        Route::put('/societe/{societe}', [SocieteController::class, 'update'])->name('societe.update');
        Route::get('/information-societe', [SocieteController::class, 'edit'])->name('societe.edit');
        Route::post('/societe/{societe}/logo', [SocieteController::class, 'uploadLogo'])->name('societe.logo.upload');
        Route::delete('/societe/{societe}/logo', [SocieteController::class, 'deleteLogo'])->name('societe.logo.delete');

        Route::get('/utilisateur', [UserController::class, 'index'])->name('user.index');
        Route::post('/utilisateur', [UserController::class, 'store'])->name('user.store');
        Route::put('/utilisateur/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/utilisateur/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        Route::get('/role-utilisateur', [RoleUserController::class, 'index'])->name('role-user.index');
        Route::post('/role-utilisateur', [RoleUserController::class, 'store'])->name('role-user.store');
        Route::put('/role-utilisateur/{role_user}', [RoleUserController::class, 'update'])->name('role-user.update');
        Route::delete('/role-utilisateur/{role_user}', [RoleUserController::class, 'destroy'])->name('role-user.destroy');
    });
});

require __DIR__.'/auth.php';
