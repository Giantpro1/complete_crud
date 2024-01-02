<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;
class ProductCategory extends Controller
{
    //

    public function productCategory(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::all();

            // Return data for DataTables
            // return datatables()->of($categories)->toJson();
        }

        // If not an AJAX request, return the view with categories
        $categories = Category::all();
        return view('products.categorylist', compact('categories'));
    }

    public function submitCategory(Request $request)
    {
        $randNumber = rand(10000, 99999);
        $cat_id = 'cat_' . $randNumber;
        // Validate the incoming request data
        $request->validate([
            'categoryTitle' => 'required',
            'slug' => 'required',
            'parentCategory' => 'required',
            'description' => 'nullable|string',
            'status' => 'required',
        ]);

        // Create a new category
        Category::create([
            'cat_id' => $cat_id,
            'categoryTitle' => $request->input('categoryTitle'),
            'slug' => $request->input('slug'),
            'parentCategory' => $request->input('parentCategory'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);

        return response()->json(['message' => 'Category added successfully']);
    }
}
