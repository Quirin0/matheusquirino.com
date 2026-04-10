<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Stack;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class SiteConfigController extends Controller
{
    /** Campos que armazenam paths de storage e precisam ser convertidos para URL pública */
    private const STORAGE_FIELDS = [
        'seo.og_image',
        'seo.twitter_image',
        'site.profile_photo',
    ];

    public function index(): JsonResponse
    {
        $settings = Setting::getAllPublic();
        $stacks   = Stack::where('visible', true)->orderBy('order')->get(['name', 'slug', 'icon_url', 'category', 'color']);

        // Converter paths de storage em URLs absolutas
        foreach (self::STORAGE_FIELDS as $key) {
            if (!empty($settings[$key]) && !str_starts_with($settings[$key], 'http')) {
                $settings[$key] = Storage::disk('public')->exists($settings[$key])
                    ? Storage::disk('public')->url($settings[$key])
                    : null;
            }
        }

        return response()->json([
            'settings' => $settings,
            'stacks'   => $stacks,
        ])->header('Cache-Control', 'public, max-age=300');
    }
}
