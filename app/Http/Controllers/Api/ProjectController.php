<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::orderBy('order')->orderBy('created_at', 'desc')->get()
            ->map(fn (Project $p) => $this->serializeProject($p))
            ->values();

        return response()->json($projects);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'slug'             => 'required|string|unique:projects,slug',
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'full_description' => 'nullable|string',
            'image_url'        => 'nullable|string|max:255',
            'live_url'         => 'nullable|url|max:255',
            'github_url'       => 'nullable|url|max:255',
            'tags'             => 'nullable|array',
            'tags.*'           => 'string',
            'featured'         => 'boolean',
            'order'            => 'integer',
        ]);

        $project = Project::create($validated);

        return response()->json($this->serializeProject($project), 201);
    }

    public function show(Project $project): JsonResponse
    {
        return response()->json($this->serializeProject($project));
    }

    /**
     * @return array<string, mixed>
     */
    private function serializeProject(Project $project): array
    {
        $data = $project->toArray();
        $img  = $data['image_url'] ?? null;

        if (is_array($img)) {
            $img = ! empty($img) ? (string) reset($img) : null;
            $data['image_url'] = $img;
        }

        if (! empty($img) && is_string($img)) {
            $data['image_url'] = $this->absoluteAssetUrl($img);
        } else {
            $data['image_url'] = null;
        }

        $data['tags'] = $this->normalizeTagsForApi($data['tags'] ?? null);

        return $data;
    }

    /**
     * @return list<string>
     */
    private function normalizeTagsForApi(mixed $tags): array
    {
        if ($tags === null || $tags === '') {
            return [];
        }

        if (is_string($tags)) {
            $trim = trim($tags);
            if ($trim === '') {
                return [];
            }
            $decoded = json_decode($trim, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $this->normalizeTagsForApi($decoded);
            }

            return array_values(array_filter(array_map('trim', explode(',', $trim))));
        }

        if (is_array($tags)) {
            $out = [];
            foreach ($tags as $item) {
                if (is_string($item) || is_numeric($item)) {
                    $t = trim((string) $item);
                    if ($t !== '') {
                        $out[] = $t;
                    }

                    continue;
                }
                if (! is_array($item)) {
                    continue;
                }
                foreach (['value', 'name', 'label', 'tag'] as $k) {
                    if (! empty($item[$k]) && is_string($item[$k])) {
                        $t = trim($item[$k]);
                        if ($t !== '') {
                            $out[] = $t;
                        }
                        continue 2;
                    }
                }
                foreach ($this->normalizeTagsForApi($item) as $t) {
                    if ($t !== '') {
                        $out[] = $t;
                    }
                }
            }

            return $out;
        }

        return [];
    }

    /**
     * URL absoluta para o front (Next/Image e SPA em subpastas não quebram).
     */
    private function absoluteAssetUrl(string $path): string
    {
        $path = trim($path);
        if ($path === '') {
            return $path;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        if (str_starts_with($path, '/')) {
            return url($path);
        }

        return url(Storage::disk('public')->url($path));
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'slug'             => 'sometimes|string|unique:projects,slug,' . $project->id,
            'title'            => 'sometimes|string|max:255',
            'description'      => 'sometimes|string',
            'full_description' => 'nullable|string',
            'image_url'        => 'nullable|string|max:255',
            'live_url'         => 'nullable|url|max:255',
            'github_url'       => 'nullable|url|max:255',
            'tags'             => 'nullable|array',
            'tags.*'           => 'string',
            'featured'         => 'boolean',
            'order'            => 'integer',
        ]);

        $project->update($validated);

        return response()->json($this->serializeProject($project->fresh()));
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json(null, 204);
    }
}
