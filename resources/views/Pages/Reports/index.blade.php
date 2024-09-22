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
@endsection
