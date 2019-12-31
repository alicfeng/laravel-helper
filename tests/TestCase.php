<?php

/*
 * What samego team is that is 'one thing, a team, work together'
 * Value comes from technology, technology comes from sharing~
 * https://github.com/alicfeng/laravel-helper
 * AlicFeng | a@samego.com
 */

namespace Tests;

use AlicFeng\Helper\ServiceProvider\HelperServiceProvider;
use Orchestra\Testbench\TestCase as BaseBaseTestCase;

abstract class TestCase extends BaseBaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [HelperServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
    }
}
