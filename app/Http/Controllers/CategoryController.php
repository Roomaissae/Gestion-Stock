<?php
namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function productsByCategory()
    {
        $categories = Categorie::all();
        $products = [];
        return view('products.bycat', compact('categories', 'products'));
    }

    public function getProductsByCategory(Categorie $category)
    {
        $categories = Categorie::all();
        $products = $category->products;
        return view('products.bycat', compact('categories', 'products'));
    }
}