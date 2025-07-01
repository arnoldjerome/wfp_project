<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        // $foods = DB::select("select * from foods");
        // $foods = Food::with('category', 'addOns')->get()->sortBy('id');
        $categories = Category::all();

        // print_r($foods);exit;

        // Query Builder
        // $foods = DB::table("foods")->get();
        // $foods = $foods->sortBy('id');
        // print_r($foods);exit;
        // dd($foods);
        //Eloquent Model
        $foods = Food::with('category', 'addOns')->orderBy('id')->paginate(5);

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
            'img_url' => 'required|string',
        ]);

        $food = Food::create([
            'name' => $request->name,
            'description' => $request->description,
            'nutrition_fact' => $request->nutrition_fact,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'img_url' => '/assets/images/foods/' . Str::slug($request->name) . '.jpg',
        ]);

        if ($request->has('addons')) {
            foreach ($request->addons as $addon) {
                $food->addOns()->create([
                    'name' => $addon['name'],
                    'price' => $addon['price'],
                ]);
            }
        }

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
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/foods'), $imageName);
            $food->img_url = '/assets/images/foods/' . $imageName;
        }

        $food->save();

        $existingIds = [];
        if ($request->has('addons')) {
            foreach ($request->addons as $addon) {
                if (isset($addon['id'])) {
                    $food->addOns()->updateOrCreate(
                        ['id' => $addon['id']],
                        ['name' => $addon['name'], 'price' => $addon['price']]
                    );
                    $existingIds[] = $addon['id'];
                } else {
                    $newAddon = $food->addOns()->create([
                        'name' => $addon['name'],
                        'price' => $addon['price'],
                    ]);
                    $existingIds[] = $newAddon->id;
                }
            }
        }

        // Hapus add-on yang tidak ada di input
        $food->addOns()->whereNotIn('id', $existingIds)->delete();

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
