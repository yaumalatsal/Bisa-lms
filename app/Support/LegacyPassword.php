<?php

namespace App\Support;

use Illuminate\Support\Facades\Hash;

/**
 * Verifies passwords against both the modern bcrypt hashes and the two legacy
 * schemes this application shipped with, so existing accounts keep working
 * while their stored hashes are transparently upgraded on the next login.
 *
 * Legacy schemes:
 *   - "siswa"  => md5($password) . sha1($password)   (72 chars, unsalted)
 *   - "mentor" => md5($password)                     (32 chars, unsalted)
 */
class LegacyPassword
{
    public const SCHEME_SISWA = 'siswa';

    public const SCHEME_MENTOR = 'mentor';

    /**
     * Does $plain match $stored, under bcrypt or the given legacy scheme?
     */
    public static function check(string $plain, ?string $stored, string $scheme): bool
    {
        if ($stored === null || $stored === '') {
            return false;
        }

        if (static::isModern($stored)) {
            return Hash::check($plain, $stored);
        }

        return hash_equals($stored, static::legacyHash($plain, $scheme));
    }

    /**
     * True when the stored hash is a modern (bcrypt/argon) hash.
     */
    public static function isModern(string $stored): bool
    {
        return (bool) preg_match('/^\$(2y|2a|2b|argon2i|argon2id)\$/', $stored);
    }

    /**
     * True when the stored hash should be replaced with a bcrypt hash.
     */
    public static function needsRehash(?string $stored): bool
    {
        return $stored === null || $stored === '' || ! static::isModern($stored);
    }

    /**
     * Reproduce a legacy hash. Only used for verification and never for storage.
     */
    public static function legacyHash(string $plain, string $scheme): string
    {
        return $scheme === self::SCHEME_SISWA
            ? md5($plain).sha1($plain)
            : md5($plain);
    }
}
