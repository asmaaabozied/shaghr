<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LoginRequest;
use App\Services\Auth\AuthenticationService;
use App\Trait\ApiResponse;
use App\Trait\SendVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

//use App\Http\Requests\Auth\OtpRequest;
//use App\Models\PhoneVerification;
//use App\Repositories\Interfaces\UserRepositoryInterface;

class LoginController extends Controller
{
    use ApiResponse, SendVerification;


    protected $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     *     path="/api/user/login",
     *     summary="User Login",
     *     tags={"Authentication"},
     *     description="Login using email and password to get an access token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"email", "password"},
     *                 @OA\Property(property="email", type="string", format="email", example="admin@shagr.com"),
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
    public function login(LoginRequest $request)
    {
        // Handle the login using the AuthenticationService
        return $this->authService->login($request->validated());
    }

    /**
     * @OA\Post(
     *     path="/api/password/forgot",
     *     summary="Forget Password",
     *      tags={"Authentication"},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="Faq registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        return $this->authService->sendResetLink($request->only('email'));
    }


    /**
     * @OA\Post(
     *     path="/api/password/reset",
     *     summary="Reset Password",
     *      tags={"Authentication"},
     *     @OA\Parameter(
     *         name="token",
     *         in="query",
     *         description="token",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *          @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *          @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *         required=true,
     *         @OA\Schema(type="password")
     *     ),
     *              @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="password_confirmation",
     *         required=true,
     *         @OA\Schema(type="password")
     *     ),
     *     @OA\Response(response="201", description="Faq registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        return $this->authService->resetPassword($request->only('email', 'password', 'password_confirmation', 'token'));
    }

    /**
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return self::makeSuccess(Response::HTTP_OK, __('messages.logout_successfully'));
    }
}
