<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function export(Request $request)
    {
        $categoryId = $request->input('category_id');

        $query = Product::query();
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $dataExists = $query->exists();

        if ($dataExists) {
            return (new ProductsExport($categoryId))->download('DataProduk.xlsx');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data produk yang sesuai untuk diekspor.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Cache::remember('categories', 3600, function () {
            return Category::all();
        });;

        $products = Product::select(
            'id',
            'category_id',
            'name',
            'price',
            'unit',
            'stock'
        )->with(['category:id,name'])->paginate(10);

        foreach ($products as $product) {
            $product->can_delete = $product->orderItems()->count() == 0;
        }

        return view('product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();

        $units = Product::getUnits();

        return view('product.create', compact('categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate(
            [
                'category_id' => 'required',
                'name' => 'required|max:255',
                'price' => 'required|numeric|min:0',
                'unit' => 'required',
                'stock' => 'required|integer||min:0',
                'description' => 'required|',
                'image_url' => 'required|file|mimes:jpeg,png,jpg|max:3072'
            ]
        );

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('product-images', 'public');
        }

        Product::create($data);

        return redirect()->route('product.index')->with('success', 'Produk berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::select('id', 'name')->get();

        $units = Product::getUnits();

        return view('product.edit', compact('product', 'categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate(
            [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|max:255',
                'price' => 'required|numeric|min:0',
                'unit' => 'required',
                'stock' => 'required|integer||min:0',
                'description' => 'required',
                'image_url' => 'sometimes|file|mimes:jpeg,png,jpg|max:3072'
            ]
        );

        if ($request->hasFile('image_url')) {

            if ($product->image_url) {
                Storage::delete($product->image_url);
            }

            $data['image_url'] = $request->file('image_url')->store('product-images', 'public');
        }

        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Produk berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->orderItems->count() !== 0) {
            return redirect()
                ->back()->with(
                    'error',
                    'Data produk ini telah terhubung ke data penjualan, tidak dapat dihapus.'
                );
        }

        if ($product->image_url) {
            Storage::delete($product->image_url);
        }

        $product->destroy($product->id);
        return redirect()
            ->route('product.index')
            ->with('success', 'Data Produk berhasil dihapus.');
    }
}
