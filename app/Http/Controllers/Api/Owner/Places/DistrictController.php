<?php

namespace App\Http\Controllers\Api\Owner\Places;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Places\District\StoreDistrictRequest;
use App\Http\Requests\Api\Places\District\UpdateDistrictRequest;
use App\Http\Resources\Api\Places\DistrictsResource;
use App\Models\Places\District;
use App\Services\Places\DistrictService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    use ApiResponse;

    public function __construct(readonly DistrictService $districtService)
    {
    }
    /**
     * @OA\Get(
     *     path="/api/districts",
     *     summary="Get a list of entries with Cities",
     *     description="Retrieve a list of entries with name_en, name_ar, code, icon, and is_active",
     *     tags={"Districts"},
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *          name="Accept-Language",
     *          in="header",
     *          description="Set language parameter by ",
     *      @OA\Schema(
     *              type="string",
     *              enum={"en", "ar"},
     *              default="en"
     *          ),
     *          example="en"
     *      ),
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
     *                     example=" districts EN"
     *                 ),
     *                 @OA\Property(
     *                     property="name_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="districts ar"
     *                 ),
     *                 @OA\Property(
     *                     property="code",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example="HT123"
     *                 ),
     *                 @OA\Property(
     *                     property="icon",
     *                     type="string",
     *                     description="Icon URL",
     *                     nullable=true,
     *                     example="http://example.com/icon.png"
     *                 ),
     *                 @OA\Property(
     *                     property="is_active",
     *                     type="boolean",
     *                     description="Whether the entry is active",
     *                     example=true
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
        $wheresIn =  $with = $wheres = $withCount = $orWheres =  [];
        $is_paginate = $request->is_paginate ?? 0;
        if($request->search){
            $wheres[] = ['name_en', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['name_ar', 'like', '%' . $request->search . '%'];
        }
        if($request->city){
            $wheres[] = ['city_id', $request->city];
        }
$with=['city'];
        $result = $this->districtService->getAll($is_paginate , $wheres, $wheresIn, $with, $withCount , $orWheres);
        return self::makeSuccess(200 , '', DistrictsResource::collection($result), !$is_paginate );
    }



    /**
     * @OA\POST(
     *     path="/api/districts",
     *     tags={"Districts"},
     *     security={{"bearer": {}}},
     *     summary="Store District",
     *     description="store new District.",
     *     operationId="storeDistrict",
     *     @OA\Parameter(
     *            name="Accept-Language",
     *            in="header",
     *            description="Set language parameter by ",
     *        @OA\Schema(
     *                type="string",
     *                enum={"en", "ar"},
     *                default="en"
     *            ),
     *            example="en"
     *        ),
     *     @OA\RequestBody(
     *         description="district object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name_ar",
     *                     description="name arabic",
     *                     type="string",
     *                     example="مدينه نصر"
     *                 ),
     *                 @OA\Property(
     *                     property="name_en",
     *                     description="name english",
     *                     type="string",
     *                     example="nasr city"
     *                 ),
     *                 @OA\Property(
     *                     property="city_id",
     *                     description="city  id",
     *                     type="integer",
     *                     example="253"
     *                 ),
     *
     *                 required={"name_en", "name_ar", "city_id"}
     *             )
     *         ),
     *     ),
     *          @OA\Response(
     *        response=200,
     *          description="saved  successful",
     *          @OA\JsonContent(
     *              type="object",
     *          )
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(StoreDistrictRequest $request)
    {
        $data =  $request->validated();

        $data['creator_id'] = auth()->user()->id;
        $district =  District::with('city')->create($data);
        return self::makeSuccess(200 , __("messages.created_successfully"), DistrictsResource::make($district));
    }

    /**
     * @OA\Get(
     *     path="/api/districts/{id}",
     *     tags={"Districts"},
     *     summary="Get district by ID",
     *     description="Retrieve details of a district, city by its ID, including name, City , icon, and status.",
     *     operationId="getDistrictById",
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the district to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *           name="Accept-Language",
     *           in="header",
     *           description="Set language parameter",
     *           @OA\Schema(
     *               type="string",
     *               enum={"en", "ar"},
     *               default="en"
     *           ),
     *           example="en"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="District retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name_en",
     *                 type="string",
     *                 description="English name of the district",
     *                 example="cairo"
     *             ),
     *             @OA\Property(
     *                 property="name_ar",
     *                 type="string",
     *                 description="Arabic name of the district",
     *                 example="قاهره"
     *             ),
     *             @OA\Property(
     *                 property="city_id",
     *                 type="string",
     *                 description="city code",
     *                 example="20"
     *             ),
     *             @OA\Property(
     *                 property="icon",
     *                 type="string",
     *                 description="City icon URL",
     *                 example="http://example.com/icon.png"
     *             ),
     *             @OA\Property(
     *                 property="is_active",
     *                 type="boolean",
     *                 description="Whether the City is active",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="District not found",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "City not found"}
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $district = District::with('city')->find($id);
        try {
            if (!$district) {
                // Handle the case where the country is not found
                return self::makeError(404, __("messages.data"));
            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), DistrictsResource::make($district));

        } catch (\Throwable $th) {
            // Handle any other exceptions
            return self::makeError(400, $th->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/district/{id}",
     *     tags={"Districts"},
     *     security={{"bearer": {}}},
     *     summary="Update District",
     *     description="Update an existing District.",
     *     operationId="updateDistrict",
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID of the city  to be updated",
     *            required=true,
     *            @OA\Schema(
     *                type="integer",
     *                example=1
     *            )
     *     ),
     *     @OA\Parameter(
     *            name="Accept-Language",
     *            in="header",
     *            description="Set language parameter",
     *            @OA\Schema(
     *                type="string",
     *                enum={"en", "ar"},
     *                default="en"
     *            ),
     *            example="en"
     *     ),
     *          @OA\Parameter(
     *             name="_method",
     *             in="header",
     *             example="put"
     *      ),
     *     @OA\RequestBody(
     *         description="District object that needs to be updated",
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            mediaType="application/json",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name_ar",
     *                     description="Arabic name",
     *                     type="string",
     *                     example="قاهره"
     *                 ),
     *                 @OA\Property(
     *                     property="name_en",
     *                     description="English name",
     *                     type="string",
     *                     example="cairo"
     *                 ),
     *                 @OA\Property(
     *                     property="city_id",
     *                     description="City code",
     *                     type="integer",
     *                     example="20"
     *                 ),
     *
     *                 @OA\Property(
     *                     property="is_active",
     *                     description="Status of the country",
     *                     type="boolean",
     *                     example=true
     *                 ),
     *                 required={"name_en", "name_ar", "city_id"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *        response=200,
     *        description="District updated successfully",
     *        @OA\JsonContent(
     *            type="object",
     *            example={"message": "District updated successfully"}
     *        )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="District not found"
     *     )
     * )
     */
    public function update(UpdateDistrictRequest $request, District $district)
    {
        $data =  $request->validated();
        $data['update_id'] = auth()->user()->id;
        $district ->update($data);
        return self::makeSuccess(200 , __("messages.updated_successfully"), DistrictsResource::make($district));
    }

    /**
     * @OA\Delete(
     *     path="/api/districts/{id}",
     *     tags={"Districts"},
     *     summary="Soft delete a district",
     *     description="Mark a district as deleted by setting the deleted_at timestamp, without permanently removing it.",
     *     operationId="deleteDistrict",
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the District to be soft deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="city successfully soft deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "city deleted successfully"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Country not found",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "city not found"}
     *         )
     *     )
     * )
     */
    public function destroy(District $district)
    {
        $district->delete();
        return self::makeSuccess(200 , __("messages.delete_successfully"));
    }
}
