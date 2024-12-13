<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motorcycle;
use App\Models\Store;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class MotorcycleController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $motorcycles = Motorcycle::where('store_id', $user->store->id)
            ->with(['store', 'brand'])
            ->get();


        return response()->json([
            'motorcycles' => $motorcycles
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'rating' => 'nullable|numeric|min:0|max:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);


        $user = auth()->user();
        $store_id = $user->store->id;


        $motorcycle = new Motorcycle([
            'store_id' => $store_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'price' => $request->price,
            'rating' => $request->rating ?? 0,
            'photo' => $request->photo ? $request->file('photo')->store('motorcycles', 'public') : null,
        ]);

        $motorcycle->save();

        return response()->json([
            'message' => 'Motorcycle added successfully',
            'motorcycle' => $motorcycle,
            'photo_url' => asset('storage/' . $motorcycle->photo)
        ], 201);
    }
}
