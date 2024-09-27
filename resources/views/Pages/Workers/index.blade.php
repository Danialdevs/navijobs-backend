@extends("Layouts.app")

@section("content")
    <div class="flex justify-between">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Рабочие</h1>

        @if(auth()->user() && in_array(auth()->user()->role, ['company_admin', 'office_admin']))
            <button id="addWorkerBtn" class="shadow appearance-none btn-card py-2 px-4 rounded-lg flex items-center ml-2" style="background-color: #ffffff; color:#123E63">
                Добавить
            </button>
        @endif
    </div>


    <div class="flex flex-wrap gap-3">
        @foreach($users as $user)
            <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between items-center w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                <div class="flex flex-col items-center flex-grow">
                    <h3 class="text-xl font-bold mb-4">{{ $user->getfioAttribute() }}</h3>
                    <img src="https://i.ibb.co/VHH493m/user.png" alt="" class="w-40 h-40 rounded-full border border-gray-300 mb-4">
                </div>
                <a href="{{route('workers-show', $user->id)}}" class="shadow appearance-none btn-card py-2 px-4 rounded-lg flex items-center" style="background-color: #ffffff; color: #123E63">
                    Перейти
                </a>
            </div>
        @endforeach
    </div>

<div id="workerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6" style="width: 800px; border-radius: 35px; border: #FF6B00 solid 2px;">
        <h2 class="text-xl font-bold mb-4" style="color:#123E63">Добавить работника</h2>
        <form id="workerForm" action="{{ route('workers-store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-wrap mb-4">
                <div class="w-full md:w-1/2">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Имя:</label>
                        <input name="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" id="name" type="text" placeholder="Введите имя" required>
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">Фамилия:</label>
                        <input name="last_name" value="{{ old('last_name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('last_name') border-red-500 @enderror" id="lastname" type="text" placeholder="Введите фамилию" required>
                        @error('last_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="surname">Отчество:</label>
                        <input name="middle_name" value="{{ old('middle_name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="surname" type="text" placeholder="Введите отчество">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">Пол:</label>
                        <select name="sex" id="sex" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('gender') border-red-500 @enderror" required>
                            <option value="" disabled selected>Выберите пол</option>
                            <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Мужской</option>
                            <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Женский</option>
                        </select>
                        @error('sex')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="data_birthday">Дата рождения:</label>
                        <input name="data_birthday" value="{{ old('data_birthday') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('birth_date') border-red-500 @enderror" id="birth_date" type="date" placeholder="Введите дату рождения" required>
                        @error('data_birthday')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Телефон:</label>
                        <input name="phone" value="{{ old('phone') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror" id="phone" type="text" placeholder="Введите телефон" required>
                        @error('phone')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="office_id">Офис:</label>
                        <select name="company_office_id" id="office_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('office_id') border-red-500 @enderror" required>
                            <option value="" disabled selected>Выберите офис</option>
                            @foreach($offices as $office)
                                <option value="{{ $office->id }}" {{ old('company_office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                            @endforeach
                        </select>
                        @error('company_office_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Роль:</label>
                        <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('role') border-red-500 @enderror" required>
                                <option value="" disabled {{ old('role') === null ? 'selected' : '' }}>Выберите роль</option>
                                <option value="worker" {{ old('role') == 'worker' ? 'selected' : '' }}>Работник</option>
                                <option value="company_admin" {{ old('role') == 'company_admin' ? 'selected' : '' }}>Company Admin</option>
                                <option value="office_admin" {{ old('role') == 'office_admin' ? 'selected' : '' }}>Office Admin</option>
                                <option value="office_manager" {{ old('role') == 'office_manager' ? 'selected' : '' }}>Office Manager</option>
                        </select>
                        @error('role')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Адрес электронной почты:</label>
                        <input name="email" value="{{ old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" id="email" type="email" placeholder="Введите адрес" required>
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Пароль:</label>
                        <input name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" id="password" type="password" placeholder="Введите пароль" required>
                        @error('password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <button type="submit" id="submitWorkerBtn" class="text-white rounded focus:outline-none focus:shadow-outline flex items-center justify-center" style="background-color: #FF6B00; width: 150px; height: 40px; border-radius: 502.31px;">
                    Подтвердить
                </button>
                <button id="closeModalBtn" class="bg-gray-500 hover:bg-gray-700 text-white rounded focus:outline-none focus:shadow-outline flex items-center justify-center ml-4" style="width: 80px; height: 40px; border-radius: 502.31px;" type="button">
                    Отмена
                </button>
            </div>
        </form>
    </div>
</div>




    <script>
        document.getElementById('addWorkerBtn').addEventListener('click', function () {
            document.getElementById('workerModal').classList.remove('hidden');
            console.log('you clicked the addworkerbtn');
        });

        document.getElementById('closeModalBtn').addEventListener('click', function () {
            document.getElementById('workerModal').classList.add('hidden');

        });

        document.getElementById('uploadPhotoBtn').addEventListener('click', function () {
            document.getElementById('photo').click();
        });

        document.getElementById('photo').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('photoPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
