<?php

namespace Tests\Unit;

use App\Support\Embed;
use PHPUnit\Framework\TestCase;

/**
 * The "video produk" field used to be rendered with htmlspecialchars_decode(),
 * i.e. as raw HTML, so a student could inject script into every page showing
 * their product. We now only ever emit an iframe we build ourselves.
 */
class EmbedTest extends TestCase
{
    /**
     * @dataProvider youtubeInputs
     */
    public function test_it_extracts_youtube_ids(string $input, ?string $expected): void
    {
        $this->assertSame($expected, Embed::youtubeId($input));
    }

    public static function youtubeInputs(): array
    {
        return [
            'watch url' => ['https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'dQw4w9WgXcQ'],
            'watch url with extra params' => ['https://www.youtube.com/watch?list=X&v=dQw4w9WgXcQ&t=1', 'dQw4w9WgXcQ'],
            'short url' => ['https://youtu.be/dQw4w9WgXcQ', 'dQw4w9WgXcQ'],
            'shorts url' => ['https://www.youtube.com/shorts/dQw4w9WgXcQ', 'dQw4w9WgXcQ'],
            'pasted embed code' => ['<iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ"></iframe>', 'dQw4w9WgXcQ'],
            'bare id' => ['dQw4w9WgXcQ', 'dQw4w9WgXcQ'],
            'unrelated url' => ['https://example.com/video', null],
            'empty' => ['', null],
        ];
    }

    public function test_a_script_payload_never_becomes_an_embed(): void
    {
        $payload = '<script>alert(document.cookie)</script>';

        $this->assertNull(Embed::youtubeId($payload));
        $this->assertNull(Embed::youtubeEmbedUrl($payload));
        $this->assertNull(Embed::safeUrl($payload));
    }

    public function test_embed_urls_use_the_nocookie_host_over_https(): void
    {
        $this->assertSame(
            'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ',
            Embed::youtubeEmbedUrl('https://youtu.be/dQw4w9WgXcQ')
        );
    }

    /**
     * @dataProvider urlInputs
     */
    public function test_safe_url_only_accepts_http_and_https(string $input, ?string $expected): void
    {
        $this->assertSame($expected, Embed::safeUrl($input));
    }

    public static function urlInputs(): array
    {
        return [
            'https' => ['https://figma.com/file/abc', 'https://figma.com/file/abc'],
            'http' => ['http://figma.com/file/abc', 'http://figma.com/file/abc'],
            'javascript scheme' => ['javascript:alert(1)', null],
            'data scheme' => ['data:text/html,<script>alert(1)</script>', null],
            'not a url' => ['just some text', null],
            'empty' => ['', null],
        ];
    }
}
