<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\Settings;
use App\Services\InvoicePdfGenerator;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

Route::get('receipt/pdf/{receipt}', function (\App\Models\Receipt $receipt) {
    $pdf = \Spatie\LaravelPdf\Facades\Pdf::view('documents.receipt', [
        'receipt' => $receipt,
        'image' => base64_encode(file_get_contents(public_path('logo.png'))),
    ]);

    return $pdf->format('a4')->toResponse(request());
})->name('receipt.pdf');

Route::get('quotation/pdf/{quotation}', function (\App\Models\Quotation $quotation) {
    $pdf = \Spatie\LaravelPdf\Facades\Pdf::view('documents.quotation', [
        'quotation' => $quotation,
        'image' => base64_encode(file_get_contents(public_path('logo.png'))),
        'settings' => Settings::all()
    ]);

    return $pdf->format('a4')->toResponse(request());
})->name('quotation.pdf');

Route::get('invoice/pdf/{invoice}', function (\App\Models\Invoice $invoice) {
    $pdf = InvoicePdfGenerator::generate($invoice);

    return $pdf
        ->format('a4')
        ->toResponse(request());

})->name('invoice.pdf');

Route::get('/test/{type?}', function (string $type) {
    return \Spatie\LaravelPdf\Facades\Pdf::view('test', ['image' => base64_encode(file_get_contents(public_path('logo.png')))])
        ->format('a4')
        ->toResponse(request());
});
require __DIR__.'/auth.php';
