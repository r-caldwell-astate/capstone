<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\PDFController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function (Request $request) {
    $contracts = $request->user()
        ->contracts()
        ->with('status') 
        ->latest() //newest first
        ->get();

    return Inertia::render('Dashboard', [
        'contracts' => $contracts,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('contracts', ContractController::class);
});

require __DIR__.'/auth.php';
