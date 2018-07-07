<?php

namespace Internetcode\LaravelUserSettings\Tests;

class QueryBuilderMacrosAreWorkingTest extends TestCase {

    public function setUp() {
        parent::setUp();
        $this->refreshTestUser();
    }

    /** @test */
    public function where_setting_macro_is_available() {
        $result = (new User())->whereSetting('test_setting')->first();
        $this->assertNull($result);
    }

    /** @test */
    public function where_setting_macro_is_working() {
        $user = $this->testUser;
        $user->setting('test_setting', true);
        $user->setting('test_setting_3', true);
        $user->save();

        $this->assertNotNull(
            (new User())->whereSetting('test_setting')->first()
        );

        $this->assertNull(
            (new User())->whereSetting('test_setting_2')->first()
        );

        $this->assertNotNull(
            (new User())->whereSetting('test_setting_3')->first()
        );

        $this->assertNotNull(
            (new User())->whereSetting('test_setting_3')
                ->whereSetting('test_setting')
                ->first()
        );

        $this->assertNull(
            (new User())->whereSetting('test_setting_3')
                        ->whereSetting('test_setting_2')
                        ->first()
        );

        $user = (new User())->where(function ($query) {
            $query->whereSetting('test_setting');
        })->orWhere(function ($query) {
            $query->whereSetting('test_setting_2');
        })->first();
        $this->assertNotNull($user);
    }

}