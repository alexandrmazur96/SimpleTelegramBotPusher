Telegram me.
---

Telme is lightweight simple pusher to telegram bot.

## Installation

`$ composer require telme/telme`

## Usage

```$php
<?php

use AlexandrMazur\TelegramPusher;

$telegramApiKey = 'telegram_api_key';

$pusher = new TelegramPusher($telegramApiKey);

try {
    $response = $pusher->call('SendMessage', [
        'chat_id' => '@testchat',
        'text' => '*Example* text',
        'parse_mode' => 'Markdown',
    ]);
} catch (AlexandrMazur\Exceptions\CurlException | AlexandrMazur\Exceptions\TelegramBotApiException $e) {
    echo $e->getMessage(), PHP_EOL;
}

/**
Example response structure:

[
    'ok' => true,
    'result' => [
        'message_id' => 84,
        'chat' => [
            'id' => -1001410394173,
            'title' => 'test_channel',
            'username' => 'testchannel',
            'type' => 'channel',
        ],
        'date' => 1571236539,
        'text' => 'Test message',
        'entities' => [
            [
                'offset' => 0,
                'length' => 4,
                'type' => 'bold',
            ],
        ],
    ],
]
*/

echo $response['result']['text'], PHP_EOL;
```

List of available action and parameters you can find [here](https://core.telegram.org/bots/api#available-methods).

### Author

Mazur Alexandr - alexandrmazur96@gmail.com - https://t.me/alexandrmazur96

### License

SimpleTelegramBotPusher is licensed under the GNU General Public License - see the LICENSE file for details.