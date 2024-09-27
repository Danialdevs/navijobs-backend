@extends("Layouts.app")

@section("content")
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Заявки</h1>
    <div class="breadcrumbs flex flex-col text-gray-600 mb-4">
        <a href="#" class="inline-block">●Список</a>
        <h2 class="text-lg md:text-xl font-bold" style="color: #5B5B5B;">Здесь мы отобразили заявки от клиентов</h2>
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
                <th class="py-2 px-4 border border-gray-300">Услуга</th>
                <!-- Conditionally show "Assigned to" column for non-workers -->
                @if(auth()->user()->role !== 'worker')
                    <th class="py-2 px-4 border border-gray-300">Назначено</th>
                @endif
                <!-- Conditionally show "Change Status" or "Assign" column based on role -->
                @if(auth()->user()->role === 'worker')
                    <th class="py-2 px-4 border border-gray-300">Изменить статус</th>
                @else
                    <th class="py-2 px-4 border border-gray-300">Назначить</th>
                @endif
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
                    <td class="py-2 px-4 border border-gray-300">
                        @if($application->status == 'awaiting')
                            В ожидании
                        @elseif($application->status == 'full-done')
                            Завершено
                        @elseif($application->status == 'canceled')
                            Отменено
                        @endif
                    </td>

                    <!-- Display service name -->
                    <td class="py-2 px-4 border border-gray-300">
                        {{$application->service ? $application->service->name : 'Услуга не найдена'}}
                    </td>

                    <!-- Conditionally show "Assigned to" for non-workers -->
                    @if(auth()->user()->role !== 'worker')
                        <td class="py-2 px-4 border border-gray-300">
                            @if($application->assignedWorker)
                                {{$application->assignedWorker->user->name}}
                            @else
                                Не назначено
                            @endif
                        </td>
                    @endif

                    <!-- Conditionally show "Change Status" or "Assign" based on user role -->
                    <td class="py-2 px-4 border border-gray-300">
                        @if(auth()->user()->role === 'worker')
                            <!-- Workers can change the status -->
                            <form action="{{ route('request-change-status', $application->id) }}" method="POST">
                                @csrf
                                <select name="status" class="border rounded-lg px-2 py-1">
                                    <option value="awaiting" @if($application->status == 'awaiting') selected @endif>В ожидании</option>
                                    <option value="full-done" @if($application->status == 'full-done') selected @endif>Завершено</option>
                                    <option value="canceled" @if($application->status == 'canceled') selected @endif>Отменено</option>
                                </select>
                                <button type="submit" class="bg-blue-500 text-white py-1 px-4 rounded-lg mt-2">
                                    Изменить
                                </button>
                            </form>

                        @else
                            <!-- Non-workers can assign workers -->
                            @if(!$application->assignedWorker)
                                <form action="{{ route('request-assign-worker', $application->id) }}" method="POST">
                                    @csrf
                                    <select name="worker_id" class="border rounded-lg px-2 py-1">
                                        @foreach($workers as $worker)
                                            <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-blue-500 text-white py-1 px-4 rounded-lg mt-2">
                                        Назначить
                                    </button>
                                </form>
                            @else
                                Рабочий назначен
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

