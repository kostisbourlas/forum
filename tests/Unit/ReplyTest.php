<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase {

    use DatabaseMigrations;

    /**
     * Tests whether a reply belongs to a user
     * @test
     */
    function reply_has_an_owner() {

        $reply = factory('App\Reply')->create();

        $this->assertInstanceOf('App\User', $reply->owner);
    }
}
