<?php


use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('panel.index');
});


// Route::get('/productos', [ProductoController::class, 'index'])->name('producto.index');
// Route::post('/productos', [ProductoController::class, 'store'])->name('producto.store');
// Route::get('/productos/create', [ProductoController::class, 'create'])->name('producto.create');
// Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('producto.show');
// Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('producto.update');
// Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('producto.destroy');

Route::resource('/productos', ProductoController::class)->names('producto');