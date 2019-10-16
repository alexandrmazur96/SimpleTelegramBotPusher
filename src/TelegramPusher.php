<?php

namespace AlexandrMazur;

use AlexandrMazur\Utils\Curl;
use RuntimeException;

class TelegramPusher
{
    const BOT_API = 'https://api.telegram.org/bot';

    /**
     * Telegram bot access token provided by BotFather.
     * Create telegram bot with https://telegram.me/BotFather and use access token from it.
     * @var string
     */
    private $apiKey;

    /**
     * @param string $apiKey Telegram bot access token provided by BotFather
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $action
     * @param array $requestParameters
     * @return array
     * @throws Exceptions\CurlException
     */
    public function request($action, array $requestParameters)
    {
        $ch = curl_init();
        $url = self::BOT_API . $this->apiKey . '/' . $action;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestParameters));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $curlResponse = Curl::execute($ch);

        $curlResponse = json_decode($curlResponse, true);

        if ($curlResponse === null || $curlResponse['ok'] === false) {
            throw new RuntimeException('Telegram API error. Description: ' . $curlResponse['description']);
        }

        return $curlResponse;
    }
}
