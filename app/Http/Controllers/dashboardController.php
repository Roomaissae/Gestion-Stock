<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    if (!Auth::check()) {
            return redirect('login');
        }

    $user = User::find(1); 
    $pic = $user->avatar ?? 'default.png';

    return view('dashboard', compact('pic'));
}
    public function productsBySupplier(): View
    {
        $suppliers = Supplier::all();
        return view('products.by-supplier', compact('suppliers'));
    }
    public function getProductsBySupplier(Supplier $supplier)
    {
        $products = Product::with(['stock','category'])
            ->where('supplier_id', $supplier->id)
            ->get();

        return view('products._products_by_supplier', compact('products'));
    }
    public function productsByStore(): View
    {
        $stores = Store::all();
        return view('products.by-store', compact('stores'));
    }

    public function getProductsByStore(Store $store)
    {
        $products = Product::with(['category', 'stock'])
            ->whereHas('stock', function($query) use ($store) {
                $query->where('store_id', $store->id);
            })
            ->get();

        return response()->json($products);
    }

    public function saveCookie()
    {
        $name = request()->input("txtCookie");
        Cookie::queue("UserName", $name, 6000000); // durée en minutes
        return redirect()->back();
    }

    public function saveSession(Request $request)
    {
        $name = $request->input("txtSession");
        $request->session()->put('SessionName', $name);
        return redirect()->back();
    }

    public function saveAvatar()
   {
    request()->validate([
        'avatarFile'=>'required|image',
    ]);
    $ext = request()->avatarFile->getClientOriginalExtension();
    $name = Str::random(10).time().".".$ext;
    request()->avatarFile->move(public_path('storage/avatars'),$name);
    $user = User::find(1);
    $user->update(['avatar'=>$name]);
    return redirect()->route('dashboard');
   }

}
