<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The dashboard is the siswa home page and is now behind auth middleware,
     * so a guest is sent to the login screen rather than being served the page.
     * (This test previously asserted 200, back when the only protection was a
     * client-side redirect in the layout.)
     */
    public function test_the_dashboard_sends_guests_to_the_login_page(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_the_login_page_is_reachable(): void
    {
        $this->get('/login')->assertOk();
    }
}
