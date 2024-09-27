@extends("Layouts.app")

@section("content")
    <div class="flex justify-between">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Услуги</h1>
        @if(auth()->user() && in_array(auth()->user()->role, ['company_admin', 'office_admin', 'office_manager']))
            <button id="addServiceBtn" class="shadow appearance-none btn-card py-2 px-4 rounded-lg flex items-center ml-2" style="background-color: #ffffff; color:#123E63">
                Добавить услугу
            </button>
        @endif
    </div>

    <div class="flex flex-wrap gap-4"> <!-- Add gap-4 for spacing -->
        @foreach($services as $service)
            <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                <h3 class="text-xl font-bold mb-4">{{ $service->name }}</h3>
                <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="w-40 h-40 object-cover rounded-full border border-gray-300 mb-4">
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

                <!-- Button Container -->
                <div class="flex gap-2"> <!-- Add gap-2 to space between buttons -->
                    <!-- Order Button -->
                    <button onclick="openModal('{{ $service->id }}')" class="shadow appearance-none btn-card py-2 px-4 rounded-lg flex items-center" style="background-color: #ffffff; color: #123E63">
                        Заказать
                    </button>

                    <!-- View Button (Перейти) -->
                    @if(auth()->user() && in_array(auth()->user()->role, ['company_admin', 'office_admin']))
                        <a href="{{ route('services-show', $service->id) }}" class="shadow appearance-none btn-card py-2 px-4 rounded-lg flex items-center" style="background-color: #ffffff; color: #123E63">
                            Перейти
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Add Service Modal -->
    <div id="serviceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6" style="width: 800px; border-radius: 35px; border: #FF6B00 solid 2px;">
            <h2 class="text-xl font-bold mb-4" style="color:#123E63">Добавить услугу</h2>
            <form id="serviceForm" action="{{ route('services-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Add your form fields here -->
            </form>
        </div>
    </div>

    <script>
        // Show modal when "Add a New Service" button is clicked
        document.getElementById('addServiceBtn').addEventListener('click', function () {
            document.getElementById('serviceModal').classList.remove('hidden');
        });

        // Close modal when "Cancel" button is clicked
        document.getElementById('closeServiceModalBtn').addEventListener('click', function () {
            document.getElementById('serviceModal').classList.add('hidden');
        });
    </script>
@endsection


