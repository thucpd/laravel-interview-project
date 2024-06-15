<?php

use App\Http\Controllers\FruitCategoryController;
use App\Http\Controllers\FruitInvoiceController;
use App\Http\Controllers\FruitItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Fruit Category

Route::get('/fruit-category', [FruitCategoryController::class, 'index'])->middleware(['auth', 'verified'])->name('fruit-category');
Route::get('/fruit-category/create', [FruitCategoryController::class, 'create'])->middleware(['auth', 'verified'])->name('fruit-category.create');
Route::post('/fruit-category/store', [FruitCategoryController::class, 'store'])->middleware(['auth', 'verified'])->name('fruit-category.store');
Route::get('/fruit-category/{id}/edit', [FruitCategoryController::class, 'edit'])->middleware(['auth', 'verified'])->name('fruit-category.edit');
Route::post('/fruit-category/{id}/update', [FruitCategoryController::class, 'update'])->middleware(['auth', 'verified'])->name('fruit-category.update');
Route::get('/fruit-category/{id}/delete', [FruitCategoryController::class, 'delete'])->middleware(['auth', 'verified'])->name('fruit-category.delete');
Route::post('/fruit-category/{id}/destroy', [FruitCategoryController::class, 'destroy'])->middleware(['auth', 'verified'])->name('fruit-category.destroy');


//Fruit Item

Route::get('/fruit-item', [FruitItemController::class, 'index'])->middleware(['auth', 'verified'])->name('fruit-item');
Route::get('/fruit-item/create', [FruitItemController::class, 'create'])->middleware(['auth', 'verified'])->name('fruit-item.create');
Route::post('/fruit-item/store', [FruitItemController::class, 'store'])->middleware(['auth', 'verified'])->name('fruit-item.store');
Route::get('/fruit-item/{id}/edit', [FruitItemController::class, 'edit'])->middleware(['auth', 'verified'])->name('fruit-item.edit');
Route::post('/fruit-item/{id}/update', [FruitItemController::class, 'update'])->middleware(['auth', 'verified'])->name('fruit-item.update');
Route::get('/fruit-item/{id}/delete', [FruitItemController::class, 'delete'])->middleware(['auth', 'verified'])->name('fruit-item.delete');
Route::post('/fruit-item/{id}/destroy', [FruitItemController::class, 'destroy'])->middleware(['auth', 'verified'])->name('fruit-item.destroy');

//Fruit Invoice

Route::get('/fruit-invoice', [FruitInvoiceController::class, 'index'])->middleware(['auth', 'verified'])->name('fruit-invoice');
Route::get('/fruit-invoice/create', [FruitInvoiceController::class, 'create'])->middleware(['auth', 'verified'])->name('fruit-invoice.create');
Route::post('/fruit-invoice/store', [FruitInvoiceController::class, 'store'])->middleware(['auth', 'verified'])->name('fruit-invoice.store');
Route::get('/fruit-invoice/{id}/edit', [FruitInvoiceController::class, 'edit'])->middleware(['auth', 'verified'])->name('fruit-invoice.edit');
Route::post('/fruit-invoice/{id}/update', [FruitInvoiceController::class, 'update'])->middleware(['auth', 'verified'])->name('fruit-invoice.update');
Route::get('/fruit-invoice/{id}/delete', [FruitInvoiceController::class, 'delete'])->middleware(['auth', 'verified'])->name('fruit-invoice.delete');
Route::post('/fruit-invoice/{id}/destroy', [FruitInvoiceController::class, 'destroy'])->middleware(['auth', 'verified'])->name('fruit-invoice.destroy');
Route::get('/fruit-invoice/{id}/print', [FruitInvoiceController::class, 'print'])->middleware(['auth', 'verified'])->name('fruit-invoice.print');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
