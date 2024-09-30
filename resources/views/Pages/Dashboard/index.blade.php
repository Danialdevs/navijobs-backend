@extends("Layouts.app")

@section("content")
    @php
        $completionPercentage = $result['completion_percentage']; // Процент выполненных заявок
        $incompletePercentage = $result['incomplete_percentage']; // Процент невыполненных заявок
    @endphp

    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Главная</h1>
    <div class="breadcrumbs flex flex-col text-gray-600 mb-4">
        <h2 class="text-lg md:text-xl font-bold" style="color: #5B5B5B;">Анализируем и бережно храним данные</h2>
    </div>
    <div class="container-card flex flex-col md:flex-row gap-4 justify-center items-center">
        <div class="card1 bg-white rounded-xl shadow-md flex flex-col items-center justify-center p-4" style="width: 25%; height: 232px;">
            <h3 style="color: #123E63;" class="text-lg md:text-xl font-bold text-gray-800 mb-2 text-center">Аналитика</h3>
            <div class="chart-container w-full flex justify-center items-center">
                <canvas id="myPieChart" class="w-28 h-28" width="224" height="224" style="display: block; box-sizing: border-box; height: 112px; width: 112px;"></canvas>
            </div>
            <p style="color: #FF6B00;" class="text-lg text-orange-500 font-bold mt-2 text-center">{{ $completionPercentage }}% </p>
        </div>
        <div class="card2 bg-white rounded-xl shadow-md flex flex-col justify-center p-4" style="width: 75%; height: 232px;">
            <div class="card2-content">
                <div class="card2-text">
                    <h3 style="color: #123E63;" class="text-xl font-bold text-gray-800 mb-2 text-left">Топ 3 работника месяца</h3>
                </div>
                <div class="card2-images flex justify-center items-center mt-4">
                    <img src="https://i.ibb.co.com/VHH493m/user.png" alt="" class="w-40 h-40 rounded-[19px]">
                    <img src="https://i.ibb.co.com/VHH493m/user.png" alt="" class="w-40 h-40 rounded-[19px] ml-4">
                    <img src="https://i.ibb.co.com/VHH493m/user.png" alt="" class="w-40 h-40 rounded-[19px] ml-4">
                </div>
            </div>
        </div>
    </div>
    <div class="googleCart mt-6">
        <div id="map" class="w-full h-96 mt-6 rounded-2xl shadow-md"></div>    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Инициализация карты Яндекс.Карт
            ymaps.ready(function () {
                var myMap = new ymaps.Map('map', {
                    center: [51.732731, 75.313413], // Дефолтный центр карты
                    zoom: 18,
                    controls: ['zoomControl', 'geolocationControl']
                });

                // Координаты маршрутов для двух пользователей
                var routeCoordinatesUser1 = [
                    [51.732731, 75.313413], // Дефолтное положение
                    [51.732782, 75.314942],
                ];

                var routeCoordinatesUser2 = [
                    [51.732731, 75.313413], // Дефолтное положение
                    [51.732782, 75.314942],
                ];


                // Плацмаркеры для двух пользователей
                var user1Placemark = new ymaps.Placemark(routeCoordinatesUser1[0], {
                    balloonContent: 'Пользователь 1'
                }, {
                    preset: 'islands#redIcon'
                });

                var user2Placemark = new ymaps.Placemark(routeCoordinatesUser2[0], {
                    balloonContent: 'Пользователь 2'
                }, {
                    preset: 'islands#blueIcon'
                });

                // Добавляем плацмаркеры на карту
                myMap.geoObjects.add(user1Placemark);
                myMap.geoObjects.add(user2Placemark);

                // Функция для перемещения плацмаркеров по маршруту
                function movePlacemark(placemark, routeCoordinates, interval) {
                    let index = 0;
                    function move() {
                        if (index < routeCoordinates.length) {
                            placemark.geometry.setCoordinates(routeCoordinates[index]);
                            index++;
                            setTimeout(move, interval); // Интервал между перемещениями
                        }
                    }
                    move();
                }

                // Запускаем перемещение пользователей
                setTimeout(function () {
                    movePlacemark(user1Placemark, routeCoordinatesUser1, 5000); // Интервал 5 секунд
                }, 2000);

                setTimeout(function () {
                    movePlacemark(user2Placemark, routeCoordinatesUser2, 7000); // Интервал 7 секунд
                }, 2000);

            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Данные для диаграммы (динамические данные из Blade-шаблона)
            const data = {
                datasets: [{
                    data: [{{ $incompletePercentage }}, {{ $completionPercentage }}],
                    backgroundColor: ['#EDF2F7', '#FF6B00'],
                    hoverBackgroundColor: ['#EDF2F7', '#FF6B00']
                }]
            };

            const options = {
                responsive: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.raw.toFixed(2) + '%';
                            }
                        }
                    }
                }
            };

            // Создание круговой диаграммы
            const ctx = document.getElementById('myPieChart').getContext('2d');
            const myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: options
            });
        });
    </script>
@endsection
