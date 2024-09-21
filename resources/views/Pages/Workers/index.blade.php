@extends("Layouts.app")

@section("content")
    <div class="flex justify-between">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Рабочие</h1>
        <button id="addWorkerBtn" class="shadow appearance-none btn-card py-2 px-4 rounded-lg flex items-center ml-2" style="background-color: #ffffff; color:#123E63">
            добавить
        </button>
    </div>

    <div class="flex flex-wrap gap-3">
        @foreach($users as $user)
            <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center w-full sm:w-1/2 md:w-1/3 lg:w-1/4" style="height: 309px;">
                <h3 class="text-xl font-bold mb-4">{{ $user->getfioAttribute() }}</h3>
                <img src="https://i.ibb.co/VHH493m/user.png" alt="" class="w-40 h-40 rounded-full border border-gray-300 mb-4">
                <a href="{{route("workers-show", $user->id)}}" class="shadow appearance-none btn-card py-2 px-4 rounded-lg flex items-center" style="background-color: #ffffff; color: #123E63">
                    перейти
                </a>
            </div>
        @endforeach
    </div>

    <div id="workerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6" style="width: 800px; border-radius: 35px; border: #FF6B00 solid 2px;">
            <h2 class="text-xl font-bold mb-4 " style="color:#123E63">Добавить работника</h2>
            <form id="workerForm" action="{{ route('workers-store') }}" method="post">
                @csrf
                <div class="flex flex-wrap mx-3 mb-4">
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="photo">Фото:</label>
                        <img id="photoPreview" src="https://i.ibb.co/VHH493m/user.png" alt="" class="w-40 h-40 rounded-full border border-gray-300 mb-4">
                        <input type="file" id="photo" name="photo" accept="image/*" class="hidden">
                        <button id="uploadPhotoBtn" type="button" class="btn-card py-2 px-4 rounded-lg flex items-center shadow appearance-none" style="background-color: #ffffff; color:#123E63">
                            Загрузить фото
                            <img src="/img/add_photo-1024 1.svg" alt="" class="ml-2">
                        </button>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Имя:</label>
                            <input name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Введите имя" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">Фамилия:</label>
                            <input name="last_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lastname" type="text" placeholder="Введите фамилию" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="surname">Отчество:</label>
                            <input name="middle_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="surname" type="text" placeholder="Введите отчество">
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Телефон:</label>
                            <input name="phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phone" type="text" placeholder="Введите телефон" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Адрес электронной почты:</label>
                            <input name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="Введите адрес" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Пароль:</label>
                            <input name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Введите пароль" required>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <button type="submit" id="submitWorkerBtn" class="text-white rounded focus:outline-none focus:shadow-outline flex items-center justify-center" style="background-color: #FF6B00; width: 150px; height: 40px; border-radius: 502.31px;" >
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
