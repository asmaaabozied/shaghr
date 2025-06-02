<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\AuthResource;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AdminAuthController extends Controller
{
    use ApiResponse;

    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate user with credentials
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Check if the user has the admin role
            if (!$user->hasRole('admin')) {
                return self::makeError(Response::HTTP_FORBIDDEN, __('messages.invalid_credentials'));

            }

            // Create a Passport token for the user
            $token = $user->createToken('AdminAccessToken')->accessToken;

            // Return the token and user information
            return self::makeSuccess(Response::HTTP_OK, __('messages.login_successfully'), AuthResource::make($user));

        }

        // If login fails
        return self::makeError(Response::HTTP_UNAUTHORIZED, __('messages.invalid_credentials'));

    }
    public function logout(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return self::makeSuccess(Response::HTTP_OK, __('messages.logout_successfully'));
    }
}
