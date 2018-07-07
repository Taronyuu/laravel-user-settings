<?php

namespace Internetcode\LaravelUserSettings\Tests;

class UserSettingsAreStored extends TestCase {

    public function setUp() {
        parent::setUp();
        $this->refreshTestUser();
    }

    /** @test */
    public function settings_are_stored()
    {
        $user = $this->testUser;

        $this->assertFalse($user->setting('test_setting'));
        $this->assertFalse($user->getSetting('test_setting'));

        $user->setting('test_setting', true);
        $this->assertTrue($user->setting('test_setting'));
        $this->assertTrue($user->getSetting('test_setting'));

        $user->setting('test_setting', false);
        $this->assertFalse($user->setting('test_setting'));
        $this->assertFalse($user->getSetting('test_setting'));

        $user->save();
        $this->refreshTestUser();
        $user = $this->testUser;

        $this->assertFalse($user->setting('test_setting'));
        $this->assertFalse($user->getSetting('test_setting'));

        $user->setting('test_setting', true);
        $this->assertTrue($user->setting('test_setting'));
        $this->assertTrue($user->getSetting('test_setting'));

        $user->setting('test_setting', false);
        $this->assertFalse($user->setting('test_setting'));
        $this->assertFalse($user->getSetting('test_setting'));

        $user->setSetting('test_setting', true);
        $user->save();
        $this->refreshTestUser();
        $this->assertTrue($this->testUser->getSetting('test_setting'));
    }

    /** @test */
    public function array_settings_are_stored()
    {
        $user = $this->testUser;

        $user->setMultipleSettings([
            'test_setting'      => true,
            'test_setting_2'    => false,
        ]);
        $user->save();

        $this->assertTrue($user->setting('test_setting'));
        $this->assertFalse($user->setting('test_setting_2'));
        $this->assertFalse($user->setting('test_setting_3'));
    }

    /** @test */
    public function default_values_are_returned()
    {
        $user = $this->testUser;

        $this->assertFalse($user->getSetting('test_setting_3'));
        $this->assertEquals('test_return_value', $user->getSetting('test_setting_3', 'test_return_value'));
    }

}