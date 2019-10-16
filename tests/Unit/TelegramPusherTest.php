<?php

namespace AlexandrMazur\Tests\Unit;

use AlexandrMazur\TelegramPusher;
use AlexandrMazur\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class TelegramPusherTest extends TestCase
{
    /** @var MockObject<TelegramPusher> */
    private $tgPusher;

    /** @var string */
    private $channel;

    /**
     * @test
     * @return void
     */
    public function requestSimpleActions()
    {
        $this->tgPusher->call('SendMessage', [
            'text' => '*Test* message',
            'chat_id' => $this->channel,
            'parse_mode' => 'Markdown',
        ]);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->channel = '@testchannel';
        $constructorArgs = ['test_api_key'];
        $this->tgPusher = $this->getMockBuilder(TelegramPusher::class)
            ->setConstructorArgs($constructorArgs)
            ->setMethods(['initCurlHandle', 'request'])
            ->getMock();

        $this->tgPusher
            ->expects($this->atLeast(1))
            ->method('initCurlHandle');

        $this->tgPusher
            ->expects($this->atLeast(1))
            ->method('request');
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->tgPusher = null;
        $this->channel = null;
    }
}
