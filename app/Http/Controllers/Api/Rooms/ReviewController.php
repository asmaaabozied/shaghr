<?php

namespace App\Http\Controllers\Api\Rooms;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rooms\ReviewRequest;
use App\Http\Resources\Api\Rooms\ReviewResource;
use App\Models\Rooms\RoomReview;
use App\Services\Rooms\ReviewService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponse;

    public function __construct(readonly ReviewService $reviewservice)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/reviews",
     *     summary="Get a list reviews Rooms of entries with columns",
     *     description="Retrieve a list of entries with rating, view,status,description_ar,user_id,description_en, and room_id",
     *     tags={"Rooms"},
    @OA\Parameter(
    name="Accept-Language",
    in="header",
    description="Set language parameter by ",
    @OA\Schema(
    type="string",
    enum={"en", "ar"},
    default="en"
    ),
    example="en"
    ),
    security={{"bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *
     *                 @OA\Property(
     *                     property="rating",
     *                     type="string",
     *                     description="rating",
     *                     example="4"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     description="status",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="room_id",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example="room_id"
     *                 ),
     *                    @OA\Property(
     *                     property="user_id",
     *                     type="string",
     *                     description="user_id",
     *                     example="1"
     *                 ),
     *                      @OA\Property(
     *                     property="view",
     *                     type="string",
     *                     description="view",
     *                     example="view"
     *                 ),
     *                         @OA\Property(
     *                     property="descripton_en",
     *                     type="string",
     *                     description="descripton_en",
     *                     example="descripton_en"
     *                 ), *                         @OA\Property(
     *                     property="descripton_ar",
     *                     type="string",
     *                     description="descripton_ar",
     *                     example="descripton_ar"
     *                 ),
     *
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
            $wheres[] = ['rating', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['description_ar', 'like', '%' . $request->search . '%'];
        }

        $result = $this->reviewservice->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __("messages.success"), ReviewResource::collection($result), !$is_paginate);


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

    /**
     * @OA\Post(
     *     path="/api/reviews",
     *     summary="Add reviews",
     *      tags={"Rooms"},
     *       @OA\Parameter(
    name="rating",
    in="query",
    description="rating",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="room_id",
    in="query",
    description="room_id",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="user_id",
    in="query",
    description="user_id",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="aview",
    in="query",
    description="view",
    @OA\Schema(type="string")
    ),
     *      @OA\Parameter(
    name="status",
    in="query",
    description="status",
    @OA\Schema(type="string")
    ),
     *
     *             @OA\Parameter(
    name="description_ar",
    in="query",
    description="description_ar",
    @OA\Schema(type="string")
    ),
     *
     *                 @OA\Parameter(
    name="description_en",
    in="query",
    description="description_en",
    @OA\Schema(type="string")
    ),
     *
     *     @OA\Response(response="201", description="Room Comments  registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */


    public function store(ReviewRequest $request)
    {
        $request_data = $request->all();
        $request_data['created_by'] = auth()->user()->id;
        $request_data['user_id'] = auth()->user()->id;
        $data = RoomReview::create($request_data);
        return self::makeSuccess(200, __('messages.created_successfully'), $data);
    }


}
