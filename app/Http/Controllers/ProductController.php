<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function edit($id)
    {
        if (Auth::user()->role !== 'marketing') {
            abort(403);
        }

        $item = Product::findOrFail($id);
        return view('edit', ['item' => $item, 'type' => 'product']);
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'marketing') {
            abort(403);
        }

        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $product->title = $request->title;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect('/')->with('success', 'Product updated successfully.');
    }
}
