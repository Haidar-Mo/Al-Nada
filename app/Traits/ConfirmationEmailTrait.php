<?php

namespace App\Traits;

use App\Models\User;
use Carbon\Carbon;
use App\Mail\ConfirmationEmail;
use Illuminate\Support\Facades\Mail;

trait ConfirmationEmailTrait
{
    /**
     * Generate 6-digits random number
     * @return int
     */
    private function generateVerificationCode()
    {
        return rand(100000, 999999);
    }

    /**
     * 
     */
    protected function createActivateToken(User $user)
    {
        $user->verificationCode = $this->generateVerificationCode();
        $user->save();
        return $user;
    }

    /**
     * Send the verification email.
     *
     * @param User $user
     * @return void
     */
    public function sendVerificationEmail(User $user)
    {
        Mail::to($user->email)->send(new ConfirmationEmail($user));
    }
}
