<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The stock Laravel error pages are unstyled Symfony defaults; a 403 or 404
 * looked like the application had crashed. These assert the branded ones render.
 */
class ErrorPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_missing_page_renders_the_branded_404(): void
    {
        $response = $this->get('/tidak-ada-halaman-ini');

        $response->assertNotFound();
        $response->assertSee('Halaman tidak ditemukan');
        $response->assertSee('bisa.css', escape: false);
    }

    /** @test */
    public function the_error_pages_all_render(): void
    {
        foreach (['401', '403', '404', '419', '429', '500', '503'] as $code) {
            $html = view("errors.$code")->render();

            $this->assertStringContainsString($code, $html, "errors/$code failed to render");
            $this->assertStringContainsString('error__card', $html);
        }
    }

    /** @test */
    public function a_guest_is_pointed_at_the_login_page(): void
    {
        $this->get('/tidak-ada')->assertSee('Ke halaman masuk');
    }
}
