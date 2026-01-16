<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas de Frecuencia - FinanzAnalyzer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('analisis.index') }}">
                <i class="bi bi-arrow-left"></i> Volver al Análisis Principal
            </a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('analisis.tendencias') }}" class="nav-link">
                    <i class="bi bi-graph-up"></i> Tendencias
                </a>
                <a href="{{ route('analisis.comparativo') }}" class="nav-link">
                    <i class="bi bi-bar-chart"></i> Comparativo
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="display-5 text-primary">
                <i class="bi bi-table"></i> Análisis de Frecuencias
            </h1>
            <p class="lead">Distribución estadística de tus datos financieros</p>
        </div>

        <!-- Resumen Rápido -->
        @if(isset($datosAnalisis))
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body text-center">
                        <h6>Meses Analizados</h6>
                        <h4>{{ count($datosAnalisis['ingresos'] ?? []) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body text-center">
                        <h6>Prom. Ingresos</h6>
                        <h4>${{ number_format($datosAnalisis['promIngreso'] ?? 0, 0) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body text-center">
                        <h6>Prom. Gastos</h6>
                        <h4>${{ number_format(($datosAnalisis['promFijos'] ?? 0) + ($datosAnalisis['promDinamicos'] ?? 0), 0) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body text-center">
                        <h6>Saldo Mensual</h6>
                        <h4>${{ number_format($datosAnalisis['saldo'] ?? 0, 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tabla de Frecuencia por Intervalos -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-bar-chart"></i> Distribución de Gastos Dinámicos</h4>
                <button class="btn btn-sm btn-light" onclick="exportarTabla('tabla-intervalos')">
                    <i class="bi bi-download"></i> Exportar
                </button>
            </div>
            <div class="card-body">
                @if(!empty($tablaFrecuencia))
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tabla-intervalos">
                        <thead class="table-light">
                            <tr>
                                <th>Intervalo de Gastos</th>
                                <th>Marca de Clase</th>
                                <th>Frecuencia (f)</th>
                                <th>Frec. Relativa</th>
                                <th>Frec. Acumulada</th>
                                <th>Frec. Rel. Acum.</th>
                                <th>Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tablaFrecuencia as $fila)
                            <tr>
                                <td>{{ $fila['intervalo'] }}</td>
                                <td>${{ $fila['marca_clase'] }}</td>
                                <td>{{ $fila['frecuencia'] }}</td>
                                <td>{{ $fila['frecuencia_relativa'] }}</td>
                                <td>{{ $fila['frecuencia_acumulada'] }}</td>
                                <td>{{ $fila['frecuencia_relativa_acumulada'] }}</td>
                                <td>{{ $fila['porcentaje'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr>
                                <td><strong>Total</strong></td>
                                <td>-</td>
                                <td><strong>{{ array_sum(array_column($tablaFrecuencia, 'frecuencia')) }}</strong></td>
                                <td><strong>1.000</strong></td>
                                <td>-</td>
                                <td><strong>1.000</strong></td>
                                <td><strong>100%</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Interpretación -->
                <div class="alert alert-info mt-3">
                    <h6><i class="bi bi-lightbulb"></i> Interpretación:</h6>
                    <ul class="mb-0">
                        <li>La tabla muestra cómo se distribuyen tus gastos variables en diferentes rangos de valor</li>
                        <li><strong>Frecuencia:</strong> Número de meses que caen en cada intervalo</li>
                        <li><strong>Frecuencia Acumulada:</strong> Total acumulado de meses hasta ese intervalo</li>
                        <li><strong>Porcentaje:</strong> Proporción de meses en cada rango de gastos</li>
                    </ul>
                </div>
                @else
                <div class="alert alert-warning text-center">
                    <i class="bi bi-exclamation-triangle"></i> No hay datos suficientes para generar la tabla de frecuencia
                </div>
                @endif
            </div>
        </div>

        <!-- Gráficos de Frecuencia -->
        @if(!empty($histogramaData['data']))
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-bar-chart-line"></i> Histograma de Frecuencias</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="histogramaChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-graph-up"></i> Polígono de Frecuencias</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="poligonoChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tabla de Frecuencia por Categorías -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-pie-chart"></i> Frecuencia por Categorías de Gastos</h4>
                <button class="btn btn-sm btn-light" onclick="exportarTabla('tabla-categorias')">
                    <i class="bi bi-download"></i> Exportar
                </button>
            </div>
            <div class="card-body">
                @if(!empty($tablaCategorias))
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tabla-categorias">
                        <thead class="table-light">
                            <tr>
                                <th>Categoría</th>
                                <th>Frecuencia (f)</th>
                                <th>Frec. Acumulada</th>
                                <th>Porcentaje</th>
                                <th>% Acumulado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tablaCategorias as $fila)
                            <tr>
                                <td>{{ $fila['categoria'] }}</td>
                                <td>{{ $fila['frecuencia'] }}</td>
                                <td>{{ $fila['frecuencia_acumulada'] }}</td>
                                <td>{{ $fila['porcentaje'] }}</td>
                                <td>{{ $fila['porcentaje_acumulado'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Gráfico de torta para categorías -->
                <div class="row mt-4">
                    <div class="col-md-8">
                        <canvas id="categoriasChart" height="250"></canvas>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-secondary">
                            <h6><i class="bi bi-info-circle"></i> Análisis Categorías:</h6>
                            <small>
                                @php
                                    $categoriaPrincipal = $tablaCategorias[0]['categoria'] ?? '';
                                    $porcentajePrincipal = $tablaCategorias[0]['porcentaje'] ?? '0%';
                                @endphp
                                Tu mayor gasto es en <strong>{{ $categoriaPrincipal }}</strong> ({{ $porcentajePrincipal }})
                            </small>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-warning text-center">
                    <i class="bi bi-exclamation-triangle"></i> No hay datos de categorías disponibles
                </div>
                @endif
            </div>
        </div>

        <!-- Medidas Estadísticas -->
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="bi bi-calculator"></i> Medidas Estadísticas de la Distribución</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Medidas de Tendencia Central</h6>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td>Media (Promedio)</td>
                                <td>${{ number_format($datosAnalisis['promDinamicos'] ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Mediana</td>
                                <td>${{ number_format($datosAnalisis['medianaDinamicos'] ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Moda</td>
                                <td>{{ $datosAnalisis['moda'] ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Medidas de Dispersión</h6>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td>Desviación Estándar</td>
                                <td>${{ number_format($datosAnalisis['desviacion'] ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Coeficiente de Variación</td>
                                <td>{{ number_format($datosAnalisis['cvGastosDinamicos'] ?? 0, 1) }}%</td>
                            </tr>
                            <tr>
                                <td>Rango</td>
                                <td>${{ number_format($datosAnalisis['rangoDinamicos'] ?? 0, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navegación entre módulos -->
        <div class="text-center mt-4">
            <div class="btn-group" role="group">
                <a href="{{ route('analisis.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-speedometer2"></i> Análisis Principal
                </a>
                <a href="{{ route('analisis.tendencias') }}" class="btn btn-outline-success">
                    <i class="bi bi-graph-up"></i> Análisis de Tendencias
                </a>
                <a href="{{ route('analisis.comparativo') }}" class="btn btn-outline-info">
                    <i class="bi bi-bar-chart"></i> Análisis Comparativo
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript para gráficos y funcionalidades -->
    <script>
        // Gráficos
        document.addEventListener('DOMContentLoaded', function() {
            @if(!empty($histogramaData['data']))
            // Histograma
            const ctx1 = document.getElementById('histogramaChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($histogramaData['labels']) !!},
                    datasets: [{
                        label: 'Frecuencia de Gastos',
                        data: {!! json_encode($histogramaData['data']) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Frecuencia'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Rango de Gastos ($)'
                            }
                        }
                    }
                }
            });

            // Polígono de Frecuencias
            const ctx2 = document.getElementById('poligonoChart').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: {!! json_encode($histogramaData['labels']) !!},
                    datasets: [{
                        label: 'Polígono de Frecuencias',
                        data: {!! json_encode($histogramaData['data']) !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
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
            @endif

            @if(!empty($tablaCategorias))
            // Gráfico de torta para categorías
            const ctx3 = document.getElementById('categoriasChart').getContext('2d');
            const categorias = {!! json_encode(array_column($tablaCategorias, 'categoria')) !!};
            const porcentajes = {!! json_encode(array_map(function($item) {
                return floatval(str_replace('%', '', $item['porcentaje']));
            }, $tablaCategorias)) !!};
            
            new Chart(ctx3, {
                type: 'doughnut',
                data: {
                    labels: categorias,
                    datasets: [{
                        data: porcentajes,
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
            @endif
        });

        // Función para exportar tablas
        function exportarTabla(tableId) {
            const tabla = document.getElementById(tableId);
            let csv = [];
            
            // Obtener headers
            const headers = [];
            for (let i = 0; i < tabla.rows[0].cells.length; i++) {
                headers.push(tabla.rows[0].cells[i].innerText);
            }
            csv.push(headers.join(','));
            
            // Obtener datos
            for (let i = 1; i < tabla.rows.length; i++) {
                const row = [];
                for (let j = 0; j < tabla.rows[i].cells.length; j++) {
                    row.push(tabla.rows[i].cells[j].innerText);
                }
                csv.push(row.join(','));
            }
            
            // Descargar
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `tabla-frecuencia-${tableId}-${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            alert('Tabla exportada como CSV');
        }

        // Función para imprimir reporte
        function imprimirReporte() {
            window.print();
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>