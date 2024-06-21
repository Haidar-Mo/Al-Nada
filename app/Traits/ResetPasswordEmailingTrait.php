<?php

namespace App\Traits;

use App\Models\User;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Mail;

trait ResetPasswordEmailingTrait
{

    /**
     * create a random Password for user
     * @param User $user
     * @return string $new_password
     */
    public function resetPassword(User $user)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $new_password = substr(str_shuffle($characters), 0, 10);
        $user->password = bcrypt($new_password);
        $user->save();
        return $new_password;
    }

    /**
     * Send the verification email.
     *
     * @param User $user
     * @return void
     */
    public function sendResetPasswordEmail(User $user, $new_password)
    {
        Mail::to($user->email)->send(new ResetPasswordEmail($user, $new_password));
    }
}
