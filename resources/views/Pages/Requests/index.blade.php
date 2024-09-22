@extends("Layouts.app")
@section("content")
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Заявки</h1>
        <div class="breadcrumbs flex flex-col text-gray-600 mb-4">
            <a href="#" class="inline-block">● Главная</a>
            <h2 class="text-lg md:text-xl font-bold " style="color: #5B5B5B;  ">Анализируем и бережно храним данные</h2>
        </div>

        <!-- Таблица заявок -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl shadow-md">
                <thead class="bg-gray-300" style="border-radius: 15px;">
                <tr>
                    <th class="py-2 px-4 border border-gray-300">Номер</th>
                    <th class="py-2 px-4 border border-gray-300">Клиент</th>
                    <th class="py-2 px-4 border border-gray-300">Адрес</th>
                    <th class="py-2 px-4 border border-gray-300">Дата</th>
                    <th class="py-2 px-4 border border-gray-300">Сумма</th>
                    <th class="py-2 px-4 border border-gray-300">Статус</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="py-2 px-4 border border-gray-300 ">1</td>
                    <td class="py-2 px-4 border border-gray-300">Иван Иванов</td>
                    <td class="py-2 px-4 border border-gray-300">ул. Ленина, 1</td>
                    <td class="py-2 px-4 border border-gray-300">12.07.2024</td>
                    <td class="py-2 px-4 border border-gray-300">1000 руб.</td>
                    <td class="py-2 px-4 border border-gray-300">Выполнено</td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border border-gray-300">2</td>
                    <td class="py-2 px-4 border border-gray-300">Петр Петров</td>
                    <td class="py-2 px-4 border border-gray-300">ул. Куйбышева, 5</td>
                    <td class="py-2 px-4 border border-gray-300">13.07.2024</td>
                    <td class="py-2 px-4 border border-gray-300">1500 руб.</td>
                    <td class="py-2 px-4 border border-gray-300">В процессе</td>
                </tr>
                <!-- Добавьте здесь другие строки -->
                </tbody>
            </table>
        </div>
@endsection
