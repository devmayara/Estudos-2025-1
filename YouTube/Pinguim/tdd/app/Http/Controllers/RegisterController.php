<?php

namespace App\Http\Controllers;

use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke()
    {
        /** @var User $user */
        $user = User::query()->create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
        ]);

        auth()->login($user);

        return redirect('dashboard');
    }
}