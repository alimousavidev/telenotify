<?php

namespace AliMousavi\TeleNotify\Traits;

trait TeleNotifiable
{
    public function getTelegramChatId(): string|int|null
    {
        return $this->telegram_chat_id;
    }
    
}