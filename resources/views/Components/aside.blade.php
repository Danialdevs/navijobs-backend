            <aside class="sidebar bg-white rounded-xl shadow-md w-full md:w-72 flex flex-col items-center p-4">
                <nav class="flex flex-col items-center gap-4 flex-1">
                    <ul class="flex flex-col items-center gap-4">
                        <li>
                            <button onclick="window.location.href='index.html'" class="btn-sidebar flex items-center">
                                <img src="{{asset("images/home-2.svg")}}" alt="">
                                <span class="ml-2">Главная</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="window.location.href='requests.html'" class="btn-sidebar flex items-center">
                                <img src="{{asset("images/directbox-notif.svg")}}"  alt="">
                                <span class="ml-2">Заявки</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="window.location.href='reports.html'" class="btn-sidebar flex items-center">
                                <img   src="{{asset("images/activity.svg")}}"  alt="">
                                <span class="ml-2">Отчеты</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="window.location.href='workers.html'" class="btn-sidebar flex items-center">
                                <img  src="{{asset("images/profile-2user.svg")}}"  class="h-6 w-6" alt="">
                                <span class="ml-2">Рабочие</span>
                            </button>
                        </li>
                    </ul>
                    <div class="login-button mt-auto">
                        <button onclick="window.location.href='login.html'" class="btn-sidebar flex items-center">
                            <img  src="{{asset("images/exit.svg")}}"  class="h-6 w-6" alt="">
                            <span class="ml-2" style="color: #FF6B00;">Войти</span>
                        </button>
                    </div>
                </nav>
            </aside>
