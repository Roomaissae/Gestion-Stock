<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->input('search');
    $products = Product::with(['category', 'supplier', 'stock'])
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })
        ->get(); 
    $categories = Categorie::all();
    $suppliers = Supplier::all();
    if ($request->ajax()) {
        return response()->json([
            'products' => $products,
        ]);
    }

    return view('products.index', compact('products', 'categories', 'suppliers'));
}
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('products', 'public');
            $validated['picture'] = $picturePath;
        }
        $product = Product::create($validated);
        if ($request->ajax()) {
            return response()->json(['success' => true, 'product' => $product]);
        }
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }
    public function show(Product $product)
    {
        return response()->json($product);
    }
    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        if ($request->hasFile('picture')) {
            if ($product->picture) {
                Storage::disk('public')->delete($product->picture);
            }

            $picturePath = $request->file('picture')->store('products', 'public');
            $validated['picture'] = $picturePath;
        }

        $product->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'product' => $product]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }
    public function destroy(Product $product)
    {
        if ($product->picture) {
            Storage::disk('public')->delete($product->picture);
        }
        $product->delete();
        return response()->json(['success' => true]);
    }
      /**
     * Export all products as Excel.
     */
    public function export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }
    public function import(Request $request)
    { 
        Excel::import(new ProductImport, $request->file('file'));
        return back()->with('success', 'Products imported successfully.');
    }

}
