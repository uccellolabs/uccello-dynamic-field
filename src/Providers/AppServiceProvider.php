<?php

namespace Uccello\DynamicField\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Uccello\DynamicField\Livewire\DynamicField;

/**
 * App Service Provider
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        // Views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'dynamic-field');

        // Translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'dynamic-field');

        // Publish assets
        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/uccello/dynamic-field'),
        ], 'dynamic-field-assets');

        Livewire::component('dynamic-field', DynamicField::class);
    }

    public function register()
    {
        //
    }
}
