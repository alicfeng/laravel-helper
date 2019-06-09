<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace AlicFeng\Helper\ServiceProvider;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../../config/helper.php', 'helper');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../../resources/views', 'helper');
        $this->publishConfig();
        $this->registerRoute();
    }

    public function publishConfig()
    {
        $this->publishes(
            [
                __DIR__.'/../../../config/helper.php' => config_path('helper.php'),
                __DIR__.'/../../../resources/views'   => resource_path('views/helper'),
                __DIR__.'/../../../resources/js'      => public_path('js/helper'),
                __DIR__.'/../../../resources/css'     => public_path('css/helper'),
            ],
            'samego-helper'
        );
    }

    public function registerRoute()
    {
        $routeConfig = [
            'namespace' => 'AlicFeng\Helper\Controller',
            'prefix'    => 'helper',
        ];
        $this->getRouter()->group($routeConfig, function (Router $router) {
            // html page get
            $router->get('decrypt', [
                'uses' => 'CryptController@index',
                'as'   => 'decrypt',
            ])->name('helper.decrypt.view');

            // decrypt interface
            $router->post('decrypt', [
                'uses' => 'CryptController@decrypt',
                'as'   => 'decrypt',
            ])->name('helper.decrypt.validate');
        });
    }

    /**
     * Get the active router.
     *
     * @return Route Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }
}
