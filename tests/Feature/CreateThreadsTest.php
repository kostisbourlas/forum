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
     * Given we have a signed in user
     * When we hit the endpoint to create a new thread
     * then when we visit the thread page
     * we should see the new thread
     * @test
     */
    function authenticated_user_can_create_new_threads() {

        $this->signIn();

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());

        $respose = $this->get($thread->path());

        $respose->assertSee($thread->title)->assertSee($thread->body);
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
}
