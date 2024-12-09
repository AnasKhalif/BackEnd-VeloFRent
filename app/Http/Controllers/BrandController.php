<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();

        return response()->json([
            'brands' => $brands
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        $brand = new Brand([
            'name' => $request->name,
            'photo' => $request->photo ? $request->file('photo')->store('brands') : null,
        ]);

        $brand->save();

        return response()->json([
            'message' => 'Brand created successfully',
            'brand' => $brand
        ], 201);
    }
}
