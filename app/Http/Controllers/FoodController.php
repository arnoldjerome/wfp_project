<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;


class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // RAW
        $foods = DB::select("select * from foods");
        $foods = Food::with('category')->get();
        $categories = Category::all();

        // print_r($foods);exit;

        // Query Builder
        $foods = DB::table("foods")->get();
        $foods = $foods->sortBy('price');
        // print_r($foods);exit;
        // dd($foods);
        //Eloquent Model
        $foods = Food::all();
        $foods = $foods->sortBy('price');

        return view("food.index", compact('foods', 'categories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'nutrition_fact' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        Food::create([
            'name' => $request->name,
            'description' => $request->description,
            'nutrition_fact' => $request->nutrition_fact,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        return response()->json(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show($food)
    {
        $current_food = Food::find($food);
        return view("food.show", compact("current_food"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $food = Food::findOrFail($id);

    $food->name = $request->name;
    $food->description = $request->description;
    $food->nutrition_fact = $request->nutrition_fact;
    $food->price = $request->price;
    $food->category_id = $request->category_id;

    $food->save();

    return response()->json(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $food = Food::findOrFail($id);
        $food->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
