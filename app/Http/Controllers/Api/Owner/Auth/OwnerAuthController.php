<?php

namespace App\Http\Controllers\Api\Owner\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LoginRequest;
use App\Http\Resources\Api\User\AuthResource;
use App\Models\User\User;
use App\Trait\ApiResponse;
use App\Trait\SendVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class OwnerAuthController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Post(
     *     path="/api/owner/login",
     *     summary="User Login",
     *     tags={"Owner Authentication"},
     *     description="Login using email and password to get an access token",
     *     @OA\Parameter(
     *               name="Accept-Language",
     *               in="header",
     *               description="Set language parameter",
     *               @OA\Schema(
     *                   type="string",
     *                   enum={"en", "ar"},
     *                   default="en"
     *               ),
     *               example="en"
     *        ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"email", "password"},
     *                 @OA\Property(property="email", type="string", format="email", example="owner3@shagr.com"),
     *                 @OA\Property(property="password", type="string", format="password", example="password")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="token_type", type="string", example="Bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=31536000),
     *             @OA\Property(property="access_token", type="string", example="access_token_example"),
     *             @OA\Property(property="refresh_token", type="string", example="refresh_token_example")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="invalid_request")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Invalid email or password.")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        // Validate the login request
      $data=  $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return self::makeError(Response::HTTP_BAD_REQUEST, __('messages.invalid_credentials'));

        }
            // Check if the user has the admin role
            if (!$user->hasRole('owner') || $user->hasRole('admin')) {
                return self::makeError(Response::HTTP_FORBIDDEN, __('messages.invalid_credentials'));
            }
            setPermissionsTeamId($user->id);
            // Create a Passport token for the user
             $user->token = $user->createToken('OwnerAccessToken')->accessToken;
            // Return the token and user information
            return self::makeSuccess(Response::HTTP_OK, __('messages.login_successfully'), AuthResource::make($user));


    }
    public function logout(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return self::makeSuccess(Response::HTTP_OK, __('messages.logout_successfully'));
    }
}
