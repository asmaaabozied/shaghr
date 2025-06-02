<?php

namespace App\Services\Auth;

use App\Http\Resources\Api\User\AuthResource;
use App\Models\User\User;
use App\Trait\ApiResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationService
{
    use ApiResponse;
    public function register($data)
    {
        $imagePath = null;
        $type= $data['type']??null;
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('profile_images', 'public');
        }
        unset($data['type']);

        // Create the user
        $user = User::create($data  );

        if($type && $type=='owner'){
            $user->assignRole('owner');
        }
        // Optionally create a token if using Passport or Sanctum
        $user->token = $user->createToken('UserToken')->accessToken;

  return self::makeSuccess(Response::HTTP_OK, __('messages.register_successfully'), AuthResource::make($user));


    }

    public function login($data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
        return self::makeError(Response::HTTP_BAD_REQUEST, __('messages.invalid_credentials'));

        }
        $user->token = $user->createToken('PassportToken')->accessToken;

    return self::makeSuccess(Response::HTTP_OK, __('messages.login_successfully'), AuthResource::make($user));

    }

    public function sendResetLink($data)
    {
        $response = Password::sendResetLink($data);

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset link sent to your email.']);
        } else {
            return response()->json(['error' => 'Unable to send reset link.'], 400);
        }
    }

    // Reset the user's password
    public function resetPassword($data)
    {
        $response = Password::reset($data, function ($user, $password) {
            $user->password = $password;
            $user->setRememberToken(Str::random(60));
            $user->save();

            event(new PasswordReset($user));
        });

        if ($response == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successfully.']);
        } else {
            return response()->json(['error' => 'Invalid token or user not found.'], 400);
        }
    }
}
