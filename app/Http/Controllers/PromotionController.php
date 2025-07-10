<?php
namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function edit($id)
    {
        if (Auth::user()->role !== 'marketing') {
            abort(403);
        }

        $item = Promotion::findOrFail($id);
        return view('edit', ['item' => $item, 'type' => 'promotion']);
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'marketing') {
            abort(403);
        }

        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $promotion->title = $request->title;
        $promotion->description = $request->description;

        if ($request->hasFile('image')) {
            if ($promotion->image) {
                Storage::delete('public/' . $promotion->image);
            }
            $path = $request->file('image')->store('promotions', 'public');
            $promotion->image = $path;
        }

        $promotion->save();

        return redirect('/')->with('success', 'Promotion updated successfully.');
    }
}
