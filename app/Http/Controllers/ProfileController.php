<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function myProfile()
    {
        $user = auth()->user();
        return view('pages.profile.my-profile', compact('user'));
    }
}
