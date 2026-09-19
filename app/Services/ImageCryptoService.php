<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Encrypts uploaded ID front/back photos and selfies before saving them to
 * disk, and decrypts them on the fly for viewing. Uses Laravel's built-in
 * Crypt facade (AES-256-CBC, keyed off APP_KEY in .env) so no extra crypto
 * setup is needed — this is the Laravel equivalent of the crypto.php
 * AES-256 helper used in the XAMPP/PHP version of REDFLOW.
 */
class ImageCryptoService
{
    /**
     * Accepts a base64 data URL (e.g. "data:image/png;base64,....") as sent
     * by the signup wizard / camera capture / file upload inputs, encrypts
     * the raw bytes, and stores them on the private "secure" disk.
     *
     * @return string|null The stored (encrypted) file path, or null if no image was provided.
     */
    public function storeEncrypted(?string $base64DataUrl, string $folder): ?string
    {
        if (empty($base64DataUrl)) {
            return null;
        }

        if (str_contains($base64DataUrl, ',')) {
            [, $base64DataUrl] = explode(',', $base64DataUrl, 2);
        }

        $rawBytes = base64_decode($base64DataUrl, true);
        if ($rawBytes === false) {
            return null;
        }

        $encrypted = Crypt::encrypt($rawBytes);
        $path = trim($folder, '/') . '/' . Str::uuid() . '.enc';
        Storage::disk('secure')->put($path, $encrypted);

        return $path;
    }

    /**
     * Decrypts a stored image back to raw bytes for display (used by the
     * admin Approval & Verification photo zoom modal, and profile avatars).
     */
    public function decrypt(string $storedPath): ?string
    {
        if (!Storage::disk('secure')->exists($storedPath)) {
            return null;
        }

        try {
            return Crypt::decrypt(Storage::disk('secure')->get($storedPath));
        } catch (\Exception $e) {
            return null;
        }
    }
}
