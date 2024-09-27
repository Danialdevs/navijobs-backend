
@extends("Layouts.app")

@section("content")
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Рабочие</h1>
    <div class="flex flex-col md:flex-row gap-4">
        <div class="bg-white rounded-xl shadow-md p-4 flex-1">
            <h1 class="text-xl font-bold mb-2">Основная информация</h1>
            <p>Имя: {{ $user->name }}</p>
            <p>Фамилия: {{ $user->last_name }}</p>
            <p>Отчество: {{ $user->middle_name }}</p>
            <p>Дата рождения: {{ $user->data_birthday }}</p>
            <p>Пол: {{ $user->sex }}</p>
            <p>Специальность: {{ $user->role }}</p>
            <p>Номер Телефона: {{$user->phone}}</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 flex flex-col items-center">
            <img src="https://i.ibb.co.com/VHH493m/user.png" alt="Фото рабочего" class="w-32 h-32 rounded-full mb-4">
        </div>
    </div>

    <!-- Buttons Section -->
    <div class="mt-4 flex gap-2">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}"
           class="text-white font-bold py-2 px-6 rounded-lg flex items-center justify-center transition duration-300 ease-in-out"
           style="background-color: #FF6B00; hover:background-color: #FF8A33; width: 180px; height: 44px;">
            Назад
        </a>

        @if(auth()->user() && in_array(auth()->user()->role, ['company_admin', 'office_admin']))
            <!-- Edit Button -->
            <button id="editWorkerBtn"
                    class="text-white font-bold py-2 px-6 rounded-lg flex items-center justify-center transition duration-300 ease-in-out"
                    style="background-color: #FF6B00; hover:background-color: #FF8A33; width: 180px; height: 44px;">
                Отредактировать данные
            </button>

            <!-- Delete Button -->
            <form action="{{ route('workers-destroy', $user->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этого рабочего?');" class="flex items-center">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="text-white font-bold py-2 px-6 rounded-lg flex items-center justify-center transition duration-300 ease-in-out"
                        style="background-color: #FF6B00; hover:background-color: #FF8A33; width: 180px; height: 44px;">
                    Удалить рабочего
                </button>
            </form>
        @endif
    </div>




    <!-- Edit Modal -->
    <div id="editWorkerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6" style="width: 800px; border-radius: 35px; border: #FF6B00 solid 2px;">
            <h2 class="text-xl font-bold mb-4" style="color:#123E63">Редактировать данные работника</h2>
            <form id="editWorkerForm" action="{{ route('workers-update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap mb-4">
                    <!-- Left Column -->
                    <div class="w-full md:w-1/2">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Имя:</label>
                            <input name="name" value="{{ old('name', $user->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" id="name" type="text" placeholder="Введите имя" required>
                            @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">Фамилия:</label>
                            <input name="last_name" value="{{ old('last_name', $user->last_name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('last_name') border-red-500 @enderror" id="lastname" type="text" placeholder="Введите фамилию" required>
                            @error('last_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="middle_name">Отчество:</label>
                            <input name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="middle_name" type="text" placeholder="Введите отчество">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="sex">Пол:</label>
                            <select name="sex" id="sex" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="" disabled>Выберите пол</option>
                                <option value="male" {{ old('sex', $user->sex) == 'male' ? 'selected' : '' }}>Мужской</option>
                                <option value="female" {{ old('sex', $user->sex) == 'female' ? 'selected' : '' }}>Женский</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="data_birthday">Дата рождения:</label>
                            <input name="data_birthday" value="{{ old('data_birthday', $user->data_birthday) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="data_birthday" type="date" placeholder="Введите дату рождения" required>
                        </div>
                    </div>
                    <!-- Right Column -->
                    <div class="w-full md:w-1/2 px-3">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Телефон:</label>
                            <input name="phone" value="{{ old('phone', $user->phone) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phone" type="text" placeholder="Введите телефон" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Роль:</label>
                            <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="worker" {{ old('role', $user->role) == 'worker' ? 'selected' : '' }}>Работник</option>
                                <option value="company_admin" {{ old('role', $user->role) == 'company_admin' ? 'selected' : '' }}>Company Admin</option>
                                <option value="office_admin" {{ old('role', $user->role) == 'office_admin' ? 'selected' : '' }}>Office Admin</option>
                                <option value="office_manager" {{ old('role', $user->role) == 'office_manager' ? 'selected' : '' }}>Office Manager</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:</label>
                            <input name="email" value="{{ old('email', $user->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="Введите адрес" required>
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
            document.getElementById('editWorkerBtn').addEventListener('click', function () {
                document.getElementById('editWorkerModal').classList.remove('hidden');
            });

            // Close the modal
            document.getElementById('closeEditModalBtn').addEventListener('click', function () {
                document.getElementById('editWorkerModal').classList.add('hidden');
            });
        });
    </script>
@endsection

