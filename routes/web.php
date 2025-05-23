<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('filament.admin.pages.dashboard');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('pdf/{quotation}', function (\App\Models\Quotation $quotation) {
    $pdf = \Spatie\LaravelPdf\Facades\Pdf::view('test', [
        'quotation' => $quotation,
        'image' => base64_encode(file_get_contents(public_path('logo.png'))),
    ]);

    return $pdf->format('a4')->toResponse(request());
})->name('quotation.pdf');

Route::get('/test', function () {
    return \Spatie\LaravelPdf\Facades\Pdf::view('test', ['image' => base64_encode(file_get_contents(public_path('logo.png')))])
        ->format('a4')
        ->toResponse(request());
});
require __DIR__.'/auth.php';
