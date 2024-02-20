# SwitchBot API for Laravel
[![tests](https://github.com/kawax/laravel-switchbot/actions/workflows/tests.yml/badge.svg)](https://github.com/kawax/laravel-switchbot/actions/workflows/tests.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/8a2ae5fa922fa7fc7ad6/maintainability)](https://codeclimate.com/github/kawax/laravel-switchbot/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/8a2ae5fa922fa7fc7ad6/test_coverage)](https://codeclimate.com/github/kawax/laravel-switchbot/test_coverage)

https://github.com/OpenWonderLabs/SwitchBotAPI

## Requirements

- PHP >= 8.1
- Laravel >= 10.0

## Versioning

- Basic : semver
- Drop old PHP or Laravel version : `+0.1`
- Support only latest major version (`main` branch)

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
