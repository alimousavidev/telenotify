# TeleNotify

TeleNotify is a Laravel notification channel for sending messages via Telegram bots.

## Installation

You can install the package via composer:

```bash
composer require alimousavi/telenotify
```

Optionally, you can publish the configuration file:

```bash
php artisan vendor:publish --provider="AliMousavi\TeleNotify\TeleNotifyServiceProvider"
```

This will publish a configuration file named `telenotify.php` where you can set your Telegram bot API token.

## Usage

### Step 1: Add Telegram Bot Token

Add your Telegram bot token to your `.env` file:

```dotenv
TELEGRAM_BOT_API_TOKEN=your-bot-api-token
```

### Step 2: Implement TeleNotifiable Interface

Your notifiable model (e.g., User, Employee) should implement the `TeleNotifiable` interface and provide a method `getTelegramChatId()`:

```php
use Alimousavi\TeleNotify\Contracts\TeleNotifiableInterface;

class User implements TeleNotifiableInterface
{
    // ...

    public function getTelegramChatId(): string|int|null
    {
        return $this->telegram_chat_id;
    }
}
```


### Note: Using TeleNotifiable Trait

If your notifiable model already has a `telegram_chat_id` property, you can simplify implementation by using the `TeleNotifiable` trait:

```php
use Alimousavi\TeleNotify\Contracts\TeleNotifiableInterface;
use Alimousavi\TeleNotify\Traits\TeleNotifiable;

class User implements TeleNotifiableInterface
{
    use TeleNotifiable;

    // ...
}
```

Using the trait is optional but recommended if your notifiable model includes the `telegram_chat_id` property to adhere to the `TeleNotifiableInterface` requirements.


### Step 3: Use TelegramChannel in Notifications

In your notification class, use the `TelegramChannel::class` in the `via()` method and implement `toTelegram()` method:

```php
use Illuminate\Notifications\Notification;
use Alimousavi\TeleNotify\Channels\TelegramChannel;
use Alimousavi\TeleNotify\Contracts\TeleNotifiable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class ExampleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram(TeleNotifiable $notifiable)
    {
        return [
            'text' => 'Hello, this is a test message from TeleNotify!',
        ];
    }
}
```

I highly recommend implementing `ShouldQueue` and using the `Queueable` trait to optimize performance and enhance the responsiveness of your notification system by leveraging Laravel's queueing capabilities.

### Step 4: Example Messages

#### Example 1: Simple Text Message

```php
public function toTelegram(TeleNotifiable $notifiable)
{
    return [
        'text' => 'Hello, this is a simple text message!',
    ];
}
```

#### Example 2: Message with Parse Mode

```php
public function toTelegram(TeleNotifiable $notifiable)
{
    return [
        'text' => 'Hello, this message uses *Markdown* parse mode.',
        'parse_mode' => 'Markdown',
    ];
}
```

#### Example 3: Message with Disable Notification

```php
public function toTelegram(TeleNotifiable $notifiable)
{
    return [
        'text' => 'Hello, this message will not trigger a notification.',
        'disable_notification' => true,
    ];
}
```

For more customization options, refer to [Telegram Bot API documentation](https://core.telegram.org/bots/api#sendmessage).

## Contributing

Contributions are welcome!

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
