<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tag;
use App\Http\Requests\Tenant\StoreTagRequest;
use App\Http\Requests\Tenant\UpdateTagRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of tags.
     */
    public function index(Request $request)
    {
        $query = Tag::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%");
        }

        $perPage = $request->input('per_page', 50);
        $perPage = in_array($perPage, [10, 20, 50, 100]) ? $perPage : 50;

        $tags = $query->orderBy('name')->paginate($perPage);

        return response()->json($tags);
    }

    /**
     * Get all tags (for dropdown/select)
     */
    public function all()
    {
        $tags = Tag::orderBy('name')->get();

        return response()->json($tags);
    }

    /**
     * Store a newly created tag in storage.
     */
    public function store(StoreTagRequest $request)
    {
        try {
            $data = $request->validated();

            // Set created_by and updated_by from authenticated user
            $data['created_by'] = Auth::id();
            $data['updated_by'] = Auth::id();

            $tag = Tag::create($data);

            return response()->json($tag, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('tag.save_error'),
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified tag.
     */
    public function show($id)
    {
        $tag = Tag::findOrFail($id);

        return response()->json($tag);
    }

    /**
     * Update the specified tag in storage.
     */
    public function update(UpdateTagRequest $request, $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $data = $request->validated();

            // Set updated_by from authenticated user
            $data['updated_by'] = Auth::id();

            $tag->update($data);

            return response()->json($tag);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('tag.update_error'),
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the specified tag from storage.
     */
    public function destroy($id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('tag.delete_error'),
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
