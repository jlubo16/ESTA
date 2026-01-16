<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TraerDatosController;
use App\Http\Controllers\AnalisisController;
use App\Models\Subcategory; // ← AGREGAR ESTA LÍNEA

Route::get('/', function () {
    return view('Dashboard.dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/datos', [TraerDatosController::class, 'traerDatos'])->name('traerDatos');

// Rutas existentes de análisis
Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis.index');
Route::post('/analizar', [AnalisisController::class, 'analizar'])->name('analisis.calcular');
Route::post('/importar-csv', [AnalisisController::class, 'importarCSV'])->name('analisis.importar.csv');

// Nuevas rutas para análisis detallado
Route::get('/analisis/detallado', [AnalisisController::class, 'index'])->name('analisis.detallado');
Route::post('/analisis/calcular-detallado', [AnalisisController::class, 'analizarDetallado'])->name('analisis.calcular.detallado');

// API para subcategorías - CORREGIDA
Route::get('/api/categorias/{categoria}/subcategorias', function($categoria) {
    $subcategorias = Subcategory::where('category_id', $categoria)->get();
    return response()->json($subcategorias);
});


// Nuevo: Módulo de Estadística Avanzada
Route::get('/analisis/frecuencias', [AnalisisController::class, 'frecuencias'])->name('analisis.frecuencias');
Route::get('/analisis/tendencias', [AnalisisController::class, 'tendencias'])->name('analisis.tendencias');
Route::get('/analisis/comparativo', [AnalisisController::class, 'comparativo'])->name('analisis.comparativo');
Route::get('/analisis/exportar', [AnalisisController::class, 'exportar'])->name('analisis.exportar');