<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Sets up helper method creating a thread.
     */
    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /**
     * Checks if the below url returns the threads titles.
     * @test
     */
    public function a_user_can_view_all_threads() {

        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    /**
     * Checks if the below url returns the single thread title
     * @test
     */
    public function a_user_can_view_a_single_thread() {

        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    /**
     * Given we have a thread that includes Replies,
     * We Should see the replies when we visit that thread.
     * @test
     */
    function a_user_can_read_replies_that_are_associated_with_a_thread() {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path());
        $response->assertSee($reply->body);
    }

    /** @test */
    function a_user_can_filter_threads_according_to_a_channel() {

        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title  );
    }

    /** @test */
    function a_user_can_filter_threads_by_any_username() {

        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohnDoe = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohnDoe = create('App\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohnDoe->title)
            ->assertDontSee($threadNotByJohnDoe->title);
    }
}
