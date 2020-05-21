<?php

namespace Tests;

class BaseTestCase extends \Orchestra\Testbench\TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('vendor:publish --all')->run();
        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }

    protected function getPackageProviders($app)
    {
        return [
            'App\Providers\AppServiceProvider',
            'Laraplus\Form\FormServiceProvider',
            'Intervention\Image\ImageServiceProvider',
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Form' => 'Laraplus\Form\Facades\Form',
            'Image' => 'Intervention\Image\Facades\Image',
            'Flash' => 'Laracasts\Flash\Flash',
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
