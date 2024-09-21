@extends("Layouts.app")

@section("content")
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
                        <p style="color: #FF6B00;" class="text-lg text-orange-500 font-bold mt-2 text-center">57% 😢</p>
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
                    <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Adb454c5a3af7c56714d0b5184577a034a780ced88594fc2cb071ac1f5e2d5b50&amp;source=constructor" width="100%" height="400" frameborder="0" class="rounded-2xl shadow-md"></iframe>
                </div>
    @endsection
