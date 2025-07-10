<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function edit($id)
    {
        if (Auth::user()->role !== 'marketing') {
            abort(403);
        }

        $item = Team::findOrFail($id);
        return view('edit', ['item' => $item, 'type' => 'team']);
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'marketing') {
            abort(403);
        }

        $team = Team::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048'
        ]);

        $team->name = $request->name;
        $team->position = $request->position;

        if ($request->hasFile('image')) {
            if ($team->image) {
                Storage::delete('public/' . $team->image);
            }
            $path = $request->file('image')->store('teams', 'public');
            $team->image = $path;
        }

        $team->save();

        return redirect('/')->with('success', 'Team member updated successfully.');
    }
}
