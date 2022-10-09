<?php

namespace Revolution\SwitchBot;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SwitchBotServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/switchbot.php',
            'switchbot'
        );
    }

    /**
     * @return void
     */
    public function boot()
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
     *
     * @return void
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
