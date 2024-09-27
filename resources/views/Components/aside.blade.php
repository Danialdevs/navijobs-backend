<aside class="sidebar bg-white rounded-xl shadow-md w-full md:w-72 flex flex-col items-center p-4">
    <nav class="flex flex-col items-center gap-4 flex-1">
        <ul class="flex flex-col items-center gap-4">
            <!-- Главная (Home) page - Visible to all users -->
            <li>
                <button onclick="window.location.href='{{ route('home')  }}'" class="btn-sidebar flex items-center">
                    <img src="{{asset("images/home-2.svg")}}" alt="">
                    <span class="ml-2">Главная</span>
                </button>
            </li>

            <!-- Заявки (Requests) page - Visible to all users -->
            <li>
                <button onclick="window.location.href='{{route('request-index')}}'" class="btn-sidebar flex items-center">
                    <img src="{{asset("images/directbox-notif.svg")}}"  alt="">
                    <span class="ml-2">Заявки</span>
                </button>
            </li>

            <!-- Only show Services and Workers pages for non-workers -->
            @if(auth()->user() && !in_array(auth()->user()->role, ['worker']))
                <!-- Услуги (Services) page - Visible to non-workers -->
                <li>
                    <button onclick="window.location.href='{{ route('services-index') }}'" class="btn-sidebar flex items-center">
                        <img src="{{asset("images/service.svg")}}" class="h-6 w-6" alt="">
                        <span class="ml-2">Услуги</span>
                    </button>
                </li>

                <!-- Рабочие (Workers) page - Visible to non-workers -->
                <li>
                    <button onclick="window.location.href='{{ route('workers-index') }}'" class="btn-sidebar flex items-center">
                        <img  src="{{asset("images/profile-2user.svg")}}"  class="h-6 w-6" alt="">
                        <span class="ml-2">Рабочие</span>
                    </button>
                </li>
            @endif
        </ul>

        <!-- Logout Button - Visible to all users -->
        <div class="login-button mt-auto">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button class="btn-sidebar flex items-center">
                    <img src="{{asset("images/exit.svg")}}" class="h-6 w-6" alt="">
                    <span class="ml-2">Выйти</span>
                </button>
            </form>
        </div>
    </nav>
</aside>

