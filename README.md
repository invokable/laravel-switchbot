# SwitchBot API for Laravel

This package provides a simple integration with the SwitchBot API using Laravel's HTTP client macros.

For specific API details, please refer to the official SwitchBot API repository: https://github.com/OpenWonderLabs/SwitchBotAPI

[![Ask DeepWiki](https://deepwiki.com/badge.svg)](https://deepwiki.com/invokable/laravel-switchbot)

## Requirements

- PHP >= 8.2
- Laravel >= 11.0

## Installation

```shell
composer require revolution/laravel-switchbot
```

## Configuration

Get tokens from the SwitchBot app.

### .env

```
SWITCHBOT_TOKEN=
SWITCHBOT_SECRET=
```

## Usage

Built as a Laravel HTTP client macro.

```php
use Illuminate\Support\Facades\Http;

$response = Http::switchbot()->get('devices');

dump($response->json());

$deviceId = $response->json('body.deviceList.0.deviceId');
if (filled($deviceId)) {
    $response = Http::switchbot()->get("devices/$deviceId/status");
    dump($response->json());
}
```

```php
use Illuminate\Support\Facades\Http;

$response = Http::switchbot()->get('scenes');
dump($response->json());
```

## Testing

```php
use Illuminate\Support\Facades\Http;

Http::fake([
    '*' => Http::response([
        "statusCode" => 100,
        "body" => [
            "deviceList" => [],
            "infraredRemoteList" => [],
        ],
        "message" => "success",
   ]),
]);

$response = Http::switchbot()->get('devices');

$this->assertSame(100, $response->json('statusCode'));
```

## LICENSE

MIT
