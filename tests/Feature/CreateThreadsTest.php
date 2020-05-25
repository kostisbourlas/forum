<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * Helper function that signs in
     * and posts a thread with an
     * override attribute.
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function publishThread($overrides = []) {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }

    /**
     * Given we have a signed in user
     * When we hit the endpoint to create a new thread
     * then when we visit the thread page
     * we should see the new thread
     * @test
     */
    function authenticated_user_can_create_new_threads() {

        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    function guests_may_not_create_new_threads() {

//        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    function guest_cannot_see_the_create_threads_page() {

        $this->get('/threads/create')->assertRedirect('/login');
    }

    /** @test */
    function a_thread_requires_a_title() {

        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body() {

        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_channel() {

        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        // gives a non existing in DB channel_id
        // existing channel_ids = [1, 2]
        $this->publishThread(['channel_id' => 42])
            ->assertSessionHasErrors('channel_id');
    }
}
