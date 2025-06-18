<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::ordered()->get();
        return ExperienceResource::collection($experiences);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'string',
            'display_order' => 'integer'
        ]);

        $experience = Experience::create($validated);
        return new ExperienceResource($experience);
    }

    public function show(Experience $experience)
    {
        return new ExperienceResource($experience);
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'company' => 'sometimes|string|max:255',
            'position' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'string',
            'display_order' => 'integer'
        ]);

        $experience->update($validated);
        return new ExperienceResource($experience);
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return response()->noContent();
    }
}
