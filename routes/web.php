<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscriptionReportController;
use App\Models\Views\ProductReport;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/presentation', fn () => Inertia::render('Presentation', [
    // real rows straight from the database view (same one the report uses)
    'viewRows' => ProductReport::query()
        ->orderByDesc('price')
        ->take(5)
        ->get(['product_name', 'category_name', 'price', 'price_with_tax']),
]))->name('presentation');

Route::get('/', fn () => redirect()->route('presentation'));
Route::get('/report', [ReportController::class, 'index'])->name('report');
Route::post('/report/{id}/price', [ReportController::class, 'updatePrice'])->name('report.updatePrice');

// Live-demo endpoints for the "active subscriptions with usage" slides.
Route::get('/reports/subscriptions/bad', [SubscriptionReportController::class, 'bad'])->name('reports.subscriptions.bad');
Route::get('/reports/subscriptions/clean', [SubscriptionReportController::class, 'clean'])->name('reports.subscriptions.clean');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
