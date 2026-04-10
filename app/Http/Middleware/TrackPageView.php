<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    // Extensões que não devem ser contadas como page views
    private const SKIP_EXTENSIONS = [
        'js', 'css', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico',
        'woff', 'woff2', 'ttf', 'eot', 'map', 'json', 'txt', 'xml',
        'webp', 'avif', 'pdf',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldTrack($request, $response)) {
            $path = $this->normalizePath($request->path());
            PageView::record($path);
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (!$response->isSuccessful()) {
            return false;
        }

        $path = $request->path();
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if ($extension && in_array(strtolower($extension), self::SKIP_EXTENSIONS)) {
            return false;
        }

        // Não rastreia admin, api, livewire ou assets internos
        $skipPrefixes = ['admin', 'api', 'livewire', 'sanctum', 'storage', 'up'];
        foreach ($skipPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return false;
            }
        }

        if (str_contains($path, '_next') || str_contains($path, '__')) {
            return false;
        }

        return true;
    }

    private function normalizePath(string $path): string
    {
        $path = '/' . ltrim($path, '/');
        // Simplifica: agrupa /frontend/* como /frontend
        if (str_starts_with($path, '/frontend/projetos/')) {
            return '/frontend/projetos';
        }
        return $path;
    }
}
