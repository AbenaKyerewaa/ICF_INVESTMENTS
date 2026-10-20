<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit');
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $request->user()->update($request->safe()->only(['name', 'email']));

        return redirect()->route('profile.edit')->with('success', 'Profile details updated.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $request->user()->update($request->safe()->only('password'));

        return redirect()->route('profile.edit')->with('success', 'Password updated.');
    }
}
