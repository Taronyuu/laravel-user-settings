<?php

namespace Internetcode\LaravelUserSettings\Tests;

class EmptyUserCreatedTest extends TestCase {

    public function setUp() {
        parent::setUp();
        $this->refreshTestUser();
    }

    /** @test */
    public function an_empty_user_exists()
    {
        $this->assertNotNull($this->testUser);
        $this->assertEquals(0, $this->testUser->settings);
    }

}