<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Views\ProductReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function updatePrice(Request $request, int $id)
    {
        $request->validate(['price' => 'required|numeric|min:0']);

        ProductReport::findOrFail($id)->update(['price' => $request->price]);

        return redirect()->route('report');
    }

    public function index()
    {
        $query = ProductReport::orderBy('price', 'desc');

        $mostExpensive = $query->clone()->first();
        $mostExpensive->update(['price' => rand(42, 420)]);

        $products = $query->get()->keyBy('id');
        $firstRow = $products->first();
        $proxyDemo = $firstRow?->proxied();
        $proxyDemo?->update(['price' => 123.45]); // works, updates the underlying product and view record

        $rawProducts = Product::orderBy('price', 'desc')->get()->keyBy('id');
        $firstRawProduct = $rawProducts->first();
        $readonlyDemo = $firstRawProduct?->readonly();
        $fromViewDemo = $firstRawProduct?->fromView();
        // $readonlyDemo?->update(['price' => 123.45]); // throws
        // $fromViewDemo?->update(['price' => 12.345]); // throws

        return view('report', compact('products', 'rawProducts', 'proxyDemo', 'readonlyDemo', 'fromViewDemo'));
    }
}
