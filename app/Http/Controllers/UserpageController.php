<?php

namespace App\Http\Controllers;

use App\Models\Userpage;
use Illuminate\Http\Request;
use Auth;

class UserpageController extends Controller
{
    public function update(Request $request) {
        $request->validate([
            'about' => 'required|max:255'
        ]);

        $request->user()->userpage()->updateOrCreate(
            ['user_id' => $request->user()->id],
            ['about_me' => $request->about]
        );

        return back()->with('success', 'Updated userprofile');
    }

    public function uploadProfilePicture(Request $request) {
        $request->validate([
            'image' => 'required|mimes:png,jpg,webp|max:300'
        ]);

        if ($request->hasFile('image')) {
            $filename = Auth::user()->id;
            $request->image->storeAs('images', $filename, 'public');
            Auth::user()->update(['image' => $filename]);
        }

        return redirect()->back()->with('error');
    }
}
