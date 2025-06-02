<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\User\ResetPasswordOtpRequest;
use App\Http\Requests\Api\User\ResetPasswordRequest;
use App\Trait\ApiResponse;
use App\Trait\SendVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    use ApiResponse, SendVerification;



    /**
     * @param ResetPasswordOtpRequest $request
     * @return JsonResponse
     */
    public function sendCode(ResetPasswordOtpRequest $request): JsonResponse
    {
        $phone = $request->phone;
        self::send($phone);
        return self::makeSuccess(Response::HTTP_OK, __('messages.send_code'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkCode(Request $request): JsonResponse
    {
        $phone = $request->phone;
        if (self::check($phone, $request->code)) {
            return self::makeSuccess(Response::HTTP_OK, __('messages.success'));
        } else {
            return self::makeError(Response::HTTP_BAD_REQUEST, __('messages.invalid_code'));
        }
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ResetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->showByColumn('phone', $request->phone);
        $this->update($user->id, $data);
        return self::makeSuccess(Response::HTTP_OK, __('messages.changed_successfully'));
    }
}
