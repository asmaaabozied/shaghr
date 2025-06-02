<?php

namespace App\Http\Controllers\Api\Rooms;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rooms\FacilityRequest;
use App\Http\Resources\Api\Rooms\FacilityResource;
use App\Models\Rooms\Facility;
use App\Services\Rooms\FacilityService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    use ApiResponse;

    public function __construct(readonly FacilityService $facilityService)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/facilities",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name_ar, name_en,active,description_en,description_ar, and image",
     *     tags={"Facilities"},
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
     *                     property="name_ar",
     *                     type="string",
     *                     description="name_ar",
     *                 ),
     *                 @OA\Property(
     *                     property="name_en",
     *                     type="string",
     *                     description="name_en",
     *                 ),
     *                 @OA\Property(
     *                     property="active",
     *                     type="string",
     *                     description="active",
     *                   
     *                 ),
     *                    @OA\Property(
     *                     property="image",
     *                     type="file",
     *                     description="image",
     *                   
     *                 ),
     *               
     *   @OA\Property(
     *                     property="description_ar",
     *                     type="string",
     *                     description="description_ar",
     *                   
     *                 ),
     * 
     *       @OA\Property(
     *                     property="description_en",
     *                     type="string",
     *                     description="description_en",
     *                   
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

    public function index(Request $request)
    {

        $wheresIn = $with = $wheres = $withCount = $orWheres = [];
        $is_paginate = $request->is_paginate ?? 0;
        if ($request->search) {
            $wheres[] = ['name_ar', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['name_en', 'like', '%' . $request->search . '%'];
        }

        $result = $this->facilityService->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __("messages.success"), FacilityResource::collection($result), !$is_paginate);


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
     *     path="/api/facilities",
     *     summary="Add facilities",
     *      tags={"Facilities"},


     *       @OA\Parameter(
    name="name_ar",
    in="query",
    description="name_ar",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="name_en",
    in="query",
    description="name_en",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="active",
    in="query",
    description="active",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="image",
    in="query",
    description="image",
    @OA\Schema(type="string")
    ),
     @OA\Parameter(
    name="description_ar",
    in="query",
    description="description_ar",
    @OA\Schema(type="string")
    ),
     @OA\Parameter(
    name="description_en",
    in="query",
    description="description_en",
    @OA\Schema(type="string")
    ),
     *     @OA\Response(response="201", description="facilities registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */


    public function store(FacilityRequest $request)
    {
        $request_data = $request->except('image');
        $request_data['created_by'] = auth()->user()->id;
        $data = Facility::create($request_data);

        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/facilities/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->image = $filename;
            $data->save();
        }


        return self::makeSuccess(200, __('messages.created_successfully'), $data);


    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *      path="/api/facilities/{id}",
     *      operationId="getfacilitiesById",
     *      tags={"Facilities"},
     *      summary="Get facilities information",
     *      description="Returns facilities data",
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
     *          description="Facility id",
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


    public
    function show(string $id)
    {
        $data = Facility::find($id);
        try {
            if (!$data) {
                // Handle the case where the Facility is not found
                return self::makeError(404, __('messages.not_found'));

            }
            // Return success if the Facility is found
            return self::makeSuccess(200, __("messages.success"), FacilityResource::make($data));

        } catch (\Throwable $th) {
            // Handle any other exceptions
            return self::makeError(400, $th->getMessage());
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *      path="/api/facilities/{id}",
     *      operationId="updateafacilities",
     *      tags={"Facilities"},
     *      summary="Update existing facilities",
     *      description="Returns updated facilities data",
     *           @OA\Parameter(
     *           name="id",
     *           description="facility id",
     *           required=true,
     *           in="path",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
     *          @OA\Parameter(
     *              name="Accept-Language",
     *              in="header",
     *              description="Set language parameter",
     *              @OA\Schema(
     *                  type="string",
     *                  enum={"en", "ar"},
     *                  default="en"
     *              ),
     *              example="en"
     *       ),
     *            @OA\Parameter(
     *               name="_method",
     *               in="header",
     *               example="put"
     *        ),

     *     @OA\Parameter(
    name="name_ar",
    in="query",
    description="name_ar",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="name_en",
    in="query",
    description="name_en",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="active",
    in="query",
    description="active",
    @OA\Schema(type="string")
    ),
       @OA\Parameter(
    name="image",
    in="query",
    description="image",
    @OA\Schema(type="string")
    ),
        @OA\Parameter(
    name="description_ar",
    in="query",
    description="description_ar",
    @OA\Schema(type="string")
    ),
          @OA\Parameter(
    name="description_en",
    in="query",
    description="description_en",
    @OA\Schema(type="string")
    ),
    
  

     *      @OA\Response(
     *          response=202,
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
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */


    public
    function update(FacilityRequest $request, string $id)
    {
        $request_data = $request->except('image');
        $data = Facility::find($id);
        $data->update($request_data);
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/facilities/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->image = $filename;
            $data->save();
        }

        return self::makeSuccess(200, __('messages.updated_successfully'), $data);

    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/api/facilities/{id}",
     *      operationId="deletefacilities",
     *      tags={"Facilities"},
     *      summary="Delete existing Facility",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Facility id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */


    public
    function destroy(string $id)
    {
        $data = Facility::find($id);
        if (!$data) {
            return self::makeError(404, __('messages.not_found'));
        }
        $data->delete();
        return self::makeSuccess(200, __('messages.delete_successfully'));

    }

}
