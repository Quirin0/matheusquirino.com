<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::orderBy('order')->orderBy('created_at', 'desc')->get();

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

        return response()->json($project, 201);
    }

    public function show(Project $project): JsonResponse
    {
        return response()->json($project);
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

        return response()->json($project);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json(null, 204);
    }
}
