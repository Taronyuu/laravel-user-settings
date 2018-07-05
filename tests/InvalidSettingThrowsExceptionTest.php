<?php

namespace Internetcode\LaravelUserSettings\Tests;

use Internetcode\LaravelUserSettings\Exceptions\InvalidUserSettingsFieldUsed;

class InvalidSettingThrowsException extends TestCase {

    public function setUp() {
        parent::setUp();
        $this->refreshTestUser();
    }

    /** @test */
    public function invalid_setting_throws_exception()
    {
        $user = $this->testUser;

        try {
            $user->setSetting('invalid_settings_field', true);
        }catch (\Exception $ex){
            $this->assertInstanceOf(InvalidUserSettingsFieldUsed::class, $ex);
        }

        try {
            $user->setting('invalid_settings_field', true);
        }catch (\Exception $ex){
            $this->assertInstanceOf(InvalidUserSettingsFieldUsed::class, $ex);
        }
    }


}
