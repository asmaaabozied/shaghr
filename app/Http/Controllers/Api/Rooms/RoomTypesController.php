<?php

namespace App\Http\Controllers\Api\Rooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rooms\StoreRoomTypesRequest;
use App\Http\Requests\Api\Rooms\UpdateRoomTypesRequest;
use App\Http\Resources\Api\Rooms\RoomTypeResource;
use App\Models\Rooms\RoomTypes;
use App\Services\Rooms\RoomTypeService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class RoomTypesController extends Controller
{
    use ApiResponse;
    protected  $service;
    public function __construct(RoomTypeService  $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/room-types",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name_ar, name_en,image,active, hotels_count, and user_id",
     *     tags={"Room Types"},
     *          @OA\Parameter(
     *           name="Accept-Language",
     *           in="header",
     *           description="Set language parameter by ",
     *       @OA\Schema(
     *               type="string",
     *               enum={"en", "ar"},
     *               default="en"
     *           ),
     *           example="en"
     *       ),
     *      security={{"bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="name_en",
     *                     type="string",
     *                     description="English name",
     *                     example="Name EN"
     *                 ),
     *                 @OA\Property(
     *                     property="name_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="Name AR"
     *                 ),
     *                     @OA\Property(
     *                     property="capsity",
     *                     type="integer",
     *                     description="max number",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="description_en",
     *                     type="string",
     *                     description="description_en",
     *                     example="description_en"
     *                 ),
     *                 @OA\Property(
     *                 property="description_ar",
     *                   type="string",
     *                   description="description_ar"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No entries found"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $wheresIn = $with = $wheres = $withCount = $orWheres = [];
        $is_paginate = $request->is_paginate ?? 0;
        if ($request->search) {
            $wheres[] = ['name_en', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['name_ar', 'like', '%' . $request->search . '%'];
        }

        $result = $this->service->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __('messages.success'), RoomTypeResource::collection($result), !$is_paginate);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomTypesRequest $request)
    {
        //
    }
    /**
     * @OA\Get(
     *      path="/api/room-types/{id}",
     *      operationId="getRoomTypesById",
     *      tags={"Room Types"},
     *      summary="Get Room Types information",
     *      description="Returns Room Types data",
     *          @OA\Parameter(
     *  name="Accept-Language",
     *  in="header",
     *  description="Set language parameter by ",
     *  @OA\Schema(
     *  type="string",
     *  enum={"en", "ar"},
     *  default="en"
     *  ),
     *  example="en"
     *  ),
     *  security={{"bearer": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="room Type id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function show(RoomTypes $roomType)
    {
        return self::makeSuccess(200, __('messages.success'), RoomTypeResource::make($roomType));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomTypes $roomTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomTypesRequest $request, RoomTypes $roomTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomTypes $roomTypes)
    {
        //
    }
}
