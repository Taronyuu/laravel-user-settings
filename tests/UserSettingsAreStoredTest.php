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

}