@extends("Layouts.app")
@section("content")
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Отчеты</h1>
        <div class="breadcrumbs flex flex-col text-gray-600 mb-4">
            <a href="#" class="inline-block">● Главная</a>
            <h2 class="text-lg md:text-xl font-bold " style="color: #5B5B5B;">Анализируем и бережно храним данные</h2>
        </div>
        <div class="container-card flex flex-col md:flex-row gap-4 justify-center items-center">
            <!-- Добавим здесь элемент canvas для графика -->
            <canvas id="myChart" width="520" height="130" style="display: block; box-sizing: border-box; height: 65px; width: 260px;"></canvas>
        </div>
        <div class="container-card flex flex-col md:flex-row gap-4 justify-center items-center mt-6">
            <!-- Добавим здесь элемент canvas для гистограммы -->
            <canvas id="myBarChart" width="520" height="130" style="display: block; box-sizing: border-box; height: 65px; width: 260px;"></canvas>
        </div>

        <script>
            // Скрипт для создания линейного графика
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                    datasets: [{
                        label: 'Средний чек ( $ )',
                        data: [500, 1000, 1500, 2000, 2400, 1800, 1200, 800, 2200, 1300, 1700, 900],
                        backgroundColor: 'rgba(255, 107, 0, 0.2)',
                        borderColor: '#FFC700',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 2400,
                            ticks: {
                                stepSize: 600
                            }
                        }
                    }
                }
            });

            // Скрипт для создания гистограммы
            const ctxBar = document.getElementById('myBarChart').getContext('2d');
            const myBarChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                    datasets: [{
                        label: 'Объем продаж (кол-во)',
                        data: [50, 100, 150, 200, 250, 300, 50, 100, 150, 200, 250, 300],
                        backgroundColor: ' rgba(255, 206, 133, 0.5)',
                        borderColor: '#FFCE85',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 300,
                            ticks: {
                                stepSize: 60
                            }
                        }
                    }
                }
            });
        </script>
@endsection
