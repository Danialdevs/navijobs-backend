@extends("layouts.app")

@section("content")
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Услуга: {{ $service->name }}</h1>

    <div class="flex flex-col md:flex-row gap-4">
        <!-- Main Information Section -->
        <div class="bg-white rounded-xl shadow-md p-4 flex-1">
            <h1 class="text-xl font-bold mb-2">Основная информация</h1>
            <p>Имя услуги: {{ $service->name }}</p>
            <p>Цена: {{ $service->price }} ₸</p>
            <p>Тип услуги:
                @if($service->type === 'custom_price')
                    Цена договорная
                @elseif($service->type === 'hour_price')
                    Почасовая оплата
                @elseif($service->type === 'fixed_price')
                    Фиксированная оплата
                @endif
            </p>
        </div>

        <!-- Image Section -->
        <div class="bg-white rounded-xl shadow-md p-4 flex flex-col items-center">
            <img src="{{ asset($service->image) }}" alt="Фото услуги" class="w-40 h-40 object-cover rounded-full mb-4">
        </div>
    </div>

    <!-- Buttons Section -->
    <div class="mt-4 flex gap-2">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}"
           class="text-white font-bold py-2 px-8 rounded-lg flex items-center justify-center w-48 h-12 transition duration-300 ease-in-out"
           style="background-color: #FF6B00;">
            Назад
        </a>

        <!-- Edit Button -->
        <button id="editServiceBtn"
                class="text-white font-bold py-2 px-8 rounded-lg flex items-center justify-center w-48 h-12 transition duration-300 ease-in-out"
                style="background-color: #FF6B00;">
            Редактировать
        </button>

        <!-- Delete Button -->
        <form action="{{ route('services-destroy', $service->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту услугу?');" class="flex items-center">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="text-white font-bold py-2 px-8 rounded-lg flex items-center justify-center w-48 h-12 transition duration-300 ease-in-out"
                    style="background-color: #FF6B00;">
                Удалить услугу
            </button>
        </form>
    </div>


    <!-- Edit Modal -->
    <div id="editServiceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6" style="width: 800px; border-radius: 35px; border: #FF6B00 solid 2px;">
            <h2 class="text-xl font-bold mb-4" style="color:#123E63">Редактировать данные услуги</h2>
            <form id="editServiceForm" action="{{ route('services-update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap mb-4">
                    <!-- Left Column -->
                    <div class="w-full md:w-1/2">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Имя услуги:</label>
                            <input name="name" value="{{ old('name', $service->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" id="name" type="text" placeholder="Введите имя" required>
                            @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Цена:</label>
                            <input name="price" value="{{ old('price', $service->price) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('price') border-red-500 @enderror" id="price" type="number" placeholder="Введите цену" required>
                            @error('price')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="w-full md:w-1/2 px-3">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="type">Тип услуги:</label>
                            <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="hour_price" {{ old('type', $service->type) == 'hour_price' ? 'selected' : '' }}>Почасовая оплата</option>
                                <option value="fixed_price" {{ old('type', $service->type) == 'fixed_price' ? 'selected' : '' }}>Фиксированная оплата</option>
                                <option value="custom_price" {{ old('type', $service->type) == 'custom_price' ? 'selected' : '' }}>Цена договорная</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center">
                    <button type="submit" class="text-white rounded focus:outline-none focus:shadow-outline flex items-center justify-center" style="background-color: #FF6B00; width: 150px; height: 40px; border-radius: 502.31px;">
                        Сохранить
                    </button>
                    <button id="closeEditModalBtn" class="bg-gray-500 hover:bg-gray-700 text-white rounded focus:outline-none focus:shadow-outline flex items-center justify-center ml-4" style="width: 80px; height: 40px; border-radius: 502.31px;" type="button">
                        Отмена
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Show the modal
            document.getElementById('editServiceBtn').addEventListener('click', function () {
                document.getElementById('editServiceModal').classList.remove('hidden');
            });

            // Close the modal
            document.getElementById('closeEditModalBtn').addEventListener('click', function () {
                document.getElementById('editServiceModal').classList.add('hidden');
            });
        });
    </script>
@endsection
