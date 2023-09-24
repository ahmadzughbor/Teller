<?php

namespace App\Observers;

use App\Models\User;
use App\Models\wallet;

class UserObserver
{

    public function created(User $user)
    {
        // Create a new user wallet record associated with the user
        $wallet = new wallet ();
        $wallet->user_id = $user->id;
        $wallet->balance = 0;
        $wallet->save();
    }
}
