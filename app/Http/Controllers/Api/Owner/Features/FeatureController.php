<?php

namespace App\Http\Controllers\Api\Owner\Features;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Features\FeatureRequest;
use App\Http\Resources\Api\Pages\FeatureResource;
use App\Models\Pages\Feature;
use App\Services\Pages\FeatureService;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;


class FeatureController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/api/features",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name_ar, name_en, description_ar,description_en, status, and image",
     *     tags={"Features"},

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
     *                 @OA\Property(
     *                     property="description_ar",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example="description_ar"
     *                 ),
     *                      @OA\Property(
     *                      property="description_en",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="description_en"
     *                  ),
     *                 @OA\Property(
     *                      property="image",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                     example="http://example.com/image.png"
     *                  ),
     *               @OA\Property(
     *                     property="status",
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

    public function index()
    {
        $data = FeatureResource::collection(Feature::get());

        return self::makeSuccess(200, __("messages.success"), $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/features",
     *     summary="Add features",
     *      tags={"Features"},
     *     @OA\Parameter(
     *         name="name_en",
     *         in="query",
     *         description="Name English",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *         @OA\Parameter(
     *         name="name_ar",
     *         in="query",
     *         description="Name Arabic",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *         @OA\Parameter(
     *         name="description_ar",
     *         in="query",
     *         description="Description Arabic",
     *
     *         @OA\Schema(type="string")
     *     ),
     *            @OA\Parameter(
     *         name="description_en",
     *         in="query",
     *         description="Description English",
     *
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="status",
     *         @OA\Schema(type="integer")
     *     ),
     *         @OA\Parameter(
     *         name="image",
     *         in="query",
     *         description="Image",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="Feature registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function store(FeatureRequest $request)
    {
        $request_data = $request->except('image');
        $request_data['created_by'] = auth()->user()->id ?? null;

        $data = Feature::create($request_data);

        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/features/';
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
     *      path="/api/features/{id}",
     *      operationId="getFeatureById",
     *      tags={"Features"},
     *      summary="Get Feature information",
     *      description="Returns Feature data",
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
     *          description="Feature id",
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
        $data = Feature::find($id);
        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404, __("messages.data"));
            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), FeatureResource::make($data));

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
     *      path="/api/features/{id}",
     *      operationId="updateFeature",
     *      tags={"Features"},
     *      summary="Update existing Feature",
     *      description="Returns updated Feature data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Feature id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
    @OA\Parameter(
    name="Accept-Language",
    in="header",
    description="Set language parameter",
    @OA\Schema(
    type="string",
    enum={"en", "ar"},
    default="en"
    ),
    example="en"
    ),
    @OA\Parameter(
    name="_method",
    in="header",
    example="put"
    ),
    @OA\Parameter(
    name="name_en",
    in="query",
    description="Name English",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="name_ar",
    in="query",
    description="Name Arabic",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="description_ar",
    in="query",
    description="Description Arabic",

    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="description_en",
    in="query",
    description="Description English",

    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="status",
    in="query",
    description="status",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="image",
    in="query",
    description="Image",
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
    function update(FeatureRequest $request, string $id)
    {
        $data = Feature::find($id);

        $data->update($request->except('image'));
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/features/';
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
     *      path="/api/features/{id}",
     *      operationId="deleteFeature",
     *      tags={"Features"},
     *      summary="Delete existing Feature",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Feature id",
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
        $data = Feature::find($id);


        $data->delete();


        return self::makeSuccess(200, __('messages.delete_successfully'));

    }


    /**
     * @OA\Post(
     *     path="/api/feature/block",
     *     summary="Update Active Feature",
     *      tags={"Features"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Feature Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Feature Updated Active successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function block(Request $request)
    {


        $data = Feature::find($request->id);

        $status = ($data->status == 0) ? 1 : 0;

        $data->status = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }
}
