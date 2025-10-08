<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);

        foreach ($categories as $category) {
            $category->can_delete = $category->products()->count() == 0;
        }

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        Category::create($data);

        return redirect()->route('category.index')->with('success', 'Kategori baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        $category->update($data);

        return redirect()->route('category.index')->with('success', "Kategori $category->name berhasil di update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->products->count() !== 0) {
            return redirect()
                ->back()->with(
                    'error',
                    'Data kategori ini telah terhubung ke data produk, tidak dapat dihapus.'
                );
        }

        $category->delete();

        return redirect()->back()->with('success', "Kategori $category->name berhasil dihapus.");
    }
}
