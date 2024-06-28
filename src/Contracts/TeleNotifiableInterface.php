<?php
namespace AliMousavi\TeleNotify\Contracts;

interface TeleNotifiableInterface
{
    public function getTelegramChatId(): string|int|null;
}
