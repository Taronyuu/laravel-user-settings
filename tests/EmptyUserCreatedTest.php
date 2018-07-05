<?php

namespace Internetcode\LaravelUserSettings\Tests;

use Internetcode\LaravelUserSettings\Helpers\BitwiseConverter;

class BitwiseSettingsListGeneratedTest extends TestCase {

    public function setUp() {
        parent::setUp();
        $this->refreshTestUser();
    }

    /** @test */
    public function validate_generated_bitwise_list()
    {
        $user   = $this->testUser;
        $config = $user->getSettingFields();

        $this->assertTrue(count($config) === 3);

        $bitwiseList = BitwiseConverter::arrayToBitwiseList($config);

        $this->assertTrue(count($bitwiseList) === 3);

        $this->assertEquals(2, $bitwiseList['test_setting']);
        $this->assertEquals(4, $bitwiseList['test_setting_2']);
        $this->assertEquals(8, $bitwiseList['test_setting_3']);
    }
}