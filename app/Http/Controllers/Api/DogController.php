<?php

namespace app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $dogs = Dog::all();
        return response()->json($dogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'breed' => 'required|string|max:50',
            'age' => 'required|string|max:25',
            'sex' => 'required|in:male,female',
            'description' => 'min:10|max:1000'
        ]);

        $user_id = Auth::id();

        $validated['user_id'] = $user_id;

        $dog = Dog::create($validated);

        return response()->json($dog, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $dog = Dog::findOrFail($id);
        return response()->json($dog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $dog = Dog::findOrFail($id);

        if (!Gate::allows('update-dog', $dog)) {
            return response()->json('You can\'t edit this dog\'s information', 403);
        }

        $validated = $request->validate([
            'name' => 'string|min:3|max:25',
            'breed' => 'string',
            'age' => 'min:5|max:20',
            'sex' => 'string|in:male,female',
            'adopted' => 'boolean',
            'description' => 'min:10|max:1000'
        ]);

        $dog->update($validated);

        return response()->json($dog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $dog = Dog::findOrFail($id);
        $dog->delete();

        return response()->json(null, 204);
    }
}
