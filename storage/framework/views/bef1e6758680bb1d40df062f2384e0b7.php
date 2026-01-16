<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis Financiero Familiar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-graph-up"></i> FinanzAnalyzer
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#analisis-section">
                            <i class="bi bi-speedometer2"></i> Análisis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#formulario-section">
                            <i class="bi bi-cloud-upload"></i> Ingresar Datos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#csv-section">
                            <i class="bi bi-file-earmark-spreadsheet"></i> Importar CSV
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <!-- LOADING SPINNER -->
        <div id="loading-spinner" class="text-center" style="display: none;">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Procesando...</span>
            </div>
            <p class="mt-3 fs-5 text-primary">Analizando sus datos financieros...</p>
            <p class="text-muted">Esto puede tomar unos segundos</p>
        </div>

        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="display-5 text-primary">
                <i class="bi bi-graph-up"></i> Análisis Automático de Finanzas Familiares
            </h1>
            <p class="lead">Toma el control de tus finanzas con nuestro análisis inteligente</p>
        </div>

        <!-- Sección de Cómo Calcular -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h4 class="mb-0"><i class="bi bi-question-circle"></i> ¿Cómo calcular mis gastos correctamente?</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card h-100 border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">💰 Ingresos Totales</h6>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><strong>Suma todos tus ingresos:</strong></p>
                                <ul class="small">
                                    <li>Salarios fijos</li>
                                    <li>Ingresos extra</li>
                                    <li>Pensiones</li>
                                    <li>Alquileres</li>
                                    <li>Bonificaciones</li>
                                    <li>Negocios</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">🏠 Gastos Fijos (Obligatorios)</h6>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><strong>Gastos que no cambian:</strong></p>
                                <ul class="small">
                                    <li><strong>Arriendo/Hipoteca:</strong> Pago de vivienda</li>
                                    <li><strong>Servicios:</strong> Luz, agua, gas, internet</li>
                                    <li><strong>Transporte:</strong> Gasolina, pasajes</li>
                                    <li><strong>Seguros:</strong> Salud, auto, vida</li>
                                    <li><strong>Educación:</strong> Colegio, universidad</li>
                                    <li><strong>Créditos:</strong> Tarjetas, préstamos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-info">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">🎯 Gastos Dinámicos (Variables)</h6>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><strong>Gastos que cambian cada mes:</strong></p>
                                <ul class="small">
                                    <li><strong>Alimentación:</strong> Supermercado, mercado</li>
                                    <li><strong>Entretenimiento:</strong> Cine, restaurantes</li>
                                    <li><strong>Ropa:</strong> Prendas, calzado</li>
                                    <li><strong>Salud:</strong> Medicinas, consultas</li>
                                    <li><strong>Hogar:</strong> Mantenimiento, decoración</li>
                                    <li><strong>Imprevistos:</strong> Reparaciones, emergencias</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resultados del Análisis (solo se muestra cuando hay datos) -->
        <?php if($promIngreso > 0): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-speedometer2"></i> Resultados del Análisis</h4>
            </div>
            <div class="card-body">
                <!-- Cards resumen -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header">Ingreso Promedio</div>
                            <div class="card-body">
                                <h5 class="card-title">$<?php echo e(number_format($promIngreso, 2)); ?></h5>
                                <p class="card-text">Promedio mensual de ingresos familiares</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">Promedio Gastos Fijos</div>
                            <div class="card-body">
                                <h5 class="card-title">$<?php echo e(number_format($promFijos, 2)); ?></h5>
                                <p class="card-text">Promedio de gastos obligatorios mensuales</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">Saldo Disponible</div>
                            <div class="card-body">
                                <h5 class="card-title">$<?php echo e(number_format($saldo, 2)); ?></h5>
                                <p class="card-text">Dinero para ahorrar o invertir cada mes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medidas de tendencia central -->
                <h5 class="mt-4">📌 Medidas de Tendencia Central</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Concepto</th>
                            <th>Valor</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Media Ingresos
                                <button type="button"
                                        class="btn btn-link p-0 ms-2 text-muted"
                                        style="float: right;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#formulaMedia">
                                    <i class="bi bi-info-circle"></i>
                                </button>
                            </td>
                            <td>$<?php echo e(number_format($promIngreso, 2)); ?></td>
                            <td>Ingreso mensual promedio</td>
                        </tr>
                        <tr>
                            <td>Media Gastos Fijos</td>
                            <td>$<?php echo e(number_format($promFijos, 2)); ?></td>
                            <td>Promedio de gastos obligatorios</td>
                        </tr>
                        <tr>
                            <td>Media Gastos Dinámicos</td>
                            <td>$<?php echo e(number_format($promDinamicos, 2)); ?></td>
                            <td>Promedio de gastos variables</td>
                        </tr>
                        <tr>
                            <td>Mediana Ingresos</td>
                            <td>$<?php echo e(number_format($medianaIngresos, 2)); ?></td>
                            <td>Valor central de ingresos mensuales</td>
                        </tr>
                        <tr>
                            <td>Mediana Gastos Fijos</td>
                            <td>$<?php echo e(number_format($medianaFijos, 2)); ?></td>
                            <td>Valor central de gastos fijos</td>
                        </tr>
                        <tr>
                            <td>Mediana Gastos Dinámicos
                                <button type="button" class="btn btn-link p-0 ms-2 text-muted" style="float:right;" data-bs-toggle="modal" data-bs-target="#formulaMediana">
                                    <i class="bi bi-info-circle"></i>
                                </button>
                            </td>
                            <td><?php echo e(number_format($medianaDinamicos, 2)); ?></td>
                            <td>Valor central de los datos ordenados</td>
                        </tr>
                        <tr>
                            <td>Moda Gastos Dinámicos
                                <button type="button" class="btn btn-link p-0 ms-2 text-muted" style="float:right;" data-bs-toggle="modal" data-bs-target="#formulaModa">
                                    <i class="bi bi-info-circle"></i>
                                </button>
                            </td>
                            <td><?php echo e($moda ?? 'N/A'); ?></td>
                            <td>Valor que más se repite en gastos variables</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Medidas de dispersión -->
                <h5 class="mt-4">📌 Medidas de Dispersión</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Concepto</th>
                            <th>Valor</th>
                            <th>Interpretación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Desviación Estándar Gastos Dinámicos
                                <button type="button" class="btn btn-link p-0 ms-2 text-muted" style="float:right;" data-bs-toggle="modal" data-bs-target="#formulaDesviacion">
                                    <i class="bi bi-info-circle"></i>
                                </button>
                            </td>
                            <td><?php echo e(number_format($desviacion, 2)); ?></td>
                            <td>Variabilidad de tus gastos dinámicos</td>
                        </tr>
                        <tr>
                            <td>Desviación Estándar Ingresos</td>
                            <td><?php echo e(number_format($desviacionIngresos, 2)); ?></td>
                            <td>Variabilidad de tus ingresos mensuales</td>
                        </tr>
                        <tr>
                            <td>Coeficiente Variación Ingresos</td>
                            <td><?php echo e(number_format($cvIngresos, 2)); ?>%</td>
                            <td>Variabilidad relativa de ingresos</td>
                        </tr>
                        <tr>
                            <td>Coeficiente Variación Gastos Dinámicos</td>
                            <td><?php echo e(number_format($cvGastosDinamicos, 2)); ?>%</td>
                            <td>Variabilidad relativa de gastos variables</td>
                        </tr>
                        <tr>
                            <td>Rango Ingresos</td>
                            <td><?php echo e(number_format($rangoIngresos, 2)); ?></td>
                            <td>Diferencia entre mayor y menor ingreso</td>
                        </tr>
                        <tr>
                            <td>Rango Gastos Fijos</td>
                            <td><?php echo e(number_format($rangoFijos, 2)); ?></td>
                            <td>Diferencia entre mayor y menor gasto fijo</td>
                        </tr>
                        <tr>
                            <td>Rango Gastos Dinámicos</td>
                            <td><?php echo e(number_format($rangoDinamicos, 2)); ?></td>
                            <td>Diferencia entre mayor y menor gasto variable</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Indicadores financieros -->
                <h5 class="mt-4">📌 Indicadores Financieros</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Indicador</th>
                            <th>Valor</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>% Gastos Fijos</td>
                            <td><?php echo e(number_format($porcFijos, 2)); ?>%</td>
                            <td>Porcentaje de ingresos para gastos fijos</td>
                        </tr>
                        <tr>
                            <td>% Gastos Dinámicos</td>
                            <td><?php echo e(number_format($porcDinamicos, 2)); ?>%</td>
                            <td>Porcentaje para gastos variables</td>
                        </tr>
                        <tr>
                            <td>Saldo Disponible</td>
                            <td>$<?php echo e(number_format($saldo, 2)); ?></td>
                            <td>Dinero restante después de gastos</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Gráficos -->
                <h5 class="mt-4">📊 Visualización de Datos</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Distribución de Gastos</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="gastosChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Ingresos vs Gastos</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="ingresosVsGastos"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Conclusiones automáticas -->
                <?php if(count($conclusion) > 0): ?>
                <div class="mt-4">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">💡 Conclusiones Automáticas</h5>
                        </div>
                        <div class="card-body">
                            <?php $__currentLoopData = $conclusion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mensaje): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p class="card-text mb-2"><?php echo $mensaje; ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Proyección Anual -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#proyeccionAnual" aria-expanded="false" aria-controls="proyeccionAnual">
                                📆 Adicionalmente puedes ver tu proyección Anual, dando clic aqui!
                            </button>
                        </h5>
                    </div>
                    <div id="proyeccionAnual" class="collapse">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Concepto</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Ingresos Anuales</td>
                                        <td>$<?php echo e(number_format($ingresoAnual, 2)); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Gastos Fijos Anuales</td>
                                        <td>$<?php echo e(number_format($gastosFijosAnual, 2)); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Gastos Dinámicos Anuales</td>
                                        <td>$<?php echo e(number_format($gastosDinamicosAnual, 2)); ?></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Saldo Anual</strong></td>
                                        <td><strong>$<?php echo e(number_format($saldoAnual, 2)); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals para fórmulas -->
        <!-- Modal Media -->
        <div class="modal fade" id="formulaMedia" tabindex="-1">
            <div class="modal-dialog"><div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Fórmula de la Media</h5></div>
                <div class="modal-body">
                    <p><strong>Media (promedio):</strong></p>
                    <p class="text-center">μ = (Σx) / n</p>
                    <p>Σx = suma de todos los valores<br>n = número de datos</p>
                </div>
            </div></div>
        </div>

        <!-- Modal Mediana -->
        <div class="modal fade" id="formulaMediana" tabindex="-1">
            <div class="modal-dialog"><div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Fórmula de la Mediana</h5></div>
                <div class="modal-body">
                    <p><strong>Mediana:</strong></p>
                    <p class="text-center">
                        Si n es impar → valor central<br>
                        Si n es par → (x<sub>n/2</sub> + x<sub>n/2+1</sub>) / 2
                    </p>
                </div>
            </div></div>
        </div>

        <!-- Modal Moda -->
        <div class="modal fade" id="formulaModa" tabindex="-1">
            <div class="modal-dialog"><div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Fórmula de la Moda</h5></div>
                <div class="modal-body">
                    <p><strong>Moda:</strong></p>
                    <p class="text-center">Valor que más veces se repite</p>
                </div>
            </div></div>
        </div>

        <!-- Modal Desviación estándar -->
        <div class="modal fade" id="formulaDesviacion" tabindex="-1">
            <div class="modal-dialog"><div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Fórmula de la Desviación Estándar</h5></div>
                <div class="modal-body">
                    <p><strong>Desviación Estándar:</strong></p>
                    <p class="text-center">
                        σ = √( Σ (xᵢ - μ)² / n )
                    </p>
                    <p>Indica qué tan dispersos están los datos respecto a la media.</p>
                </div>
            </div></div>
        </div>

        <?php else: ?>
        <!-- Mensaje de bienvenida cuando no hay datos -->
        <div class="alert alert-info text-center">
            <h4><i class="bi bi-graph-up"></i> ¡Bienvenido a tu Análisis Financiero!</h4>
            <p class="mb-0">Comienza ingresando tus datos financieros en el formulario below para obtener un análisis completo de tus finanzas.</p>
        </div>
        <?php endif; ?>

        <!-- Mostrar errores si hay -->
        <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>

        <!-- Formulario ÚNICO que maneja ambos modos -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-cloud-upload"></i> Ingresar Datos Financieros</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('analisis.calcular.detallado')); ?>" method="POST" id="mainForm">
                    <?php echo csrf_field(); ?>
                    
                    <div class="alert alert-info">
                        <h5><i class="bi bi-lightbulb"></i> Nuevo: Categorización Inteligente</h5>
                        <p class="mb-1">Ahora puedes categorizar tus gastos para obtener análisis más detallados.</p>
                    </div>

                    <!-- SELECTOR DE MODO -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="modo_ingreso" id="modo_rapido" value="rapido" checked>
                                <label class="form-check-label" for="modo_rapido">
                                    <i class="bi bi-lightning"></i> Modo Rápido
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="modo_ingreso" id="modo_detallado" value="detallado">
                                <label class="form-check-label" for="modo_detallado">
                                    <i class="bi bi-bar-chart"></i> Modo Detallado
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- MODO RÁPIDO -->
                    <div id="modo-rapido-container">
                        <div class="alert alert-info">
                            <h5><i class="bi bi-info-circle"></i> ¿Cómo funciona?</h5>
                            <p class="mb-1">Ingresa tus datos financieros de los últimos meses. Cuantos más meses ingreses, más preciso será el análisis.</p>
                        </div>

                        <div class="row">
                            <!-- Ingresos -->
                            <div class="col-md-4">
                                <div class="card h-100 border-success">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">💰 Ingresos Mensuales</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="small text-muted">
                                            <i class="bi bi-lightbulb"></i>
                                            <strong>Ejemplos:</strong><br>
                                            • Salario: $2,500<br>
                                            • Ingresos extra: $300<br>
                                            • <strong>Total mensual: $2,800</strong>
                                        </p>
                                        <div id="ingresos-container">
    <div class="input-group mb-2">
        <span class="input-group-text">
            <small class="text-muted month-indicator">M1</small>
        </span>
        <input type="number" name="ingresos[]" class="form-control" placeholder="Ej: 2800" step="0.01" min="0">
    </div>
</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gastos Fijos -->
                            <div class="col-md-4">
                                <div class="card h-100 border-warning">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0">🏠 Gastos Fijos</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="small text-muted">
                                            <i class="bi bi-lightbulb"></i>
                                            <strong>Gastos obligatorios:</strong><br>
                                            • Arriendo: $500<br>
                                            • Servicios: $200<br>
                                            • Transporte: $150<br>
                                            • <strong>Total fijos: $850</strong>
                                        </p>
                                       <!-- Gastos Fijos -->
<div id="fijos-container">
    <div class="input-group mb-2">
        <span class="input-group-text">
            <small class="text-muted month-indicator">M1</small>
        </span>
        <input type="number" name="gastos_fijos[]" class="form-control" placeholder="Ej: 850" step="0.01" min="0">
    </div>
</div>

                                    </div>
                                </div>
                            </div>

                            <!-- Gastos Dinámicos -->
                            <div class="col-md-4">
                                <div class="card h-100 border-info">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">🎯 Gastos Dinámicos</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="small text-muted">
                                            <i class="bi bi-lightbulb"></i>
                                            <strong>Gastos variables:</strong><br>
                                            • Mercado: $400<br>
                                            • Entretenimiento: $100<br>
                                            • Ropa: $50<br>
                                            • <strong>Total variables: $550</strong>
                                        </p>
                                        
                                        <div id="dinamicos-container">
    <div class="input-group mb-2">
        <span class="input-group-text">
            <small class="text-muted month-indicator">M1</small>
        </span>
        <input type="number" name="gastos_dinamicos[]" class="form-control" placeholder="Ej: 550" step="0.01" min="0">
    </div>
</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-3" onclick="addMonth()">
                            <i class="bi bi-plus-circle"></i> Agregar Otro Mes
                        </button>
                       <div id="botones-eliminar-container" class="mt-3">
    <div class="text-center">
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMes(0)">
            <i class="bi bi-trash"></i> Eliminar Mes 1
        </button>
    </div>
</div>
                    </div>
<!-- ✅ AGREGAMOS UNA SOLA SECCIÓN DE BOTONES X POR MES -->

                    <!-- MODO DETALLADO -->
                    <div id="modo-detallado-container" style="display: none;">
                        <!-- INGRESOS -->
                        <div class="card border-success mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">💰 Ingresos Mensuales</h5>
                            </div>
                            <div class="card-body">
                                <div id="ingresos-detallados-container">
                                    <div class="ingreso-mes mb-3 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label">Mes</label>
                                                <input type="month" name="ingresos_detallados[0][mes]" class="form-control">
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">Descripción</label>
                                                <input type="text" name="ingresos_detallados[0][descripcion]" 
                                                       class="form-control" placeholder="Ej: Salario principal">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Monto</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" name="ingresos_detallados[0][monto]" 
                                                           class="form-control" step="0.01" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="addIngresoDetallado()">
                                    <i class="bi bi-plus-circle"></i> Agregar Otro Ingreso
                                </button>
                            </div>
                        </div>

                        <!-- GASTOS DETALLADOS -->
                        <div class="card border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">🎯 Gastos Detallados por Categoría</h5>
                            </div>
                            <div class="card-body">
                                <div id="gastos-detallados-container">
                                    <div class="gasto-item mb-3 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Fecha</label>
                                                <input type="date" name="gastos_detallados[0][fecha]" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Categoría</label>
                                                <select name="gastos_detallados[0][categoria_id]" class="form-select categoria-select" 
                                                        onchange="actualizarSubcategorias(this)">
                                                    <option value="">Seleccionar...</option>
                                                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($categoria->id); ?>" data-color="<?php echo e($categoria->color); ?>">
                                                            <?php echo e($categoria->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Subcategoría</label>
                                                <select name="gastos_detallados[0][subcategoria_id]" class="form-select subcategoria-select">
                                                    <option value="">Primero selecciona categoría</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Monto</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" name="gastos_detallados[0][monto]" 
                                                           class="form-control" step="0.01" min="0">
                                                </div>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeGastoItem(this)">
                                                    ×
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label class="form-label">Descripción (opcional)</label>
                                                <input type="text" name="gastos_detallados[0][descripcion]" 
                                                       class="form-control" placeholder="Ej: Gasolina para el carro">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-warning" onclick="addGastoDetallado()">
                                    <i class="bi bi-plus-circle"></i> Agregar Otro Gasto
                                </button>
                                
                                <!-- BOTÓN DETECCIÓN AUTOMÁTICA -->
                                <button type="button" class="btn btn-sm btn-outline-info ms-2" onclick="sugerirCategorias()">
                                    <i class="bi bi-magic"></i> Sugerir Categorías
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-calculator"></i> Calcular Análisis
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Importar CSV -->
        <div class="border-top pt-4">
            <div class="alert alert-secondary">
                <h5><i class="bi bi-file-earmark-spreadsheet"></i> ¿Prefieres usar Excel/CSV?</h5>
                <p class="mb-2">Descarga nuestra plantilla o usa tu propio archivo CSV con el siguiente formato:</p>
            </div>
           
            <div class="row">
                <div class="col-md-6">
                    <form action="<?php echo e(route('analisis.importar.csv')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="input-group">
                            <input type="file" name="archivo_csv" class="form-control" accept=".csv,.txt" required>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Importar CSV
                            </button>
                        </div>
                        <small class="form-text text-muted">
                            Formato: Tres columnas (ingresos, gastos_fijos, gastos_dinamicos)
                        </small>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6>📋 Formato del CSV:</h6>
                            <code class="small d-block p-2 bg-light rounded">
                                ingresos,gastos_fijos,gastos_dinamicos<br>
                                2800,850,550<br>
                                3000,900,600<br>
                                2750,800,500
                            </code>
                            <button type="button" class="btn btn-outline-success btn-sm mt-2" onclick="descargarPlantilla()">
                                <i class="bi bi-download"></i> Descargar Plantilla CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(isset($modo_analisis) && $modo_analisis === 'detallado'): ?>
        <!-- NUEVA SECCIÓN PARA ANÁLISIS DETALLADO -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="bi bi-bar-chart"></i> Análisis por Categorías</h4>
            </div>
            <div class="card-body">
                <?php if(isset($analisis_categorias) && count($analisis_categorias) > 0): ?>
                <div class="row">
                    <div class="col-md-6">
                        <h5>📊 Distribución por Categoría</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Categoría</th>
                                    <th>Total</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $analisis_categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $analisis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($analisis['categoria']->name); ?></td>
                                    <td>$<?php echo e(number_format($analisis['total'], 2)); ?></td>
                                    <td><?php echo e(number_format($analisis['porcentaje'], 1)); ?>%</td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>📈 Tendencias Mensuales</h5>
                        <?php if(isset($tendencias_mensuales)): ?>
                        <div class="mb-3">
                            <strong>Ingresos:</strong> <?php echo e($tendencias_mensuales['analisis']['ingresos']['interpretacion'] ?? 'No disponible'); ?>

                        </div>
                        <div class="mb-3">
                            <strong>Gastos:</strong> <?php echo e($tendencias_mensuales['analisis']['gastos']['interpretacion'] ?? 'No disponible'); ?>

                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php else: ?>
                <p class="text-muted">No hay datos de categorías para mostrar.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
  

    <!-- Chart.js -->
    <?php if($promIngreso > 0): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de pastel: Gastos fijos vs dinámicos
        var ctx1 = document.getElementById('gastosChart').getContext('2d');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['Gastos Fijos', 'Gastos Dinámicos'],
                datasets: [{
                    data: [<?php echo e($promFijos); ?>, <?php echo e($promDinamicos); ?>],
                    backgroundColor: ['#007bff', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Gráfico de barras: Ingresos vs Gastos
        var ctx2 = document.getElementById('ingresosVsGastos').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Ingresos', 'Gastos Fijos', 'Gastos Dinámicos'],
                datasets: [{
                    label: 'Monto ($)',
                    data: [<?php echo e($promIngreso); ?>, <?php echo e($promFijos); ?>, <?php echo e($promDinamicos); ?>],
                    backgroundColor: ['#28a745', '#007bff', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <?php endif; ?>

    <!-- JavaScript para funcionalidades -->
    <!-- JavaScript para funcionalidades -->
<script>

   const nameMap = {
    'ingresos-container': { name: 'ingresos', placeholder: '2800' },
    'fijos-container': { name: 'gastos_fijos', placeholder: '850' },
    'dinamicos-container': { name: 'gastos_dinamicos', placeholder: '550' }
};

function addField(containerId) {
    const config = nameMap[containerId];
    if (!config) return;

    const container = document.getElementById(containerId);
    const currentCount = container.querySelectorAll('.input-group').length;
    const newField = document.createElement('div');
    newField.className = 'input-group mb-2';
    newField.innerHTML = `
        <span class="input-group-text">
            <small class="text-muted month-indicator">M${currentCount + 1}</small>
        </span>
        <input type="number" name="${config.name}[]" class="form-control" placeholder="Ej: ${config.placeholder}" step="0.01" min="0">
    `;
    container.appendChild(newField);
}
    function removeField(button, containerId) {
    const inputGroup = button.closest('.input-group');
    const container = document.getElementById(containerId);
    const allInputs = container.querySelectorAll('.input-group');
    
    // Encontrar el índice de este campo
    const inputsArray = Array.from(allInputs);
    const indexToRemove = inputsArray.indexOf(inputGroup);
    
    if (allInputs.length > 1) {
        // SOLUCIÓN: Solo eliminar si es el ÚLTIMO campo de TODAS las columnas
        const lastIndex = allInputs.length - 1;
        
        if (indexToRemove === lastIndex) {
            // Es el último campo - eliminar de las 3 columnas
            const containers = ['ingresos-container', 'fijos-container', 'dinamicos-container'];
            containers.forEach(id => {
                const cont = document.getElementById(id);
                const inputs = cont.querySelectorAll('.input-group');
                if (inputs[lastIndex]) {
                    inputs[lastIndex].remove();
                }
            });
        } else {
            // No es el último campo - solo poner en 0 en lugar de eliminar
            inputGroup.querySelector('input').value = '0';
            alert('Para mantener meses balanceados, este campo se puso en 0. Solo puedes eliminar el último mes completo.');
        }
        
        updateMonthIndicators();
    } else {
        alert('Debe haber al menos un mes completo');
    }
}

function updateMonthIndicators() {
    
    const containers = ['ingresos-container', 'fijos-container', 'dinamicos-container'];
    
    containers.forEach(containerId => {
        const container = document.getElementById(containerId);
        const indicators = container.querySelectorAll('.month-indicator');        
        indicators.forEach((indicator, index) => {
            indicator.textContent = `M${index + 1}`;
        });
    });
    
    // Verificar el balance final
    const count1 = document.querySelectorAll('#ingresos-container .input-group').length;
    const count2 = document.querySelectorAll('#fijos-container .input-group').length;
    const count3 = document.querySelectorAll('#dinamicos-container .input-group').length;
    console.log('Balance final:', { count1, count2, count3 });
}
// Renumerar botones MEJORADA: Ajusta textos/onclick Y REMUEVE BOTONES EXTRAS para que #botones == #meses
// Regenerar botones de eliminación
function renumerarBotonesEliminar() {
    const botonesContainer = document.getElementById('botones-eliminar-container');
    if (!botonesContainer) {
        console.error('Depuración: No se encontró botones-eliminar-container');
        return;
    }

    const mesesRestantes = document.querySelectorAll('#ingresos-container .input-group').length;
    console.log('Depuración: Número de meses restantes =', mesesRestantes);
    console.log('Depuración: Contenido de ingresos-container:', document.getElementById('ingresos-container').innerHTML);

    botonesContainer.innerHTML = ''; // Vaciar el contenedor

    for (let i = 0; i < mesesRestantes; i++) {
        const newButtonDiv = document.createElement('div');
        newButtonDiv.className = 'text-center mt-2';
        newButtonDiv.innerHTML = `
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMes(${i})">
                <i class="bi bi-trash"></i> Eliminar Mes ${i + 1}
            </button>
        `;
        botonesContainer.appendChild(newButtonDiv);
    }
}
// Función addMonth CORREGIDA: Agrega un mes completo (un campo en cada contenedor)
   /*  function addMonth() {
        addField('ingresos-container');
        addField('fijos-container');
        addField('dinamicos-container');
        addEliminarButton(); // Agrega botón para el nuevo mes
        updateMonthIndicators();
    } */
  // Añadir un nuevo mes con fila vacía
function addMonth() {
    addField('ingresos-container');
    addField('fijos-container');
    addField('dinamicos-container');
    updateMonthIndicators();
    renumerarBotonesEliminar();
}
// Función addMonth CORREGIDA (usa el addField nuevo)
/* function addMonth() {
    addField('ingresos-container');
    addField('fijos-container');
    addField('dinamicos-container');
} */

// Función removeLastMonth (opcional, para remover sincronizado - AGREGAR SI NO LA TIENES)
function removeLastMonth() {
    removeLastField('ingresos-container');
    removeLastField('fijos-container');
    removeLastField('dinamicos-container');
}

function removeLastField(containerId) {
    const container = document.getElementById(containerId);
    const allInputs = container.querySelectorAll('.input-group');
    if (allInputs.length > 1) {
        allInputs[allInputs.length - 1].remove();
    } else {
        alert('Debe haber al menos un mes');
    }
}

function addEliminarButton() {
        const container = document.getElementById('botones-eliminar-container');
        const currentButtons = container.querySelectorAll('button').length;
        const newButtonDiv = document.createElement('div');
        newButtonDiv.className = 'text-center mt-2';
        newButtonDiv.innerHTML = `
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMes(${currentButtons})">
                <i class="bi bi-trash"></i> Eliminar Mes ${currentButtons + 1}
            </button>
        `;
        container.appendChild(newButtonDiv);
    }

// Función removeMes CORREGIDA: Elimina un mes específico (por índice) de TODAS las columnas, sin perder datos de otros
// Eliminar un mes específico
// Eliminar un mes específico
function removeMes(mesIndex) {
    const containers = ['ingresos-container', 'fijos-container', 'dinamicos-container'];
    const mesesActuales = document.querySelectorAll('#ingresos-container .input-group').length;

    console.log('Depuración: Intentando eliminar mes', mesIndex + 1, 'con', mesesActuales, 'meses totales');

    if (mesesActuales <= 1) {
        alert('Debe haber al menos un mes completo.');
        return;
    }

    if (mesIndex >= mesesActuales || mesIndex < 0) {
        alert('Mes inválido.');
        return;
    }

    containers.forEach(containerId => {
        const container = document.getElementById(containerId);
        const inputs = container.querySelectorAll('.input-group');
        if (inputs[mesIndex]) {
            inputs[mesIndex].remove();
            console.log('Depuración: Eliminada fila en', containerId, 'índice', mesIndex);
        } else {
            console.log('Depuración: No se encontró fila en', containerId, 'índice', mesIndex);
        }
    });

    updateMonthIndicators();
    renumerarBotonesEliminar();
}

function getPlaceholder(containerId) {
    if (containerId === 'ingresos-container') return '2800';
    if (containerId === 'fijos-container') return '850';
    if (containerId === 'dinamicos-container') return '550';
    return '0';
}
/* function renumerarBotonesEliminar() {
    const botones = document.querySelectorAll('#botones-eliminar-container button');
    botones.forEach((boton, index) => {
        boton.innerHTML = `<i class="bi bi-trash"></i> Eliminar Mes ${index + 1}`;
        boton.setAttribute('onclick', `removeMes(${index})`);
    });
} */
// Función para balancear (agregar campos faltantes si por error hay desbalanceo)
    function balancearMeses() {
        const containers = ['ingresos-container', 'fijos-container', 'dinamicos-container'];
        const counts = containers.map(id => document.querySelectorAll(`#${id} .input-group`).length);
        const maxCount = Math.max(...counts);

        containers.forEach(containerId => {
            const currentCount = document.querySelectorAll(`#${containerId} .input-group`).length;
            for (let i = 0; i < maxCount - currentCount; i++) {
                addField(containerId);
            }
        });

        // Renumerar todo después de balancear
        updateMonthIndicators();
        renumerarBotonesEliminar();
    }
    // Descargar plantilla CSV
    function descargarPlantilla() {
        const contenido = `ingresos,gastos_fijos,gastos_dinamicos\n2800,850,550\n3000,900,600\n2750,800,500`;
        const blob = new Blob([contenido], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'plantilla-finanzas-familiares.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        alert('Plantilla descargada. Ábrela con Excel y completa con tus datos.');
    }

    // Cambio entre modos + Manejo de 'required'
    document.addEventListener('DOMContentLoaded', function() {
        limpiarValoresIniciales();
    updateMonthIndicators();
    renumerarBotonesEliminar();
        const rapidoContainer = document.getElementById('modo-rapido-container');
        const detalladoContainer = document.getElementById('modo-detallado-container');

        

        // Función para actualizar required según modo
        function actualizarRequired(modo) {
            if (modo === 'rapido') {
                // Required solo en modo rápido
                document.querySelectorAll('#modo-rapido-container input[type="number"]').forEach(input => {
                    input.required = true;
                });
                document.querySelectorAll('#modo-detallado-container [required]').forEach(field => {
                    field.removeAttribute('required');
                });
            } else {
                // Required solo en modo detallado
                document.querySelectorAll('#modo-rapido-container input[type="number"]').forEach(input => {
                    input.removeAttribute('required');
                });
                document.querySelectorAll('#modo-detallado-container input[type="number"], #modo-detallado-container select').forEach(field => {
                    field.required = true;
                });
            }
        }

        // Inicializar: Modo rápido visible, required en sus campos
        actualizarRequired('rapido');

        document.querySelectorAll('input[name="modo_ingreso"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const modo = this.value;
                if (modo === 'rapido') {
                    rapidoContainer.style.display = 'block';
                    detalladoContainer.style.display = 'none';
                } else {
                    rapidoContainer.style.display = 'none';
                    detalladoContainer.style.display = 'block';
                }
                actualizarRequired(modo);
            });
        });

        // Contadores para dinámicos
        let ingresoCounter = 1;
        let gastoCounter = 1;

        window.addIngresoDetallado = function() {
            const container = document.getElementById('ingresos-detallados-container');
            const newIngreso = document.createElement('div');
            newIngreso.className = 'ingreso-mes mb-3 p-3 border rounded';
            newIngreso.innerHTML = `
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Mes</label>
                        <input type="month" name="ingresos_detallados[${ingresoCounter}][mes]" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Descripción</label>
                        <input type="text" name="ingresos_detallados[${ingresoCounter}][descripcion]" 
                               class="form-control" placeholder="Ej: Salario principal">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Monto</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="ingresos_detallados[${ingresoCounter}][monto]" 
                                   class="form-control" step="0.01" min="0">
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(newIngreso);
            ingresoCounter++;
        }

        window.addGastoDetallado = function() {
            const container = document.getElementById('gastos-detallados-container');
            const newGasto = document.createElement('div');
            newGasto.className = 'gasto-item mb-3 p-3 border rounded';
            newGasto.innerHTML = `
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="gastos_detallados[${gastoCounter}][fecha]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Categoría</label>
                        <select name="gastos_detallados[${gastoCounter}][categoria_id]" class="form-select categoria-select" 
                                onchange="actualizarSubcategorias(this)">
                            <option value="">Seleccionar...</option>
                            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($categoria->id); ?>" data-color="<?php echo e($categoria->color); ?>">
                                    <?php echo e($categoria->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Subcategoría</label>
                        <select name="gastos_detallados[${gastoCounter}][subcategoria_id]" class="form-select subcategoria-select">
                            <option value="">Primero selecciona categoría</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Monto</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="gastos_detallados[${gastoCounter}][monto]" 
                                   class="form-control" step="0.01" min="0">
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger" onclick="removeGastoItem(this)">
                            ×
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <label class="form-label">Descripción (opcional)</label>
                        <input type="text" name="gastos_detallados[${gastoCounter}][descripcion]" 
                               class="form-control" placeholder="Ej: Gasolina para el carro">
                    </div>
                </div>
            `;
            container.appendChild(newGasto);
            gastoCounter++;
        }

        window.removeGastoItem = function(button) {
            if (document.querySelectorAll('.gasto-item').length > 1) {
                button.closest('.gasto-item').remove();
            }
        }

        // Actualizar subcategorías según categoría seleccionada
        window.actualizarSubcategorias = async function(select) {
            const categoriaId = select.value;
            const subcategoriaSelect = select.closest('.row').querySelector('.subcategoria-select');
            
            if (!categoriaId) {
                subcategoriaSelect.innerHTML = '<option value="">Primero selecciona categoría</option>';
                return;
            }
            
            try {
                const response = await fetch(`/api/categorias/${categoriaId}/subcategorias`);
                const subcategorias = await response.json();
                
                let options = '<option value="">Seleccionar subcategoría</option>';
                subcategorias.forEach(sub => {
                    options += `<option value="${sub.id}">${sub.name}</option>`;
                });
                
                subcategoriaSelect.innerHTML = options;
            } catch (error) {
                console.error('Error cargando subcategorías:', error);
            }
        }

        // Sugerir categorías automáticamente
        window.sugerirCategorias = function() {
            document.querySelectorAll('input[name^="gastos_detallados"][name$="[descripcion]"]').forEach(input => {
                if (input.value.trim()) {
                    console.log('Analizando:', input.value);
                }
            });
            alert('Función de sugerencia en desarrollo. Pronto estará disponible!');
        }

        // Validación antes de enviar
        const form = document.getElementById('mainForm');
        form.addEventListener('submit', function(e) {
            const modo = document.querySelector('input[name="modo_ingreso"]:checked').value;
            let isValid = true;
            
            if (modo === 'rapido') {
                isValid = validarModoRapido();
            } else {
                isValid = validarModoDetallado();
            }
            
            if (!isValid) {
                e.preventDefault();
                return false;
            }
            
            // Mostrar loading
            document.getElementById('loading-spinner').style.display = 'block';
        });

        function validarModoRapido() {
    const errors = [];
    
    // Contar meses por cada categoría
    const ingresosCampos = document.querySelectorAll('#ingresos-container input[type="number"]');
    const fijosCampos = document.querySelectorAll('#fijos-container input[type="number"]');
    const dinamicosCampos = document.querySelectorAll('#dinamicos-container input[type="number"]');
    
    const numIngresos = ingresosCampos.length;
    const numFijos = fijosCampos.length;
    const numDinamicos = dinamicosCampos.length;
    
    // Verificar que haya al menos un mes completo
    if (numIngresos === 0 || numFijos === 0 || numDinamicos === 0) {
        errors.push('Debe haber al menos un mes completo (los 3 campos)');
    }
    
    // Verificar que no haya valores negativos
    ingresosCampos.forEach((input, index) => {
        const valor = parseFloat(input.value) || 0;
        if (valor < 0) {
            errors.push(`Valor negativo no permitido en ingresos, mes ${index + 1}`);
        }
    });
    
    fijosCampos.forEach((input, index) => {
        const valor = parseFloat(input.value) || 0;
        if (valor < 0) {
            errors.push(`Valor negativo no permitido en gastos fijos, mes ${index + 1}`);
        }
    });
    
    dinamicosCampos.forEach((input, index) => {
        const valor = parseFloat(input.value) || 0;
        if (valor < 0) {
            errors.push(`Valor negativo no permitido en gastos dinámicos, mes ${index + 1}`);
        }
    });
    
    // Buscar al menos un mes completo con datos
    let mesCompletoEncontrado = false;
    for (let i = 0; i < Math.max(numIngresos, numFijos, numDinamicos); i++) {
        const ingreso = parseFloat(ingresosCampos[i]?.value) || 0;
        const fijo = parseFloat(fijosCampos[i]?.value) || 0;
        const dinamico = parseFloat(dinamicosCampos[i]?.value) || 0;
        
        // Considerar "mes completo" si tiene al menos un valor > 0
        if (ingreso > 0 || fijo > 0 || dinamico > 0) {
            mesCompletoEncontrado = true;
            break;
        }
    }
    
    if (!mesCompletoEncontrado) {
        errors.push('Debes ingresar al menos un mes con datos (puede tener ceros en algunos campos)');
    }
    
    if (errors.length > 0) {
        alert('Corrige estos errores:\n\n' + errors.join('\n'));
        return false;
    }
    
    return true;
}
// Añadir un nuevo mes trasladando los valores de los inputs iniciales
// Añadir un nuevo mes trasladando los valores de los inputs iniciales
// Añadir un nuevo mes trasladando los valores de los inputs iniciales


function addField(containerId, value = '') {
    const config = nameMap[containerId];
    if (!config) return;

    const container = document.getElementById(containerId);
    const currentCount = container.querySelectorAll('.input-group').length;
    const newField = document.createElement('div');
    newField.className = 'input-group mb-2';
    newField.innerHTML = `
        <span class="input-group-text">
            <small class="text-muted month-indicator">M${currentCount + 1}</small>
        </span>
        <input type="number" name="${config.name}[]" class="form-control" value="${value}" placeholder="Ej: ${config.placeholder}" step="0.01" min="0">
    `;
    container.appendChild(newField);
}

// Actualizar indicadores visuales (M1, M2, etc.) en todas las columnas
function updateMonthIndicators() {
    const containers = ['ingresos-container', 'fijos-container', 'dinamicos-container'];
    containers.forEach(containerId => {
        const container = document.getElementById(containerId);
        const indicators = container.querySelectorAll('.month-indicator');
        indicators.forEach((indicator, index) => {
            indicator.textContent = `M${index + 1}`;
        });
    });
}

function getPlaceholder(containerId) {
    const placeholders = {
        'ingresos-container': '2800',
        'fijos-container': '850', 
        'dinamicos-container': '550'
    };
    return placeholders[containerId] || '0';
}

        function validarModoDetallado() {
            const errors = [];
            
            const ingresos = document.querySelectorAll('#modo-detallado-container input[name^="ingresos_detallados"][name$="[monto]"]');
            const gastos = document.querySelectorAll('#modo-detallado-container input[name^="gastos_detallados"][name$="[monto]"]');
            const categorias = document.querySelectorAll('#modo-detallado-container select[name^="gastos_detallados"][name$="[categoria_id]"]');
            
            if (Array.from(ingresos).every(input => input.value.trim() === '')) {
                errors.push('Debes ingresar al menos un ingreso');
            }
            if (Array.from(gastos).every(input => input.value.trim() === '')) {
                errors.push('Debes ingresar al menos un gasto');
            }
            if (Array.from(categorias).every(select => select.value === '')) {
                errors.push('Debes seleccionar categorías para los gastos');
            }
            
            if (errors.length > 0) {
                alert('Por favor corrige los siguientes errores:\n\n' + errors.join('\n'));
                return false;
            }
            return true;
        }
        // Inicializar: Limpiar, balancear y generar botones
limpiarValoresIniciales(); // Borra valores de ejemplo
balancearMeses();
updateMonthIndicators(); // Fuerza renumeración de M1, etc.
renumerarBotonesEliminar(); // Genera EXACTO 1 botón inicial
    updateMonthIndicators();
            function getPlaceholder(containerId) {
            if (containerId === 'ingresos-container') return '2800';
            if (containerId === 'fijos-container') return '850';
            if (containerId === 'dinamicos-container') return '550';
            return '0';
        }
    });
// PEGAR ESTO AL FINAL DE TODO TU JAVASCRIPT
console.log('🔧 DEBUG CARGADO - VERSIÓN MEJORADA');

function verificarDatos() {
    console.log('=== VERIFICANDO DATOS ===');
    
    try {
        // Contar campos en cada columna
        const ingresos = document.querySelectorAll('#ingresos-container input').length;
        const fijos = document.querySelectorAll('#fijos-container input').length;
        const dinamicos = document.querySelectorAll('#dinamicos-container input').length;
        
        console.log('📊 CANTIDAD DE CAMPOS:');
        console.log(' - Ingresos:', ingresos);
        console.log(' - Fijos:', fijos);
        console.log(' - Dinámicos:', dinamicos);
        
        // Mostrar valores
        console.log('💰 VALORES INGRESOS:', Array.from(document.querySelectorAll('#ingresos-container input')).map(i => i.value));
        console.log('🏠 VALORES FIJOS:', Array.from(document.querySelectorAll('#fijos-container input')).map(i => i.value));
        console.log('🎯 VALORES DINÁMICOS:', Array.from(document.querySelectorAll('#dinamicos-container input')).map(i => i.value));
        
        // Verificar balance
        if (ingresos === fijos && fijos === dinamicos) {
            console.log('✅ FORMULARIO BALANCEADO');
        } else {
            console.log('❌ FORMULARIO DESBALANCEADO');
        }
        
    } catch (error) {
        console.log('❌ ERROR en verificarDatos:', error);
    }
}

// Esperar a que la página cargue completamente
window.addEventListener('load', function() {
    console.log('📄 PÁGINA CARGADA - BUSCANDO FORMULARIO');
    
    const form = document.getElementById('mainForm');
    if (form) {
        console.log('✅ FORMULARIO ENCONTRADO');
        form.addEventListener('submit', function(e) {
            console.log('📤 FORMULARIO ENVIÁNDOSE...');
            verificarDatos();
            
            // Esperar un momento para ver los logs antes de que se envíe
            setTimeout(() => {
                console.log('⏳ FORMULARIO ENVIADO AL SERVIDOR');
            }, 100);
        });
    } else {
        console.log('❌ NO SE ENCONTRÓ EL FORMULARIO mainForm');
    }
});

// FUNCIÓN PARA LIMPIAR VALORES INICIALES (evita que ejemplos se envíen)

function limpiarValoresIniciales() {
    const containers = ['ingresos-container', 'fijos-container', 'dinamicos-container'];
    containers.forEach(containerId => {
        const container = document.getElementById(containerId);
        const inputs = container.querySelectorAll('input[type="number"]');
        inputs.forEach(input => {
            input.value = '';
        });
        // Mantener solo la primera fila si hay más
        while (container.querySelectorAll('.input-group').length > 1) {
            container.querySelector('.input-group:last-child').remove();
        }
    });
    console.log('🧼 Valores iniciales limpiados y estructura reiniciada.');
}
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\versiones xampp\xampp8.2\htdocs\Sistema-de-gastos\resources\views/Dashboard/analisis.blade.php ENDPATH**/ ?>