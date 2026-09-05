<?php

namespace App\Support;

/**
 * Turns the "video produk" field into something safe to render.
 *
 * Students paste whatever they have — a YouTube link, a share link, or a full
 * <iframe> embed copied from YouTube. The views used to render that field with
 * `htmlspecialchars_decode()`, i.e. as raw HTML, so any student could inject
 * script into every page that displayed their product.
 *
 * We now extract a video id and build the iframe ourselves; anything we cannot
 * recognise is shown as plain text.
 */
class Embed
{
    /**
     * Extract a YouTube video id from a URL or a pasted embed snippet.
     */
    public static function youtubeId(?string $input): ?string
    {
        if (! $input) {
            return null;
        }

        $patterns = [
            '~youtube\.com/embed/([A-Za-z0-9_-]{11})~i',
            '~youtube\.com/watch\?(?:.*&)?v=([A-Za-z0-9_-]{11})~i',
            '~youtube\.com/shorts/([A-Za-z0-9_-]{11})~i',
            '~youtu\.be/([A-Za-z0-9_-]{11})~i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input, $matches)) {
                return $matches[1];
            }
        }

        // A bare id on its own.
        $trimmed = trim($input);
        if (preg_match('~^[A-Za-z0-9_-]{11}$~', $trimmed)) {
            return $trimmed;
        }

        return null;
    }

    /**
     * The https URL to embed, or null when we do not recognise the input.
     */
    public static function youtubeEmbedUrl(?string $input): ?string
    {
        $id = static::youtubeId($input);

        return $id ? "https://www.youtube-nocookie.com/embed/{$id}" : null;
    }

    /**
     * A plain http(s) link we are willing to render as an anchor.
     */
    public static function safeUrl(?string $input): ?string
    {
        $url = trim((string) $input);

        if ($url === '' || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        return in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true) ? $url : null;
    }
}
