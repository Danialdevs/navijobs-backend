<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TelegramBotController;

class RunTelegramBot extends Command
{
    // Название команды
    protected $signature = 'bot:run';

    // Описание команды
    protected $description = 'Запуск long polling для Telegram бота';

    // Контроллер для обработки
    protected $telegramBotController;

    public function __construct(TelegramBotController $telegramBotController)
    {
        parent::__construct();
        $this->telegramBotController = $telegramBotController;
    }

    public function handle()
    {
        // Вызов логики бота через контроллер
        $this->telegramBotController->handle();
    }
}
