<?php

namespace AlexandrMazur;

use AlexandrMazur\Exceptions\CurlException;
use AlexandrMazur\Exceptions\TelegramBotApiException;
use AlexandrMazur\Utils\Curl;

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
     * Call given telegram action with given parameters.
     * @param string $action
     * @param array $actionParameters
     * @return array
     * @throws Exceptions\CurlException
     * @throws TelegramBotApiException
     */
    public function call($action, array $actionParameters)
    {
        $curlHandle = $this->initCurlHandle($action, $actionParameters);

        if ($curlHandle === false) {
            throw new CurlException('Unable to initiate curl handle');
        }

        return $this->request($curlHandle);
    }

    /**
     * Create and initiate curl handle resource.
     * @param string $action
     * @param array $requestParameters
     * @return false|resource
     */
    protected function initCurlHandle($action, array $requestParameters)
    {
        $curlHandle = curl_init();
        $url = self::BOT_API . $this->apiKey . '/' . $action;
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($requestParameters));
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        return $curlHandle;
    }

    /**
     * Make request to Telegram Bot API.
     * @param resource $curlHandle
     * @return array with response from Telegram Bot API.
     * @throws Exceptions\CurlException
     * @throws TelegramBotApiException
     */
    protected function request($curlHandle)
    {
        $curlResponse = Curl::execute($curlHandle);

        $curlResponse = json_decode($curlResponse, true);

        if ($curlResponse === null || $curlResponse['ok'] === false) {
            throw new TelegramBotApiException('Telegram API error. Description: ' . $curlResponse['description']);
        }

        return $curlResponse;
    }
}
