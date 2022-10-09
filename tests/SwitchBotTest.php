<?php

namespace Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class SwitchBotTest extends TestCase
{
    public function test_macro()
    {
        $this->assertTrue(Http::hasMacro('switchbot'));
    }

    public function test_devices()
    {
        Http::fake([
            '*' => Http::response([
                'statusCode' => 100,
                'body' => [
                    'deviceList' => [],
                    'infraredRemoteList' => [],
                ],
                'message' => 'success',
            ]),
        ]);

        $response = Http::switchbot()->get('devices');

        $this->assertSame(100, $response->json('statusCode'));

        Http::assertSent(fn (Request $request) => $request->hasHeader('sign') &&
            $request->hasHeader('t') &&
            $request->hasHeader('nonce') &&
            $request->hasHeader('Authorization') &&
            $request->url() === 'https://api.switch-bot.com/v1.1/devices'
        );
    }
}
