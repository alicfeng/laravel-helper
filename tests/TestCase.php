<?php
/**
 * Created by AlicFeng at 2019-06-08 21:11
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
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {

    }
}
