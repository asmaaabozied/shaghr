<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ProfileRequest;
use App\Http\Resources\Api\User\AuthResource;
use App\Http\Resources\Api\User\UserProfile;
use App\Models\User\User;
use App\Trait\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return self::makeSuccess(Response::HTTP_OK, __('messages.success'), UserProfile::make(auth()->user()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update(ProfileRequest $request, $id): Response
    {
        $id = $request['id'];
        $user = User::find($id);
        $user->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'] ?? null,
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => bcrypt($request['password']),
            'birthday' => $request['birthday'] ?? null,
            'is_active' => 1,  // Default active
        ]);
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/users/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $user->image = $filename;
            $user->save();
        }
        return self::makeSuccess(Response::HTTP_OK, __('messages.updated_successfully'), $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function destroy(): Response
    {
//        $this->recordRepository->softDelete(auth()->id());
//        return self::makeSuccess(Response::HTTP_OK, __('messages.delete_successfully'));
    }


    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
//        $this->recordRepository->update(auth()->id(), ['password' => Hash::make($request->password)]);
//        return self::makeSuccess(Response::HTTP_OK, __('messages.changed_successfully'));
    }
}
