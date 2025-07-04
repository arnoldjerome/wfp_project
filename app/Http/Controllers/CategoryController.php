<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function totalFoods()
    {
        $category = DB::table('categories as c')
        ->leftJoin('foods as f',"c.id","=","f.category_id")
        ->select("c.id", "c.name", DB::raw("count(f.name) as TotalFood"))
        ->groupBy("c.id", "c.name")
        ->get();

        // dd($report);
        return view("totalfood", compact('category'));

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('foods')->orderBy('id')->paginate(5);

        return view("totalfood", compact('categories'));
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
            'name' => 'required|string|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $id,
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return response()->json(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
    $category->delete();

    return response()->json(['message' => 'Deleted successfully']);
    }
}
