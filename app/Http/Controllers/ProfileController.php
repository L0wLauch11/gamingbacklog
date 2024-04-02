<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Http\Controllers\GamePropertiesController;
use App\Enums\GameStatus;
use App\Models\LocalGame;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View {
        return view('profile.edit', [
            'user' => $request->user(),
            'userpage' => $request->user()->userpage()->first()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Show the user's public information
     */
    public function show(User $user) {
        $userpage = $user->userpage()->first();

        $propFavourites = GamePropertiesController::getUserGamesFromProperty($user, 'favourite');
        $propFinished = $user->gameProperties()->where('status', GameStatus::FINISHED)->get()->sortByDesc('given_score');
        $propPlanned = $user->gameProperties()->where('status', GameStatus::PLANNED)->get();
        $propRecents = $user->gameProperties()->orWhereNull('favourite')->latest()->get(); // could also be NULL

        return view('profile.show', [
                'user' => $user,
                'finishedGames' => $propFinished,
                'plannedGames' => $propPlanned,
                'favourites' => $propFavourites,
                'recentGames' => $propRecents,
                'userpage' => $userpage
            ]
        );
    }

    public function index() {
        return view('profile.index');
    }

    public function search(Request $request) {
        $request->validate([
            'query' => 'required|max:255'
        ]);

        $searchQuery = $request->input('query');
        $results = User::where('name', 'LIKE', "%$searchQuery%")->get();

        return view('profile.search_results', ['query' => $searchQuery, 'results' => $results]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
