<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Stores an uploaded product image (logo, poster) under public/.
 *
 * The previous implementation built the filename from the client-supplied
 * extension and called UploadedFile::move() directly. The poster path did not
 * check the extension at all, so any file — including a .php script — could be
 * written into a directory served by the web server.
 *
 * Here the extension is derived from the detected MIME type against a fixed
 * allow-list, and the basename is random, so nothing user-controlled ends up in
 * the path.
 */
class ProductAssetUploader
{
    /**
     * Detected MIME type => extension we will write.
     */
    private const ALLOWED = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    /**
     * Store the file and return its basename, or null when it is not an
     * image we accept.
     *
     * @param  string  $directory  Relative to public/, e.g. "logo_produk".
     */
    public function store(UploadedFile $file, string $directory): ?string
    {
        if (! $file->isValid()) {
            return null;
        }

        // getMimeType() sniffs the file contents; getClientMimeType() would
        // simply echo back whatever the browser claimed.
        $extension = self::ALLOWED[$file->getMimeType()] ?? null;

        if ($extension === null) {
            return null;
        }

        $name = Str::uuid().'.'.$extension;
        $file->move(public_path($directory), $name);

        return $name;
    }

    /**
     * Delete a previously stored asset. The name must be a bare basename that
     * we generated; anything with a path separator is refused so a crafted
     * database value cannot reach outside the directory.
     */
    public function delete(?string $name, string $directory): void
    {
        if (! $name || $name !== basename($name)) {
            return;
        }

        $path = public_path($directory.DIRECTORY_SEPARATOR.$name);

        if (is_file($path)) {
            @unlink($path);
        }
    }

    /**
     * Validation rules to pair with this uploader.
     *
     * @return array<int, string>
     */
    public static function rules(bool $required = true): array
    {
        return array_filter([
            $required ? 'required' : 'nullable',
            'file',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:4096',
        ]);
    }
}
