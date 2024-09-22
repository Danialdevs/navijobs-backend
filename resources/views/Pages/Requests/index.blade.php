@extends("Layouts.app")

@section("content")
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Заявки</h1>
    <div class="breadcrumbs flex flex-col text-gray-600 mb-4">
        <a href="#" class="inline-block">● Главная</a>
        <h2 class="text-lg md:text-xl font-bold" style="color: #5B5B5B;">Анализируем и бережно храним данные</h2>
    </div>

    <!-- Таблица заявок -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-md">
        <table class="min-w-full">
            <thead class="bg-gray-300 rounded-t-xl">
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
               @foreach($applications as $application)
                   <tr>
                    <td class="py-2 px-4 border border-gray-300">{{$application->id}}</td>
                    <td class="py-2 px-4 border border-gray-300">{{$application->client->name}}</td>
                    <td class="py-2 px-4 border border-gray-300">{{$application->address}}</td>
                    <td class="py-2 px-4 border border-gray-300">{{$application->created_at}}</td>
                    <td class="py-2 px-4 border border-gray-300">{{$application->applicationPrices->first()->price}} руб.</td>
                    <td class="py-2 px-4 border border-gray-300">{{$application->status}}</td>
                   </tr>
               @endforeach

            </tbody>
        </table>
    </div>
@endsection
