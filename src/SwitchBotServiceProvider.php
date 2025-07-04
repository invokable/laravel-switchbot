<?php

namespace Revolution\SwitchBot;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class SwitchBotServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/switchbot.php',
            'switchbot'
        );
    }

    public function boot(): void
    {
        $this->configurePublishing();

        Http::macro('switchbot', function (): PendingRequest {
            $sign = Signature::make(
                token: config('switchbot.token'),
                secret: config('switchbot.secret'),
                t: $t = now()->timestamp * 1000,
                nonce: $nonce = Str::random()
            );

            return Http::baseUrl(config('switchbot.base_url'))
                ->withToken(config('switchbot.token'))
                ->withHeaders(compact(['sign', 't', 'nonce']));
        });
    }

    /**
     * Configure publishing for the package.
     */
    protected function configurePublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return; // @codeCoverageIgnore
        }

        $this->publishes([
            __DIR__.'/../config/switchbot.php' => $this->app->configPath('switchbot.php'),
        ], 'switchbot-config');
    }
}
