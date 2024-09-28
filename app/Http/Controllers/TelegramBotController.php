<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationPrice;
use App\Models\Client;
use App\Models\Service;
use App\Models\CompanyOffice;
use Illuminate\Http\Request as HttpRequest;

class TelegramBotController extends Controller
{
    protected $apiURL;
    protected $offset = 0;
    protected $registrationStep = [];
    protected $userInfo = [];
    protected $userRequest = [];
    protected $requestStep = [];

    public function __construct()
    {
        $this->apiURL = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN');
    }

    public function handle()
    {
        while (true) {
            $updates = $this->getUpdates($this->offset);

            if (!empty($updates['result'])) {
                foreach ($updates['result'] as $update) {
                    $this->offset = $update['update_id'] + 1;
                    $this->processUpdate($update);
                }
            }

            sleep(2);
        }

        return response()->json(['status' => 'Long polling running']);
    }

    protected function getUpdates($offset)
    {
        $url = "$this->apiURL/getUpdates?offset=$offset";
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

    protected function processUpdate($update)
    {
        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];

            // Проверяем наличие текста в сообщении
            if (isset($update['message']['text'])) {
                $message = $update['message']['text'];

                // Обработка команды /start
                if (trim($message) == '/start') {
                    $this->sendMessage($chatId, "Добро пожаловать! Давайте начнем с регистрации или создания заявки.");
                    unset($this->registrationStep[$chatId]);
                    unset($this->userInfo[$chatId]);
                    unset($this->userRequest[$chatId]);
                    unset($this->requestStep[$chatId]);
                    $this->sendServiceSelection($chatId);
                    return;
                }

                // Обработка команды /myrequests
                if (trim($message) == '/myrequests') {
                    $this->sendMyRequests($chatId);
                    return;
                }

                // Проверяем, есть ли клиент в базе данных
                $user = Client::where('tg_id', $chatId)->first();

                if (!$user) {
                    // Регистрация пользователя
                    if (!isset($this->registrationStep[$chatId])) {
                        $this->sendMessage($chatId, "Введите ваше имя:");
                        $this->registrationStep[$chatId] = 'name';
                    } elseif ($this->registrationStep[$chatId] == 'name') {
                        if (empty(trim($message))) {
                            $this->sendMessage($chatId, "Имя не может быть пустым. Пожалуйста, введите ваше имя:");
                            return;
                        }
                        $this->userInfo[$chatId]['name'] = $message;
                        $this->sendMessage($chatId, "Введите ваш номер телефона:");
                        $this->registrationStep[$chatId] = 'phone';
                    } elseif ($this->registrationStep[$chatId] == 'phone') {
                        if (empty(trim($message))) {
                            $this->sendMessage($chatId, "Номер телефона не может быть пустым. Пожалуйста, введите ваш номер телефона:");
                            return;
                        }
                        // Создание клиента после получения имени и телефона
                        Client::create([
                            'tg_id' => $chatId,
                            'name' => $this->userInfo[$chatId]['name'],
                            'phone_number' => $message,
                            'company_id' => 1
                        ]);

                        $this->sendMessage($chatId, "Вы зарегистрированы! Теперь выберите услугу.");
                        unset($this->registrationStep[$chatId]);
                        unset($this->userInfo[$chatId]);

                        $this->sendServiceSelection($chatId);
                    }
                } else {
                    if (isset($this->requestStep[$chatId])) {
                        if ($this->requestStep[$chatId] == 'service') {
                            if (empty(trim($message))) {
                                $this->sendMessage($chatId, "Услуга не может быть пустой. Пожалуйста, выберите услугу:");
                                return;
                            }
                            // Сохраняем выбранную услугу
                            $this->userRequest[$chatId]['service_id'] = $message;
                            $this->sendMessage($chatId, "Введите ваш адрес:");
                            $this->requestStep[$chatId] = 'address';
                        } elseif ($this->requestStep[$chatId] == 'address') {
                            if (empty(trim($message))) {
                                $this->sendMessage($chatId, "Адрес не может быть пустым. Пожалуйста, введите ваш адрес:");
                                return;
                            }
                            // Сохраняем адрес и продолжаем выбор офиса
                            $this->userRequest[$chatId]['address'] = $message;
                            $this->sendOfficeSelection($chatId);
                            $this->requestStep[$chatId] = 'office';
                        } elseif ($this->requestStep[$chatId] == 'office') {
                            if (empty(trim($message))) {
                                $this->sendMessage($chatId, "Офис не может быть пустым. Пожалуйста, выберите офис:");
                                return;
                            }
                            // Сохраняем офис и создаем заявку
                            $this->userRequest[$chatId]['office_id'] = $message;

                            // Проверяем, что все данные перед сохранением корректны
                            if (!isset($this->userRequest[$chatId]['service_id']) || !isset($this->userRequest[$chatId]['office_id'])) {
                                $this->sendMessage($chatId, "Произошла ошибка. Убедитесь, что выбрана услуга и офис.");
                                return;
                            }

                            $this->saveRequest($chatId, $user->id);
                            $this->sendMessage($chatId, "Ваша заявка успешно создана! Вы можете создать новую заявку или посмотреть существующие, используя команду /myrequests");

                            // Сброс всех данных после успешного завершения заявки
                            unset($this->requestStep[$chatId]);
                            unset($this->userRequest[$chatId]);
                        }
                    } else {
                        // Начало создания заявки с выбора услуги
                        $this->sendServiceSelection($chatId);
                        $this->requestStep[$chatId] = 'service';
                    }
                }
            }
        } elseif (isset($update['callback_query'])) {
            $chatId = $update['callback_query']['message']['chat']['id'];
            $data = $update['callback_query']['data'];

            // Обработка выбора услуги
            if (strpos($data, 'service_') === 0) {
                $this->userRequest[$chatId]['service_id'] = str_replace('service_', '', $data);
                $this->sendMessage($chatId, "Введите ваш адрес:");
                $this->requestStep[$chatId] = 'address';
            }
            // Обработка выбора офиса
            elseif (strpos($data, 'office_') === 0) {
                $this->userRequest[$chatId]['office_id'] = str_replace('office_', '', $data);

                // Проверяем, что все данные перед сохранением корректны
                if (!isset($this->userRequest[$chatId]['service_id']) || !isset($this->userRequest[$chatId]['office_id'])) {
                    $this->sendMessage($chatId, "Произошла ошибка. Убедитесь, что выбрана услуга и офис.");
                    return;
                }

                $this->saveRequest($chatId, Client::where('tg_id', $chatId)->first()->id);
                $this->sendMessage($chatId, "Ваша заявка успешно создана! Вы можете создать новую заявку или посмотреть существующие, используя команду /myrequests");
            }
        }
    }

    protected function sendMessage($chatId, $message)
    {
        $url = "$this->apiURL/sendMessage";
        $postData = [
            'chat_id' => $chatId,
            'text' => $message,
        ];

        $this->sendRequest($url, $postData);
    }

    protected function sendServiceSelection($chatId)
    {
        // Получаем список услуг из базы данных
        $services = Service::all();

        // Создаем инлайн-клавиатуру с услугами
        $keyboard = [
            'inline_keyboard' => $services->map(function ($service) {
                return [['text' => $service->name, 'callback_data' => 'service_' . $service->id]];
            })->toArray()
        ];

        $url = "$this->apiURL/sendMessage";
        $postData = [
            'chat_id' => $chatId,
            'text' => 'Выберите услугу:',
            'reply_markup' => json_encode($keyboard),
        ];

        $this->sendRequest($url, $postData);
    }

    protected function sendOfficeSelection($chatId)
    {
        // Получаем список офисов из базы данных
        $offices = CompanyOffice::all();

        // Создаем инлайн-клавиатуру с офисами
        $keyboard = [
            'inline_keyboard' => $offices->map(function ($office) {
                return [['text' => $office->name, 'callback_data' => 'office_' . $office->id]];
            })->toArray()
        ];

        $url = "$this->apiURL/sendMessage";
        $postData = [
            'chat_id' => $chatId,
            'text' => 'Выберите офис:',
            'reply_markup' => json_encode($keyboard),
        ];

        $this->sendRequest($url, $postData);
    }

    protected function saveRequest($chatId, $userId)
    {
        // Сохранение заявки в базе данных
        $application =  Application::create([
            'client_id' => $userId,
            'service_id' => $this->userRequest[$chatId]['service_id'],
            'company_office_id' => $this->userRequest[$chatId]['office_id'],
            'address' => $this->userRequest[$chatId]['address']
        ]);

        ApplicationPrice::create([
            "application_id" => $application->id,
            "price" => $application->service->price,
        ]);
    }

    // Функция для отображения заявок пользователя
    protected function sendMyRequests($chatId)
    {
        // Найдем пользователя по его Telegram ID
        $user = Client::where('tg_id', $chatId)->first();

        if (!$user) {
            $this->sendMessage($chatId, "У вас нет заявок.");
            return;
        }

        // Получим все заявки пользователя
        $applications = Application::where('client_id', $user->id)->get();

        if ($applications->isEmpty()) {
            $this->sendMessage($chatId, "У вас нет заявок.");
        } else {
            foreach ($applications as $application) {
                $service = Service::find($application->service_id);
                $office = CompanyOffice::find($application->company_office_id);
                $price = $application->applicationPrices->first()->price;

                // Форматируем сообщение без спецсимволов
                $message = "🔔 Заявка №{$application->id}\n";
                $message .= "━━━━━━━━━━━━━━━━━━━━\n";
                $message .= "🛠 Услуга: {$service->name}\n";
                $message .= "🏢 Офис: {$office->name}\n";
                $message .= "📍 Адрес: {$application->address}\n";
                $message .= "📅 Статус: {$application->status}\n";
                $message .= "💰 Цена: {$price} тг\n";
                $message .= "━━━━━━━━━━━━━━━━━━━━\n";

                // Отправляем каждую заявку отдельным сообщением
                $this->sendMessage($chatId, $message);
            }
        }
    }

    protected function sendRequest($url, $postData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_exec($ch);
        curl_close($ch);
    }
}
