<?php

namespace App\Http\Controllers\Api\Owner\Places;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Places\City\StoreCityRequest;
use App\Http\Requests\Api\Places\City\UpdateCityRequest;
use App\Http\Resources\Api\Places\CitiesResource;
use App\Http\Resources\Api\Places\DistrictsResource;
use App\Models\Places\City;
use App\Models\Places\District;
use App\Services\Places\CityService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use ApiResponse;

    public function __construct(readonly CityService $cityService)
    {

    }
    /**
     * @OA\Get(
     *     path="/api/cities",
     *     summary="Get a list of entries with Cities",
     *     description="Retrieve a list of entries with name_en, name_ar, code, icon, and is_active",
     *     tags={"Cities"},
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
     *     security={{"bearer": {}}},
     *
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
     *                     example=" city EN"
     *                 ),
     *                 @OA\Property(
     *                     property="name_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="city ar"
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

        $result = $this->cityService->getAll($is_paginate , $wheres, $wheresIn, $with, $withCount , $orWheres);
        return self::makeSuccess(200 , '', CitiesResource::collection($result), !$is_paginate );
    }
    /**
     * @OA\POST(
     *     path="/api/cities",
     *     tags={"Cities"},
     *     security={{"bearer": {}}},
     *     summary="Store City",
     *     description="store new City.",
     *     operationId="storeCity",
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
     *         description="City object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name_ar",
     *                     description="name arabic",
     *                     type="string",
     *                     example="الثاهره"
     *                 ),
     *                 @OA\Property(
     *                     property="name_en",
     *                     description="name english",
     *                     type="string",
     *                     example="Cairo"
     *                 ),
     *     *                 @OA\Property(
     *                     property="image",
     *                     description="image",
     *                     type="file",
     *                 ),
     *                 @OA\Property(
     *                     property="country_id",
     *                     description="country  code",
     *                     type="integer",
     *                     example="253"
     *                 ),
     *
     *                 required={"name_en", "name_ar", "country_id"}
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

    public function store(StoreCityRequest $request)
    {
        $data =  $request->except('image');

        $data['creator_id'] = auth()->user()->id;
        $city =  City::create($data);
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/cities/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $city->image = $filename;
            $city->save();
        }
        return self::makeSuccess(200 , __("messages.created_successfully"), CitiesResource::make($city));

    }

    /**
     * @OA\Get(
     *     path="/api/cities/{id}",
     *     tags={"Cities"},
     *     summary="Get City by ID",
     *     description="Retrieve details of a specific city by its ID, including name, country ,code, icon, and status.",
     *     operationId="getCityById",
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the country to retrieve",
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
     *         description="City retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name_en",
     *                 type="string",
     *                 description="English name of the City",
     *                 example="cairo"
     *             ),
     *             @OA\Property(
     *                 property="name_ar",
     *                 type="string",
     *                 description="Arabic name of the City",
     *                 example="قاهره"
     *             ),
     *             @OA\Property(
     *                 property="country_id",
     *                 type="string",
     *                 description="Country code",
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
     *         description="City not found",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "City not found"}
     *         )
     *     )
     * )
     */
    public function show($id)
    {

        $city = City::with('country')->find($id);
        try {
            if (!$city) {
                // Handle the case where the country is not found
                return self::makeError(404, __("messages.data"));
            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), CitiesResource::make($city));

        } catch (\Throwable $th) {
            // Handle any other exceptions
            return self::makeError(400, $th->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/cities/{id}",
     *     tags={"Cities"},
     *     security={{"bearer": {}}},
     *     summary="Update City",
     *     description="Update an existing City.",
     *     operationId="updateCity",
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="ID of the country to be updated",
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
     *         description="City object that needs to be updated",
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
     *      *                 @OA\Property(
     *                     property="image",
     *                     description="image",
     *                     type="file",
     *                 ),
     *                 @OA\Property(
     *                     property="country_id",
     *                     description="Country code",
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
     *                 required={"name_en", "name_ar", "country_id"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *        response=200,
     *        description="City updated successfully",
     *        @OA\JsonContent(
     *            type="object",
     *            example={"message": "City updated successfully"}
     *        )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="City not found"
     *     )
     * )
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        $data =  $request->except('image');
        $data['update_id'] = auth()->user()->id;
        $city ->update($data);
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/cities/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $city->image = $filename;
            $city->save();
        }
        return self::makeSuccess(200 , __("messages.updated_successfully"), CitiesResource::make($city));

    }

    /**
     * @OA\Delete(
     *     path="/api/cities/{id}",
     *     tags={"Cities"},
     *     summary="Soft delete a city",
     *     description="Mark a city as deleted by setting the deleted_at timestamp, without permanently removing it.",
     *     operationId="deleteCity",
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the country to be soft deleted",
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
    public function destroy(City $city)
    {
        $city->delete();
        return self::makeSuccess(200 , __("messages.delete_successfully"));

    }
    /**
     * @OA\Get(
     *     path="/api/cities/{id}/districts",
     *     tags={"Cities"},
     *     summary="Get Districts by  City ID",
     *     description="Retrieve details of a specific city by its ID, including name, City ,code, icon, and status.",
     *     operationId="getDistrictsByCityId",
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the country to retrieve",
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
     *         description="City retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name_en",
     *                 type="string",
     *                 description="English name of the City",
     *                 example="cairo"
     *             ),
     *             @OA\Property(
     *                 property="name_ar",
     *                 type="string",
     *                 description="Arabic name of the City",
     *                 example="قاهره"
     *             ),
     *             @OA\Property(
     *                 property="country_id",
     *                 type="string",
     *                 description="Country code",
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
     *         description="City not found",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "City not found"}
     *         )
     *     )
     * )
     */
    public function getDistrictsInCities($id)
    {

        $districts = District::where('city_id' , $id)->get();
        return self::makeSuccess(200, __("messages.success"), DistrictsResource::collection($districts));

    }
}
