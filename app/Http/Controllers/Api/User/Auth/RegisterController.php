<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\RegisterRequest;
use App\Http\Requests\Api\User\ResetPasswordOtpRequest;
use App\Services\Auth\AuthenticationService;
use App\Trait\ApiResponse;
use App\Trait\SendVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    use ApiResponse, SendVerification;

    protected $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     *     path="/api/user/register",
     *     summary="User register",
     *     tags={"Authentication"},
     *     description="register using email and password to get an access token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"first_name","last_name","phone","email", "password"},
     *                 @OA\Property(property="first_name", type="string", format="first_name", example="ahmed"),
     *                 @OA\Property(property="last_name", type="string", format="last_name", example="sayed"),
     *                 @OA\Property(property="address", type="string",  example="address"),
     *                 @OA\Property(property="phone", type="string",  example="phone"),
     *                 @OA\Property(property="gender", type="string",  example="male"),
     *                 @OA\Property(property="birthday", type="date", format="date", example=""),
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
    public function register(RegisterRequest $request)
    {
        // Register the user using the AuthenticationService
        return $this->authService->register($request->validated());


    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
//    public function checkCode(Request $request): JsonResponse
//    {
//        if (self::check(auth()->user()->phone, $request->code)) {
//            auth()->user()->update([
//                'phone_verified_at' => now()
//            ]);
//            return self::makeSuccess(Response::HTTP_OK, __('messages.success'));
//        } else {
//            return self::makeError(Response::HTTP_BAD_REQUEST, __('messages.invalid_code'));
//        }
//    }


    /**
     * @param ResetPasswordOtpRequest $request
     * @return JsonResponse
     */
//    public function resendCode(): JsonResponse
//    {
//        $phone = auth()->user()->phone;
//        self::send($phone);
//        $data = [
//            'phone' => $phone,
//            'code' => '1234',
//        ];
//        PhoneVerification::create($data);
//        return self::makeSuccess(Response::HTTP_OK, __('messages.send_code'));
//    }

}
