<?php

namespace AliMousavi\TeleNotify\Channels;
use AliMousavi\TeleNotify\Contracts\TeleNotifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class TelegramChannel
{
    public function __construct(private Http $client)
    {
    }

    public function send(TeleNotifiable $notifiable, Notification $notification)
    {
        if (is_callable($notifiable, 'toTelegram')) {
            return;
        }

        if (!($token = config('telenotify.telegram_bot_api_token'))) {
            return;
        }
        
        if (!$notifiable->getTelegramChatId()) {
            return;
        }

        $message = $notification->toTelegram($notifiable);
        $this->client::post("https://api.telegram.org/bot{$token}/sendMessage", array_merge($message, [
            'chat_id' => $notifiable->getTelegramChatId(),
        ]));
    }
}
