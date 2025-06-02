<?php

namespace App\Http\Controllers\Api\Owner\Places;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Places\Country\StoreCountryRequest;
use App\Http\Requests\Api\Places\Country\UpdateCountryRequest;
use App\Http\Resources\Api\Places\CitiesResource;
use App\Http\Resources\Api\Places\CountryResource;
use App\Http\Resources\General\LiteListResponse;
use App\Models\Places\City;
use App\Models\Places\Country;
use App\Services\Places\CountryService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

///**
// * @OA\Info(
// *     title="My API country",
// *     version="1.0.0",
// *     description="API Documentation"
// * )
// */
class CountryController extends Controller
{
    use ApiResponse;

    public function __construct(readonly CountryService $countryService)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/countries",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name_en, name_ar, code, icon, and is_active",
     *     tags={"Countries"},
     *     security={{"bearer": {}}},
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
     *                     example="Hotel Name EN"
     *                 ),
     *                 @OA\Property(
     *                     property="name_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="اسم الفندق"
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
        $wheresIn = $with = $wheres = $withCount = $orWheres = [];
        $is_paginate = $request->is_paginate ?? 0;
        if ($request->search) {
            $wheres[] = ['name_en', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['name_ar', 'like', '%' . $request->search . '%'];
        }

        $result = $this->countryService->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __('messages.success'), CountryResource::collection($result), !$is_paginate);
    }

    /**
     * @OA\Get(
     *     path="/api/countries/getCode",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with code,  and id",
     *     tags={"Countries"},
     *     security={{"bearer": {}}},
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
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *
     *                 @OA\Property(
     *                     property="code",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example="HT123"
     *                 ),
     *
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

    public function getCode()
    {

        return self::makeSuccess(200, __('messages.success'), Country::select('id', 'code')->get());

    }

    /**
     * @OA\POST(
     *     path="/api/countries",
     *     tags={"Countries"},          security={{"bearer": {}}},
     *     summary="Store Country",
     *     description="store new country.",
     *     operationId="storeCountry",
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
     *         description="country object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name_ar",
     *                     description="name arabic",
     *                     type="string",
     *                     example="مصر"
     *                 ),
     *                 @OA\Property(
     *                     property="name_en",
     *                     description="name english",
     *                     type="string",
     *                     example="egypt"
     *                 ),
     *                 @OA\Property(
     *                     property="code",
     *                     description="country  code",
     *                     type="string",
     *                     example="20"
     *                 ),
     *                      @OA\Property(
     *                     property="icon",
     *                     description="icon",
     *                     type="file",
     *                 ),
     *
     *                 required={"name_en", "name_ar", "code"}
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

    public function store(StoreCountryRequest $request)
    {
        $data = $request->except('icon');

        $data['create_id'] = auth()->user()->id;
        $country = Country::create($data);
        if ($request->hasFile('icon')) {
            $thumbnail = $request->file('icon');
            $destinationPath = 'images/countries/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $country->icon = $filename;
            $country->save();
        }

        return self::makeSuccess(200, __("messages.created_successfully"), CountryResource::make($country));

    }

    /**
     * @OA\Get(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Get country by ID",
     *     description="Retrieve details of a specific country by its ID, including name, code, icon, and status.",
     *     operationId="getCountryById",
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
     *         description="Country retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name_en",
     *                 type="string",
     *                 description="English name of the country",
     *                 example="Egypt"
     *             ),
     *             @OA\Property(
     *                 property="name_ar",
     *                 type="string",
     *                 description="Arabic name of the country",
     *                 example="مصر"
     *             ),
     *             @OA\Property(
     *                 property="code",
     *                 type="string",
     *                 description="Country code",
     *                 example="20"
     *             ),
     *             @OA\Property(
     *                 property="icon",
     *                 type="string",
     *                 description="Country icon URL",
     *                 example="http://example.com/icon.png"
     *             ),
     *             @OA\Property(
     *                 property="is_active",
     *                 type="boolean",
     *                 description="Whether the country is active",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Country not found",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Country not found"}
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $country = Country::find($id);
        try {
            if (!$country) {
                // Handle the case where the country is not found
                return self::makeError(404, __("messages.data"));
            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), CountryResource::make($country));

        } catch (\Throwable $th) {
            // Handle any other exceptions
            return self::makeError(400, $th->getMessage());
        }

    }


    /**
     * @OA\PUT(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     security={{"bearer": {}}},
     *     summary="Update Country",
     *     description="Update an existing country.",
     *     operationId="updateCountry",
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
     *         description="Country object that needs to be updated",
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
     *                     example="مصر"
     *                 ),
     *                 @OA\Property(
     *                     property="name_en",
     *                     description="English name",
     *                     type="string",
     *                     example="Egypt"
     *                 ),
     *                 @OA\Property(
     *                     property="code",
     *                     description="Country code",
     *                     type="string",
     *                     example="20"
     *                 ),
     *                 @OA\Property(
     *                     property="icon",
     *                     description="Country icon (optional)",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="is_active",
     *                     description="Status of the country",
     *                     type="boolean",
     *                     example=true
     *                 ),
     *                 required={"name_en", "name_ar", "code"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *        response=200,
     *        description="Country updated successfully",
     *        @OA\JsonContent(
     *            type="object",
     *            example={"message": "Country updated successfully"}
     *        )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Country not found"
     *     )
     * )
     */

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $data = $request->except('icon');
        $data['update_id'] = auth()->user()->id;
        $country->update($data);
        if ($request->hasFile('icon')) {
            $thumbnail = $request->file('icon');
            $destinationPath = 'images/countries/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $country->icon = $filename;
            $country->save();
        }
        return self::makeSuccess(200, __("messages.updated_successfully"), CountryResource::make($country));

    }

    /**
     * @OA\Delete(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Soft delete a country",
     *     description="Mark a country as deleted by setting the deleted_at timestamp, without permanently removing it.",
     *     operationId="deleteCountry",
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
     *         description="Country successfully soft deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Country deleted successfully"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Country not found",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Country not found"}
     *         )
     *     )
     * )
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return self::makeSuccess(200, __("messages.delete_successfully"));

    }

    /**
     * @OA\Get(
     *     path="/api/countries/{id}/cities",
     *     tags={"Countries"},
     *     summary="Get Cities by  Country ID",
     *     description="Retrieve details of a specific city by its ID, including name, country ,code, icon, and status.",
     *     operationId="getCitiesByCountryId",
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
    public function getCitiesInCountry($id)
    {
        $cities = City::where('country_id', $id)->get();
        return self::makeSuccess(200, __("messages.success"), CitiesResource::collection($cities));

    }
}
