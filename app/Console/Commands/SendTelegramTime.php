<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendTelegramTime extends Command
{
    protected $signature = 'telegram:send-time';

    protected $description = 'Send the current time to Telegram';

    public function handle(): int
    {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (! $token || ! $chatId) {
            $this->error('TELEGRAM_BOT_TOKEN or TELEGRAM_CHAT_ID is not set in .env');

            return self::FAILURE;
        }

        $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => 'Current time: '.now()->format('Y-m-d H:i:s'),
        ]);

        if ($response->failed()) {
            $this->error('Failed to send Telegram message: '.$response->body());

            return self::FAILURE;
        }

        $this->info('Telegram message sent.');

        return self::SUCCESS;
    }
}
