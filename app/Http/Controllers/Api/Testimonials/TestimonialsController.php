<?php

namespace App\Http\Controllers\Api\Testimonials;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Amenities\AmenitiesRequest;
use App\Http\Requests\Api\Testimonials\TestimonialRequest;
use App\Http\Resources\Api\Amenities\AmenitiesResource;
use App\Http\Resources\Api\Testimonials\TestimonialResource;
use App\Models\Amenities\Amenity;
use App\Models\Testimonials\Testimonial;
use App\Services\Amenities\AmenitiesService;
use App\Services\Testimonials\TestimonialService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialsController extends Controller
{
    use ApiResponse;

    public function __construct(readonly TestimonialService $testimonialservice)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/testimonials",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with submission_date, rating,Published,Status,review_text_ar,review_text_en,user_id, and active",
     *     tags={"Testimonials"},

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
     *                     property="name_ar",
     *                     type="date",
     *                     description="name arabic",
     *                     example="name_ar"
     *                 ),
     *                      @OA\Property(
     *                     property="name_en",
     *                     type="date",
     *                     description="name english",
     *                     example="name_en"
     *                 ),
     *                         @OA\Property(
     *                     property="position",
     *                     type="date",
     *                     description="position",
     *                     example="position"
     *                 ),
     *                     @OA\Property(
     *                     property="submission_date",
     *                     type="date",
     *                     description="English name",
     *                     example="submission_date"
     *                 ),
     *             @OA\Property(
     *                     property="review_text_en",
     *                     type="date",
     *                     description="English name",
     *                     example="Review Text EN"
     *                 ),
     *        @OA\Property(
     *                     property="review_text_ar",
     *                     type="date",
     *                     description="Arabic name",
     *                     example="Review Text Ar"
     *                 ),
     *                 @OA\Property(
     *                     property="rating",
     *                     type="string",
     *                     description="Rating",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="Published",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example=true
     *                 ),
     *             @OA\Property(
     *                     property="user_id",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example=1
     *                 ),
     *                @OA\Property(
     *                     property="Status",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example=true
     *                 ),
     *            @OA\Property(
     *                     property="active",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example=true
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
            $wheres[] = ['review_text_ar', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['review_text_en', 'like', '%' . $request->search . '%'];
        }

        $result = $this->testimonialservice->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __("messages.success"), TestimonialResource::collection($result), !$is_paginate);


    }


    /**
     * @OA\Get(
     *     path="/api/testimonials/get-active",
     *     summary="Get a list of Active entries with columns",
     *     description="Retrieve a list of entries with submission_date, rating,Published,Status,review_text_ar,review_text_en,user_id, and active",
     * *    tags={"Testimonials"},

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
    @OA\Property(
    property="name_ar",
    type="string",
    description="name_ar",
    example="name_ar"
    ),
     *      @OA\Property(
    property="name_en",
    type="string",
    description="name_en",
    example="name_en"
    ),
     *
     *           @OA\Property(
    property="position",
    type="string",
    description="position",
    example="position"
    ),
     *
     *       @OA\Property(
    property="submission_date",
    type="date",
    description="submission_date",
    example="submission_date"
    ),
    @OA\Property(
    property="review_text_en",
    type="string",
    description="English name",
    example="Review Text EN"
    ),
    @OA\Property(
    property="review_text_ar",
    type="string",
    description="Arabic name",
    example="Review Text Ar"
    ),
    @OA\Property(
    property="rating",
    type="string",
    description="Rating",
    example=1
    ),
    @OA\Property(
    property="Published",
    type="string",
    description="Code (5 characters max)",
    example=true
    ),
    @OA\Property(
    property="user_id",
    type="ineger",
    description="Code (5 characters max)",
    example=1
    ),
    @OA\Property(
    property="Status",
    type="string",
    description="Code (5 characters max)",
    example=true
    ),
    @OA\Property(
    property="active",
    type="string",
    description="Code (5 characters max)",
    example=true
    ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No entries found"
     *     )
     * )
     */
    public function getActive()
    {
        $data = TestimonialResource::collection(Testimonial::where('active', '=', 1)->get());

        return self::makeSuccess(200, __("messages.success"), $data);


    }

    /**
     * @OA\Get(
     *     path="/api/testimonials/get-publish",
     *     summary="Get a list of Publish entries with columns",
     *     description="Retrieve a list of entries with submission_date, rating,Published,Status,review_text_ar,review_text_en,user_id, and active",
     * *     tags={"Testimonials"},




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
    @OA\Property(
    property="submission_date",
    type="date",
    description="English name",
    example="submission_date"
    ),
     *        @OA\Property(
    property="name_ar",
    type="string",
    description="name_ar",
    example="name_ar"
    ),
    @OA\Property(
    property="name_en",
    type="string",
    description="name_en",
    example="name_en"
    ),
     *
     *       @OA\Property(
    property="position",
    type="string",
    description="position",
    example="position"
    ),
    @OA\Property(
    property="review_text_en",
    type="string",
    description="English name",
    example="Review Text EN"
    ),
    @OA\Property(
    property="review_text_ar",
    type="string",
    description="Arabic name",
    example="Review Text Ar"
    ),
    @OA\Property(
    property="rating",
    type="string",
    description="Rating",
    example=1
    ),
    @OA\Property(
    property="Published",
    type="string",
    description="Code (5 characters max)",
    example=true
    ),
    @OA\Property(
    property="user_id",
    type="string",
    description="Code (5 characters max)",
    example=1
    ),
    @OA\Property(
    property="Status",
    type="string",
    description="Code (5 characters max)",
    example=true
    ),
    @OA\Property(
    property="active",
    type="string",
    description="Code (5 characters max)",
    example=true
    ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No entries found"
     *     )
     * )
     */
    public function getPublish()
    {
        $data = TestimonialResource::collection(Testimonial::where('Published', '=', 1)->get());

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
     * Store a newly created resource in storage.
     */


    /**
     * @OA\Post(
     *     path="/api/testimonials",
     *     summary="Add Testimonial",
     *      tags={"Testimonials"},
    @OA\Parameter(
    name="name_ar",
    in="query",
    description="name_ar",
    required=true,
    @OA\Schema(type="string")
    ),
     *        @OA\Parameter(
    name="name_en",
    in="query",
    description="name_en",
    required=true,
    @OA\Schema(type="string")
    ),
     *             @OA\Parameter(
    name="position",
    in="query",
    description="position",
    required=true,
    @OA\Schema(type="string")
    ),
     *      @OA\Parameter(
    name="submission_date",
    in="query",
    description="Submission Date",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="rating",
    in="query",
    description="Rating",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="Published",
    in="query",
    description="Published",
    @OA\Schema(type="integer")
    ),

    @OA\Parameter(
    name="active",
    in="query",
    description="active",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="Status",
    in="query",
    description="Status",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="user_id",
    in="query",
    description="user_id",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="review_text_ar",
    in="query",
    description="Review Text Arabic",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="review_text_en",
    in="query",
    description="Review Text English",
    @OA\Schema(type="string")
    ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function store(TestimonialRequest $request)
    {

        $request_data = $request->all();
        $request_data['Status'] = 'Pending';
//        $request_data['user_id'] = Auth::id() ?? null;
        $request_data['created_by'] = Auth::id() ?? null;
        $data = Testimonial::create($request_data);


        return self::makeSuccess(200, __('messages.created_successfully'), $data);


    }

    /**
     * Display the specified resource.
     */


    /**
     * @OA\Get(
     *      path="/api/testimonials/{id}",
     *      operationId="getTestimonialById",
     *      tags={"Testimonials"},
     *      summary="Get Testimonial information",
     *      description="Returns Testimonial data",
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
     *          description="Testimonial id",
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
        $data = Testimonial::find($id);
        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404, __('messages.not_found'));

            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), TestimonialResource::make($data));

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
     *      path="/api/testimonials/{id}",
     *      operationId="updateTestimonial",
     *      tags={"Testimonials"},
     *      summary="Update existing Testimonial",
     *      description="Returns updated Testimonial data",
     *           @OA\Parameter(
     *           name="id",
     *           description="Testimonial id",
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
     *         @OA\Parameter(
    name="name_en",
    in="query",
    description="name_en",
    required=true,
    @OA\Schema(type="string")
    ),
     *            @OA\Parameter(
    name="position",
    in="query",
    description="position",
    required=true,
    @OA\Schema(type="string")
    ),
     *         @OA\Parameter(
    name="submission_date",
    in="query",
    description="Submission Date",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="rating",
    in="query",
    description="Rating",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="Published",
    in="query",
    description="Published",
    @OA\Schema(type="integer")
    ),
     *
     *      @OA\Parameter(
    name="active",
    in="query",
    description="active",
    @OA\Schema(type="integer")
    ),
     *      @OA\Parameter(
    name="Status",
    in="query",
    description="Status",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="user_id",
    in="query",
    description="user_id",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="review_text_ar",
    in="query",
    description="Review Text Arabic",
    @OA\Schema(type="string")
    ),
     *      @OA\Parameter(
    name="review_text_en",
    in="query",
    description="Review Text English",
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
    function update(TestimonialRequest $request, string $id)
    {

        $data = Testimonial::find($id);

        $data->update($request->all());


        return self::makeSuccess(200, __('messages.updated_successfully'), $data);

    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/api/testimonials/{id}",
     *      operationId="deleteTestimonial",
     *      tags={"Testimonials"},
     *      summary="Delete existing Testimonial",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Testimonial id",
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
        $data = Testimonial::find($id);
        if (!$data) {
            return self::makeError(404, __('messages.not_found'));
        }
        $data->delete();
        return self::makeSuccess(200, __('messages.delete_successfully'));

    }


    /**
     * @OA\Post(
     *     path="/api/testimonials/update-publish",
     *     summary="Update Publish testimonials",
     *      tags={"Testimonials"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Testimonial Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Testimonial Updated Publish successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function updatePublish(Request $request)
    {
        $data = Testimonial::find($request->id);
        if (!$data) {
            return self::makeError(404, __('messages.not_found'));
        }
        $status = ($data->Published == 0) ? 1 : 0;
        $data->Published = $status;
        $data->save();
        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }

    /**
     * @OA\Post(
     *     path="/api/testimonials/update-active",
     *     summary="Update Active testimonials",
     *      tags={"Testimonials"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Testimonial Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Testimonial Updated Active successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function updateActive(Request $request)
    {
        $data = Testimonial::find($request->id);
        if (!$data) {
            return self::makeError(404, __('messages.not_found'));
        }
        $status = ($data->active == 0) ? 1 : 0;
        $data->active = $status;
        $data->save();
        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }


    /**
     * @OA\Post(
     *     path="/api/testimonials/update-status",
     *     summary="Update Status testimonials",
     *      tags={"Testimonials"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Testimonial Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *          @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="Testimonial Updated Status successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function updateStatus(Request $request)
    {
        $data = Testimonial::find($request->id);
        if (!$data) {
            return self::makeError(404, __('messages.not_found'));
        }
        $data->update(['Status' => $request->status]);
        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }

}
