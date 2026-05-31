<?php

use Illuminate\Support\Facades\Route;

// ── Public landing page ──────────────────────────────────────
Route::get('/', function () {
    return view('pages.welcome');
})->name('home');

// ── Grant portal (hospital registration & login) ─────────────
// These will be Livewire routes — add them as you build the portal
// Route::get('/portal', ...)->name('portal');
// Route::get('/portal/register', ...)->name('portal.register');
// Route::get('/portal/login', ...)->name('portal.login');
// Route::get('/portal/dashboard', ...)->middleware('auth')->name('portal.dashboard');
