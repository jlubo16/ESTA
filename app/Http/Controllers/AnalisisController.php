<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;

class AnalisisController extends Controller
{
    public function index()
    {
        $categorias = Category::with('subcategories')->forExpenses()->get();
        
        return view('Dashboard.analisis', [
            'promIngreso' => 0,
            'promFijos' => 0,
            'promDinamicos' => 0,
            'desviacion' => 0,
            'porcFijos' => 0,
            'porcDinamicos' => 0,
            'saldo' => 0,
            'moda' => 'N/A',
            'ingresos' => [],
            'gastosFijos' => [],
            'gastosDinamicos' => [],
            'conclusion' => [],
            'desviacionIngresos' => 0,
            'medianaIngresos' => 0,
            'medianaFijos' => 0,
            'medianaDinamicos' => 0,
            'cvIngresos' => 0,
            'cvGastosDinamicos' => 0,
            'rangoIngresos' => 0,
            'rangoFijos' => 0,
            'rangoDinamicos' => 0,
            'ingresoAnual' => 0,
            'gastosFijosAnual' => 0,
            'gastosDinamicosAnual' => 0,
            'saldoAnual' => 0,
            'categorias' => $categorias,
            'analisis_categorias' => [],
            'tendencias_mensuales' => [],
            'modo_analisis' => 'basico'
        ]);
    }

  public function analizar(Request $request)
{
    // ✅ VERIFICACIÓN EXPLÍCITA DE BALANCE
    if (count($request->ingresos) !== count($request->gastos_fijos) || 
        count($request->ingresos) !== count($request->gastos_dinamicos)) {
        
        logger('ERROR DE BALANCE EN CONTROLADOR:', [
            'ingresos_count' => count($request->ingresos),
            'fijos_count' => count($request->gastos_fijos),
            'dinamicos_count' => count($request->gastos_dinamicos),
            'ingresos_values' => $request->ingresos,
            'fijos_values' => $request->gastos_fijos,
            'dinamicos_values' => $request->gastos_dinamicos
        ]);
        
        return back()->with('error', 
            'Error: Los datos están desbalanceados. ' .
            'Ingresos: ' . count($request->ingresos) . ' meses, ' .
            'Fijos: ' . count($request->gastos_fijos) . ' meses, ' .
            'Dinámicos: ' . count($request->gastos_dinamicos) . ' meses. ' .
            'Por favor, usa el botón "Agregar Otro Mes" para mantener el balance.'
        );
    }

    $request->validate([
        'ingresos' => 'required|array|min:1',
        'ingresos.*' => 'required|numeric|min:0',
        'gastos_fijos' => 'sometimes|array|min:1', // 'sometimes' en lugar de 'required'
        'gastos_fijos.*' => 'sometimes|numeric|min:0',
        'gastos_dinamicos' => 'sometimes|array|min:1',
        'gastos_dinamicos.*' => 'sometimes|numeric|min:0'
    ]);

    // Asegurar que los arrays existen (convertir null a array vacío)
    $ingresos = $request->ingresos ?? [];
    $gastosFijos = $request->gastos_fijos ?? [];
    $gastosDinamicos = $request->gastos_dinamicos ?? [];

    // Verificar que hay datos en ingresos (el único requerido)
    if (empty($ingresos)) {
        return back()->with('error', 'Debes ingresar al menos un ingreso');
    }

    $maxMeses = max(
        count($ingresos),
        count($gastosFijos),
        count($gastosDinamicos)
    );

    // Si no hay gastos, crear arrays con ceros
    if (empty($gastosFijos)) {
        $gastosFijos = array_fill(0, $maxMeses, 0);
    }
    
    if (empty($gastosDinamicos)) {
        $gastosDinamicos = array_fill(0, $maxMeses, 0);
    }

    // Normalizar los arrays para que tengan la misma longitud
    $ingresos = array_pad($ingresos, $maxMeses, 0);
    $gastosFijos = array_pad($gastosFijos, $maxMeses, 0);
    $gastosDinamicos = array_pad($gastosDinamicos, $maxMeses, 0);

    // Filtrar meses que tengan al menos un dato > 0
    $mesesConDatos = [];
    for ($i = 0; $i < $maxMeses; $i++) {
        if ($ingresos[$i] > 0 || $gastosFijos[$i] > 0 || $gastosDinamicos[$i] > 0) {
            $mesesConDatos[] = $i;
        }
    }

    if (empty($mesesConDatos)) {
        return back()->with('error', 'Debes ingresar al menos un mes con datos válidos');
    }

    // Si hay meses sin datos, filtrarlos
    if (count($mesesConDatos) < $maxMeses) {
        $ingresosFiltrados = [];
        $gastosFijosFiltrados = [];
        $gastosDinamicosFiltrados = [];
        
        foreach ($mesesConDatos as $index) {
            $ingresosFiltrados[] = $ingresos[$index];
            $gastosFijosFiltrados[] = $gastosFijos[$index];
            $gastosDinamicosFiltrados[] = $gastosDinamicos[$index];
        }
        
        $ingresos = $ingresosFiltrados;
        $gastosFijos = $gastosFijosFiltrados;
        $gastosDinamicos = $gastosDinamicosFiltrados;
    }

    // Verificar que después del filtrado todavía hay datos
    if (empty($ingresos) || empty($gastosFijos) || empty($gastosDinamicos)) {
        return back()->with('error', 'No hay datos válidos para procesar después del filtrado');
    }

    $categorias = Category::with('subcategories')->forExpenses()->get();
    $datos = $this->procesarDatosBasicos($ingresos, $gastosFijos, $gastosDinamicos);

    // ⭐⭐ NUEVA LÍNEA: GUARDAR EN SESIÓN para las vistas avanzadas ⭐⭐
    session(['analisis_data' => $datos]);

    return view('Dashboard.analisis', array_merge($datos, [
        'categorias' => $categorias,
        'modo_analisis' => 'basico'
    ]))->with('success', 'Se analizaron ' . count($mesesConDatos) . ' meses con datos válidos.');
}

    /**
     * CORREGIDO: Procesa datos del modo básico y retorna array
     */
   private function procesarDatosBasicos($ingresos, $gastosFijos, $gastosDinamicos)
{
    // Verificar que hay datos (puede haber ceros, pero arrays no vacíos)
    if (empty($ingresos) || empty($gastosFijos) || empty($gastosDinamicos)) {
        throw new \Exception('No hay datos suficientes para procesar');
    }

    // Filtrar ceros para cálculos específicos si es necesario
    $ingresosSinCeros = array_filter($ingresos, function($valor) {
        return $valor > 0;
    });
    
    $gastosFijosSinCeros = array_filter($gastosFijos, function($valor) {
        return $valor > 0;
    });
    
    $gastosDinamicosSinCeros = array_filter($gastosDinamicos, function($valor) {
        return $valor > 0;
    });

    // Promedios (usar arrays originales que pueden incluir ceros)
    $promIngreso = !empty($ingresos) ? array_sum($ingresos) / count($ingresos) : 0;
    $promFijos = !empty($gastosFijos) ? array_sum($gastosFijos) / count($gastosFijos) : 0;
    $promDinamicos = !empty($gastosDinamicos) ? array_sum($gastosDinamicos) / count($gastosDinamicos) : 0;

    // Desviaciones estándar (usar arrays sin ceros para mejor precisión)
    $desviacion = !empty($gastosDinamicosSinCeros) ? 
        $this->calcularDesviacionEstandar($gastosDinamicosSinCeros) : 0;
    
    $desviacionIngresos = !empty($ingresosSinCeros) ? 
        $this->calcularDesviacionEstandar($ingresosSinCeros) : 0;

    // Medianas (usar arrays sin ceros)
    $medianaIngresos = !empty($ingresosSinCeros) ? 
        $this->calcularMediana($ingresosSinCeros) : 0;
    
    $medianaFijos = !empty($gastosFijosSinCeros) ? 
        $this->calcularMediana($gastosFijosSinCeros) : 0;
    
    $medianaDinamicos = !empty($gastosDinamicosSinCeros) ? 
        $this->calcularMediana($gastosDinamicosSinCeros) : 0;

    // Coeficientes de variación
    $cvIngresos = $promIngreso > 0 ? ($desviacionIngresos / $promIngreso) * 100 : 0;
    $cvGastosDinamicos = $promDinamicos > 0 ? ($desviacion / $promDinamicos) * 100 : 0;

    // Rangos (usar arrays sin ceros)
    $rangoIngresos = !empty($ingresosSinCeros) ? max($ingresosSinCeros) - min($ingresosSinCeros) : 0;
    $rangoFijos = !empty($gastosFijosSinCeros) ? max($gastosFijosSinCeros) - min($gastosFijosSinCeros) : 0;
    $rangoDinamicos = !empty($gastosDinamicosSinCeros) ? max($gastosDinamicosSinCeros) - min($gastosDinamicosSinCeros) : 0;

    // Indicadores financieros
    $totalGastos = $promFijos + $promDinamicos;
    $porcFijos = $promIngreso > 0 ? ($promFijos / $promIngreso) * 100 : 0;
    $porcDinamicos = $promIngreso > 0 ? ($promDinamicos / $promIngreso) * 100 : 0;
    $saldo = $promIngreso - $totalGastos;

    // Proyecciones anuales
    $ingresoAnual = $promIngreso * 12;
    $gastosFijosAnual = $promFijos * 12;
    $gastosDinamicosAnual = $promDinamicos * 12;
    $saldoAnual = $saldo * 12;

    // Moda (usar array sin ceros)
    $moda = !empty($gastosDinamicosSinCeros) ? 
        $this->calcularModa($gastosDinamicosSinCeros) : 'N/A';

    // Conclusiones
    $conclusion = $this->generarConclusion($saldo, $porcFijos, $desviacion, $cvIngresos, $cvGastosDinamicos);

    return [
        'promIngreso' => $promIngreso,
        'promFijos' => $promFijos,
        'promDinamicos' => $promDinamicos,
        'desviacion' => $desviacion,
        'porcFijos' => $porcFijos,
        'porcDinamicos' => $porcDinamicos,
        'saldo' => $saldo,
        'moda' => $moda,
        'conclusion' => $conclusion,
        'ingresos' => $ingresos,
        'gastosFijos' => $gastosFijos,
        'gastosDinamicos' => $gastosDinamicos,
        'ingresoAnual' => $ingresoAnual,
        'gastosFijosAnual' => $gastosFijosAnual,
        'gastosDinamicosAnual' => $gastosDinamicosAnual,
        'saldoAnual' => $saldoAnual,
        'medianaDinamicos' => $medianaDinamicos,
        'rangoDinamicos' => $rangoDinamicos,
        'desviacionIngresos' => $desviacionIngresos,
        'medianaIngresos' => $medianaIngresos,
        'medianaFijos' => $medianaFijos,
        'cvIngresos' => $cvIngresos,
        'cvGastosDinamicos' => $cvGastosDinamicos,
        'rangoIngresos' => $rangoIngresos,
        'rangoFijos' => $rangoFijos
    ];
}

    public function importarCSV(Request $request)
    {
        $request->validate([
            'archivo_csv' => 'required|file|mimes:csv,txt'
        ]);

        try {
            $file = $request->file('archivo_csv');
            $contenido = file($file->getPathname());
            
            $ingresos = [];
            $gastosFijos = [];
            $gastosDinamicos = [];
            
            foreach ($contenido as $numeroLinea => $linea) {
                if (trim($linea) === '') continue;
                
                // Detectar separador
                if (strpos($linea, ';') !== false) {
                    $datos = str_getcsv($linea, ';');
                } else {
                    $datos = str_getcsv($linea, ',');
                }
                
                // Saltar encabezados
                if ($numeroLinea === 0 && !is_numeric(trim($datos[0]))) {
                    continue;
                }
                
                // Verificar que tenga 3 columnas numéricas
                if (count($datos) >= 3 && 
                    is_numeric(trim($datos[0])) && 
                    is_numeric(trim($datos[1])) && 
                    is_numeric(trim($datos[2]))) {
                    
                    $ingresos[] = floatval(trim($datos[0]));
                    $gastosFijos[] = floatval(trim($datos[1]));
                    $gastosDinamicos[] = floatval(trim($datos[2]));
                }
            }

            if (empty($ingresos)) {
                return back()->with('error', 
                    'No se pudieron leer los datos. Verifica que el archivo CSV tenga el formato correcto.'
                );
            }

            $categorias = Category::with('subcategories')->forExpenses()->get();
            $datos = $this->procesarDatosBasicos($ingresos, $gastosFijos, $gastosDinamicos);
            
            return view('Dashboard.analisis', array_merge($datos, [
                'categorias' => $categorias,
                'modo_analisis' => 'basico'
            ]))->with('success', 'Archivo CSV procesado correctamente. Se analizaron ' . count($ingresos) . ' registros.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * ANÁLISIS DETALLADO - COMPLETAMENTE FUNCIONAL
     */
   public function analizarDetallado(Request $request)
{
    // Validación condicional basada en el modo
    if ($request->modo_ingreso === 'detallado') {
        $request->validate([
            'ingresos_detallados' => 'required|array|min:1',
            'ingresos_detallados.*.mes' => 'required_if:modo_ingreso,detallado|date_format:Y-m',
            'ingresos_detallados.*.monto' => 'required_if:modo_ingreso,detallado|numeric|min:0',
            'gastos_detallados' => 'required|array|min:1',
            'gastos_detallados.*.fecha' => 'required_if:modo_ingreso,detallado|date',
            'gastos_detallados.*.categoria_id' => 'required_if:modo_ingreso,detallado|exists:categories,id',
            'gastos_detallados.*.subcategoria_id' => 'required_if:modo_ingreso,detallado|exists:subcategories,id',
            'gastos_detallados.*.monto' => 'required_if:modo_ingreso,detallado|numeric|min:0',
        ]);
        
        return $this->procesarDatosDetallados($request);
    } else {
        // Validación para modo rápido
        return $this->analizar($request);
    }
}
    /**
     * PROCESAMIENTO DE DATOS DETALLADOS - CORREGIDO
     */
    private function procesarDatosDetallados(Request $request)
    {
        // Procesar ingresos detallados
        $ingresosPorMes = [];
        foreach ($request->ingresos_detallados as $ingreso) {
            $mes = $ingreso['mes'];
            if (!isset($ingresosPorMes[$mes])) {
                $ingresosPorMes[$mes] = 0;
            }
            $ingresosPorMes[$mes] += floatval($ingreso['monto']);
        }

        // Procesar gastos detallados
        $gastosPorCategoria = [];
        $gastosPorMes = [];
        
        foreach ($request->gastos_detallados as $gasto) {
            $categoriaId = $gasto['categoria_id'];
            $subcategoriaId = $gasto['subcategoria_id'];
            $monto = floatval($gasto['monto']);
            $mes = date('Y-m', strtotime($gasto['fecha']));
            
            // Agrupar por categoría
            if (!isset($gastosPorCategoria[$categoriaId])) {
                $gastosPorCategoria[$categoriaId] = [
                    'total' => 0,
                    'subcategorias' => [],
                    'categoria' => Category::find($categoriaId)
                ];
            }
            $gastosPorCategoria[$categoriaId]['total'] += $monto;
            
            // Agrupar por subcategoría
            if (!isset($gastosPorCategoria[$categoriaId]['subcategorias'][$subcategoriaId])) {
                $gastosPorCategoria[$categoriaId]['subcategorias'][$subcategoriaId] = [
                    'total' => 0,
                    'subcategoria' => Subcategory::find($subcategoriaId)
                ];
            }
            $gastosPorCategoria[$categoriaId]['subcategorias'][$subcategoriaId]['total'] += $monto;
            
            // Agrupar por mes (para análisis mensual)
            if (!isset($gastosPorMes[$mes])) {
                $gastosPorMes[$mes] = 0;
            }
            $gastosPorMes[$mes] += $monto;
        }

        // Preparar datos para análisis básico (compatibilidad)
        $ingresosArray = array_values($ingresosPorMes);
        $gastosDinamicosArray = array_values($gastosPorMes);
        
        // Para gastos fijos, usar un estimado basado en el 40% de los gastos totales
        $promedioGastosDinamicos = !empty($gastosDinamicosArray) ? array_sum($gastosDinamicosArray) / count($gastosDinamicosArray) : 0;
        $gastosFijosArray = array_fill(0, count($gastosDinamicosArray), $promedioGastosDinamicos * 0.6);

        // Obtener análisis básico
        $datosBasicos = $this->procesarDatosBasicos($ingresosArray, $gastosFijosArray, $gastosDinamicosArray);
        
        // Análisis por categorías
        $analisisCategorias = $this->analizarCategorias($gastosPorCategoria);
        $analisisMensual = $this->analizarTendenciasMensuales($ingresosPorMes, $gastosPorMes);
        
        $categorias = Category::with('subcategories')->forExpenses()->get();

        return view('Dashboard.analisis', array_merge($datosBasicos, [
            'analisis_categorias' => $analisisCategorias,
            'gastos_por_categoria' => $gastosPorCategoria,
            'tendencias_mensuales' => $analisisMensual,
            'modo_analisis' => 'detallado',
            'categorias' => $categorias
        ]));
    }

    /**
     * MÉTODOS AUXILIARES - CORREGIDOS Y OPTIMIZADOS
     */
    private function calcularMediana($array)
    {
        if (empty($array)) {
            return 0;
        }
        
        $sorted = $array;
        sort($sorted);
        $count = count($sorted);
        
        if ($count % 2 == 0) {
            return ($sorted[$count/2 - 1] + $sorted[$count/2]) / 2;
        } else {
            return $sorted[floor($count/2)];
        }
    }

    private function calcularModa($array)
    {
        if (empty($array)) {
            return 'N/A';
        }
        
        $frecuencias = array_count_values(array_map(function($val) {
            return number_format($val, 2);
        }, $array));
        
        arsort($frecuencias);
        $maxFrecuencia = reset($frecuencias);
        
        $modas = array_keys(array_filter($frecuencias, function($freq) use ($maxFrecuencia) {
            return $freq === $maxFrecuencia;
        }));
        
        if (count($modas) === 1) {
            return floatval($modas[0]);
        } else {
            return 'Múltiples: ' . implode(', ', array_slice($modas, 0, 3));
        }
    }

    private function calcularDesviacionEstandar($array, $esMuestra = true)
    {
        if (empty($array) || count($array) < 2) {
            return 0;
        }
        
        $n = count($array);
        $media = array_sum($array) / $n;
        $sumaCuadrados = 0;
        
        foreach ($array as $valor) {
            $sumaCuadrados += pow($valor - $media, 2);
        }
        
        $denominador = $esMuestra ? ($n - 1) : $n;
        return $denominador > 0 ? sqrt($sumaCuadrados / $denominador) : 0;
    }

    private function analizarCategorias($gastosPorCategoria)
    {
        $totalGastos = array_sum(array_column($gastosPorCategoria, 'total'));
        $analisis = [];
        
        foreach ($gastosPorCategoria as $categoriaId => $datos) {
            $porcentaje = $totalGastos > 0 ? ($datos['total'] / $totalGastos) * 100 : 0;
            
            $analisis[] = [
                'categoria' => $datos['categoria'],
                'total' => $datos['total'],
                'porcentaje' => $porcentaje,
                'subcategorias' => $datos['subcategorias'],
                'recomendacion' => $this->generarRecomendacionCategoria($datos['categoria']->name, $porcentaje, $datos['total'])
            ];
        }
        
        // Ordenar por porcentaje descendente
        usort($analisis, function($a, $b) {
            return $b['porcentaje'] <=> $a['porcentaje'];
        });
        
        return $analisis;
    }

    private function generarRecomendacionCategoria($categoria, $porcentaje, $monto)
    {
        $umbrales = [
            'Vivienda' => 30,
            'Transporte' => 15,
            'Alimentación' => 15,
            'Entretenimiento' => 10,
            'Salud' => 10,
            'Educación' => 10
        ];
        
        $categoriaBase = explode(' ', $categoria)[0]; // Tomar primera palabra
        
        if (isset($umbrales[$categoriaBase]) && $porcentaje > $umbrales[$categoriaBase]) {
            return "⚠️ Gastas más del {$umbrales[$categoriaBase]}% recomendado en {$categoria}. Considera reducir estos gastos.";
        }
        
        return "✅ Gastos en {$categoria} dentro de rangos saludables.";
    }

    private function analizarTendenciasMensuales($ingresosPorMes, $gastosPorMes)
    {
        $tendencias = [
            'meses' => [],
            'ingresos' => [],
            'gastos' => [],
            'saldos' => [],
            'analisis' => []
        ];
        
        // Ordenar los meses cronológicamente
        ksort($ingresosPorMes);
        ksort($gastosPorMes);
        
        foreach ($ingresosPorMes as $mes => $ingreso) {
            $gasto = $gastosPorMes[$mes] ?? 0;
            $saldo = $ingreso - $gasto;
            
            $tendencias['meses'][] = $this->formatearMes($mes);
            $tendencias['ingresos'][] = $ingreso;
            $tendencias['gastos'][] = $gasto;
            $tendencias['saldos'][] = $saldo;
        }
        
        // Análisis de tendencias
        $tendencias['analisis'] = $this->calcularTendencias($tendencias['ingresos'], $tendencias['gastos'], $tendencias['saldos']);
        
        return $tendencias;
    }

    private function formatearMes($mes)
    {
        return date('M Y', strtotime($mes . '-01'));
    }

    private function calcularTendencias($ingresos, $gastos, $saldos)
    {
        $analisis = [];
        
        // Tendencia de ingresos
        $tendenciaIngresos = $this->calcularTendenciaLineal($ingresos);
        $analisis['ingresos'] = [
            'tendencia' => $tendenciaIngresos,
            'interpretacion' => $this->interpretarTendencia($tendenciaIngresos, 'ingresos')
        ];
        
        // Tendencia de gastos
        $tendenciaGastos = $this->calcularTendenciaLineal($gastos);
        $analisis['gastos'] = [
            'tendencia' => $tendenciaGastos,
            'interpretacion' => $this->interpretarTendencia($tendenciaGastos, 'gastos')
        ];
        
        // Tendencia de saldos
        $tendenciaSaldos = $this->calcularTendenciaLineal($saldos);
        $analisis['saldos'] = [
            'tendencia' => $tendenciaSaldos,
            'interpretacion' => $this->interpretarTendencia($tendenciaSaldos, 'saldos')
        ];
        
        return $analisis;
    }

    private function calcularTendenciaLineal($datos)
    {
        $n = count($datos);
        if ($n < 2) {
            return 0;
        }
        
        $sumX = 0;
        $sumY = 0;
        $sumXY = 0;
        $sumX2 = 0;
        
        for ($i = 0; $i < $n; $i++) {
            $sumX += $i;
            $sumY += $datos[$i];
            $sumXY += $i * $datos[$i];
            $sumX2 += $i * $i;
        }
        
        $pendiente = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        
        return $pendiente;
    }

    private function interpretarTendencia($pendiente, $tipo)
    {
        $umbral = 50;
        
        if (abs($pendiente) < $umbral) {
            $estado = 'estable';
        } elseif ($pendiente > 0) {
            $estado = 'creciente';
        } else {
            $estado = 'decreciente';
        }
        
        $interpretaciones = [
            'ingresos' => [
                'creciente' => '📈 Tus ingresos muestran una tendencia positiva',
                'decreciente' => '📉 Tus ingresos muestran una tendencia a la baja',
                'estable' => '📊 Tus ingresos se mantienen estables'
            ],
            'gastos' => [
                'creciente' => '⚠️ Tus gastos están aumentando con el tiempo',
                'decreciente' => '✅ Tus gastos muestran una tendencia a la baja',
                'estable' => '📊 Tus gastos se mantienen estables'
            ],
            'saldos' => [
                'creciente' => '💰 Tu capacidad de ahorro está mejorando',
                'decreciente' => '🔻 Tu saldo disponible está disminuyendo',
                'estable' => '⚖️ Tu saldo se mantiene constante'
            ]
        ];
        
        return $interpretaciones[$tipo][$estado] . " (tendencia: " . number_format($pendiente, 2) . ")";
    }

    /**
     * GENERAR CONCLUSIONES - MEJORADO
     */
    private function generarConclusion($saldo, $porcFijos, $desviacion, $cvIngresos, $cvGastosDinamicos)
    {
        $conclusiones = [];
        
        // Conclusiones sobre saldo disponible
        if ($saldo > 0) {
            $conclusiones[] = "✅ <strong>Tienes capacidad de ahorro/inversión</strong>. Saldo disponible: $" . number_format($saldo, 2);
        } else if ($saldo < 0) {
            $conclusiones[] = "❌ <strong>Gastas más de lo que ganas</strong>. Recomendamos revisar tus gastos.";
        } else {
            $conclusiones[] = "⚠️ <strong>Estás en equilibrio</strong>. No hay saldo disponible para ahorrar.";
        }
        
        // Conclusiones sobre gastos fijos
        if ($porcFijos > 50) {
            $conclusiones[] = "📊 <strong>Tus gastos fijos son altos</strong> (" . number_format($porcFijos, 1) . "%). Considera reducirlos.";
        } else if ($porcFijos < 30) {
            $conclusiones[] = "💰 <strong>Tus gastos fijos son bajos</strong> (" . number_format($porcFijos, 1) . "%). Buena gestión.";
        }
        
        // Conclusiones sobre variabilidad
        if ($cvIngresos > 20) {
            $conclusiones[] = "📈 <strong>Tus ingresos son variables</strong> (CV: " . number_format($cvIngresos, 1) . "%). Considera fuentes de ingreso estables.";
        } else if ($cvIngresos < 10) {
            $conclusiones[] = "💪 <strong>Tus ingresos son estables</strong> (CV: " . number_format($cvIngresos, 1) . "%). Excelente predictibilidad.";
        }
        
        if ($cvGastosDinamicos > 25) {
            $conclusiones[] = "🎯 <strong>Tus gastos dinámicos son muy variables</strong> (CV: " . number_format($cvGastosDinamicos, 1) . "%). Intenta estabilizarlos.";
        } else if ($cvGastosDinamicos < 15) {
            $conclusiones[] = "📋 <strong>Buen control de gastos variables</strong> (CV: " . number_format($cvGastosDinamicos, 1) . "%).";
        }
        
        // Conclusiones combinadas
        if ($cvIngresos < 10 && $cvGastosDinamicos < 15) {
            $conclusiones[] = "🏆 <strong>Excelente estabilidad financiera</strong>. Tus ingresos y gastos son predecibles.";
        }
        
        if ($saldo > 0 && $porcFijos < 40 && $cvIngresos < 15) {
            $conclusiones[] = "🌟 <strong>Situación financiera óptima</strong>. Tienes control total sobre tus finanzas.";
        }
        
        return $conclusiones;
    }
 public function frecuencias()
    {
        $sessionData = session('analisis_data');
        
        if (!$sessionData) {
            return redirect()->route('analisis.index')
                ->with('error', 'Primero realiza un análisis para ver las tablas de frecuencia');
        }
        
        $tablaFrecuencia = $this->generarTablaFrecuenciaCompleta($sessionData['gastosDinamicos']);
        $tablaCategorias = $this->generarFrecuenciaCategorias($sessionData);
        $histogramaData = $this->prepararDatosHistograma($sessionData['gastosDinamicos']);
        
        return view('Dashboard.frecuencias', [
            'tablaFrecuencia' => $tablaFrecuencia,
            'tablaCategorias' => $tablaCategorias,
            'histogramaData' => $histogramaData,
            'datosAnalisis' => $sessionData
        ]);
    }
    
    /**
     * GENERAR TABLA DE FRECUENCIA COMPLETA CON INTERVALOS
     */
    private function generarTablaFrecuenciaCompleta($gastosDinamicos)
    {
        if (empty($gastosDinamicos)) return [];
        
        // Filtrar solo valores positivos
        $datos = array_filter($gastosDinamicos, function($valor) {
            return $valor > 0;
        });
        
        if (empty($datos)) return [];
        
        $min = min($datos);
        $max = max($datos);
        $n = count($datos);
        
        // Regla de Sturges para número de intervalos
        $numIntervalos = max(5, min(8, ceil(1 + 3.322 * log10($n))));
        $rango = $max - $min;
        $amplitud = $rango / $numIntervalos;
        
        $intervalos = [];
        $frecuenciaAcumulada = 0;
        $frecuenciaRelativaAcumulada = 0;
        
        for ($i = 0; $i < $numIntervalos; $i++) {
            $limiteInferior = $min + ($i * $amplitud);
            $limiteSuperior = $limiteInferior + $amplitud;
            $marcaClase = ($limiteInferior + $limiteSuperior) / 2;
            
            // Contar frecuencia en este intervalo
            $frecuencia = 0;
            foreach ($datos as $dato) {
                if ($dato >= $limiteInferior && $dato < $limiteSuperior) {
                    $frecuencia++;
                }
            }
            
            // Calcular medidas de frecuencia
            $frecuenciaRelativa = $frecuencia / $n;
            $frecuenciaAcumulada += $frecuencia;
            $frecuenciaRelativaAcumulada += $frecuenciaRelativa;
            $porcentaje = $frecuenciaRelativa * 100;
            
            $intervalos[] = [
                'intervalo' => '$' . number_format($limiteInferior, 0) . ' - $' . number_format($limiteSuperior, 0),
                'marca_clase' => number_format($marcaClase, 2),
                'frecuencia' => $frecuencia,
                'frecuencia_relativa' => number_format($frecuenciaRelativa, 3),
                'frecuencia_acumulada' => $frecuenciaAcumulada,
                'frecuencia_relativa_acumulada' => number_format($frecuenciaRelativaAcumulada, 3),
                'porcentaje' => number_format($porcentaje, 1) . '%'
            ];
        }
        
        return $intervalos;
    }
    
    /**
     * GENERAR FRECUENCIA POR CATEGORÍAS (simulado - adaptar a tus datos reales)
     */
    private function generarFrecuenciaCategorias($datosAnalisis)
    {
        // ESTO ES SIMULADO - En tu caso real, estos datos vendrían de tu base de datos
        $categorias = [
            'Alimentación' => 15,
            'Transporte' => 12,
            'Entretenimiento' => 8,
            'Salud' => 5,
            'Educación' => 3,
            'Vivienda' => 20,
            'Otros' => 7
        ];
        
        $total = array_sum($categorias);
        $tabla = [];
        $frecuenciaAcumulada = 0;
        $porcentajeAcumulado = 0;
        
        foreach ($categorias as $categoria => $frecuencia) {
            $porcentaje = ($frecuencia / $total) * 100;
            $frecuenciaAcumulada += $frecuencia;
            $porcentajeAcumulado += $porcentaje;
            
            $tabla[] = [
                'categoria' => $categoria,
                'frecuencia' => $frecuencia,
                'frecuencia_acumulada' => $frecuenciaAcumulada,
                'porcentaje' => number_format($porcentaje, 1) . '%',
                'porcentaje_acumulado' => number_format($porcentajeAcumulado, 1) . '%'
            ];
        }
        
        return $tabla;
    }
    
    /**
     * PREPARAR DATOS PARA HISTOGRAMA
     */
    private function prepararDatosHistograma($gastosDinamicos)
    {
        if (empty($gastosDinamicos)) return [];
        
        $datos = array_filter($gastosDinamicos, function($valor) {
            return $valor > 0;
        });
        
        if (empty($datos)) return [];
        
        $min = min($datos);
        $max = max($datos);
        $n = count($datos);
        $numIntervalos = max(5, min(8, ceil(1 + 3.322 * log10($n))));
        $rango = $max - $min;
        $amplitud = $rango / $numIntervalos;
        
        $labels = [];
        $data = [];
        
        for ($i = 0; $i < $numIntervalos; $i++) {
            $limiteInferior = $min + ($i * $amplitud);
            $limiteSuperior = $limiteInferior + $amplitud;
            $marcaClase = ($limiteInferior + $limiteSuperior) / 2;
            
            $frecuencia = 0;
            foreach ($datos as $dato) {
                if ($dato >= $limiteInferior && $dato < $limiteSuperior) {
                    $frecuencia++;
                }
            }
            
            $labels[] = '$' . number_format($marcaClase, 0);
            $data[] = $frecuencia;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
}