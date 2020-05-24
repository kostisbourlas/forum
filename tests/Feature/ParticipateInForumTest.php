<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * Given we have an authenticated user
     * and an existing thread
     * When the user adds a reply to the thread
     * then their reply should be visible on the page.
     * @test
     */
    function an_authenticated_user_may_participate_in_forum_threads() {

        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make();

        $this->post($thread->path().'/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }


    /** @test */
    function unauthenticated_users_may_not_add_replies() {

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies', []);

    }
}
