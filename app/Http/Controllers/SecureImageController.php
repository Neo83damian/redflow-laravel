<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ImageCryptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SecureImageController extends Controller
{
    protected const FIELD_MAP = [
        'id_front' => 'id_front_path',
        'id_back' => 'id_back_path',
        'face_doc' => 'face_doc_path',
    ];

    /**
     * Decrypts and streams an uploaded ID/selfie image. Only Admins (for
     * approval review) or the owning user themselves may view it.
     */
    public function show(Request $request, int $userId, string $field, ImageCryptoService $crypto)
    {
        if (!isset(self::FIELD_MAP[$field])) {
            abort(404);
        }

        $viewer = Auth::user();
        if (!$viewer || (!$viewer->hasRoleAdmin() && $viewer->id !== $userId)) {
            abort(403);
        }

        $target = User::findOrFail($userId);
        $path = $target->{self::FIELD_MAP[$field]};
        if (!$path) {
            abort(404);
        }

        $bytes = $crypto->decrypt($path);
        if ($bytes === null) {
            abort(404);
        }

        return response($bytes, 200)->header('Content-Type', 'image/jpeg');
    }
}
