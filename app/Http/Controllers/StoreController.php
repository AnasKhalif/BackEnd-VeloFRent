<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->store) {
            return response()->json([
                'store' => $user->store
            ]);
        }

        return response()->json([
            'message' => 'No store found'
        ], 404);
    }

    public function store(Request $request)
    {
        $user = auth()->user();


        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'owner_id_card' => 'nullable|string',
        ]);


        $store = new Store([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'photo' => $request->photo ? $request->file('photo')->store('stores') : null,
            'owner_id_card' => $request->owner_id_card,
        ]);

        $user->store()->save($store);

        return response()->json([
            'message' => 'Store created successfully',
            'store' => $store,
            'photo_url' => asset('storage/' . $store->photo)
        ], 201);
    }
}
