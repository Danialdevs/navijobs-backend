@extends("Layouts.app")

@section("content")
    <div class="flex justify-between">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Услуги</h1>
        <button class="shadow appearance-none btn-card py-2 px-4 rounded-lg flex items-center ml-2" style="background-color: #ffffff; color:#123E63">
            Добавить услугу
        </button>
    </div>
    <div class="flex flex-wrap gap-4"> <!-- Add gap-4 for spacing -->
        @foreach($services as $service)
            <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                <h3 class="text-xl font-bold mb-4">{{ $service->name }}</h3>
                <img src="{{$service->image}}" alt="{{ $service->name }}" class="w-40 h-40 object-cover rounded-full border border-gray-300 mb-4"> <!-- Use object-cover -->
                <p class="text-lg mb-2">{{ $service->price }} ₸</p>
                <p class="text-lg mb-4">
                    @if($service->type === 'custom_price')
                        Цена договорная
                    @elseif($service->type === 'hour_price')
                        Цена почасовая
                    @elseif($service->type === 'fixed_price')
                        Цена фиксированная
                    @endif
                </p>

                <button onclick="openModal('{{ $service->id }}')" class="shadow appearance-none btn-card py-2 px-4 rounded-lg flex items-center" style="background-color: #ffffff; color: #123E63">
                    Заказать
                </button>
            </div>
        @endforeach
    </div>
@endsection

