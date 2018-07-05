<?php

namespace Internetcode\LaravelUserSettings\Tests;

use Illuminate\Database\Schema\Blueprint;
use Internetcode\LaravelUserSettings\LaravelUserSettingsServiceProvider;
use Internetcode\LaravelUserSettings\Tests\User;
use Orchestra\Testbench\TestCase as Orchestra;


abstract class TestCase extends Orchestra {

    /** @var User */
    protected $testUser;

    public function setUp()
    {
        parent::setUp();
        $this->setUpDatabase($this->app);

        $this->testUser = (new User())->first();
    }
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelUserSettingsServiceProvider::class,
        ];
    }
    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('view.paths', [__DIR__.'/resources/views']);
        $app['config']->set('user-settings.setting_fields', [
            'test_setting',
            'test_setting_2',
            'test_setting_3',
        ]);
    }
    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->timestamps();
        });
        include_once __DIR__.'/../database/migrations/default_add_settings_column_to_users_table.php';
        (new \AddSettingsColumnToUsersTable())->up();
        (new User())->create(['email' => 'test@user.com']);
    }

    /**
     * Refresh the testUser.
     */
    public function refreshTestUser()
    {
        $this->testUser = $this->testUser->fresh();
    }
}