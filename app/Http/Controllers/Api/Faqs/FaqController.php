<?php

namespace App\Http\Controllers\Api\Faqs;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chains\Requests\Api\Pages\FaqRequest;
use App\Http\Resources\Api\Pages\FaqResource;
use App\Models\Pages\Faq;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/api/faqs",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with title_ar, title_en, status, category,body_ar,body_en, and published",
     *     tags={"Faqs"},

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
     *                     property="title_en",
     *                     type="string",
     *                     description="English name",
     *                     example="Title EN"
     *                 ),
     *                 @OA\Property(
     *                     property="title_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="اTitle AR"
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example="Category"
     *                 ),
     *                      @OA\Property(
     *                      property="body_ar",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="body_ar"
     *                  ),
     *                 @OA\Property(
     *                      property="body_en",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="body_en"
     *                  ),
     *                 @OA\Property(
     *                     property="published",
     *                     type="boolean",
     *                     description="Whether the entry is active",
     *                     example=true
     *                 ) ,
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

    public function index(Request $request)
    {
        if ($request->category) {

            $faqs = Faq::where('category', '=', $request->category)->where('published', '=', 1)->get();
        } elseif ($request->published) {

            $faqs = Faq::where('published', '=', 1)->get();

        } else {
            $faqs = Faq::get();


        }

        $data = FaqResource::collection($faqs);

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
     *     path="/api/faqs",
     *     summary="Add Faq",
     *      tags={"Faqs"},
     *     @OA\Parameter(
     *         name="title_en",
     *         in="query",
     *         description="Title English",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="title_ar",
     *         in="query",
     *         description="Title Arabic",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="category",
     *         @OA\Schema(type="string")
     *     ),
     *         @OA\Parameter(
     *         name="body_ar",
     *         in="query",
     *         description="Body Arabic",
     *         @OA\Schema(type="string")
     *     ),
     *     *     @OA\Parameter(
     *         name="body_en",
     *         in="query",
     *         description="Body English",
     *         @OA\Schema(type="string")
     *     ),
     *          @OA\Parameter(
     *         name="published",
     *         in="query",
     *         description="published",
     *         @OA\Schema(type="integer")
     *     ),
     *              @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="status",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Faq registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */


    public function store(FaqRequest $request)
    {

        $data_request = $request->all();
        $data_request['created_by'] = auth()->user()->id ?? null;
        $data = Faq::create($data_request);


        return self::makeSuccess(200, __('messages.created_successfully'), $data);


    }


    /**
     * @OA\Get(
     *      path="/api/faqs/{id}",
     *      operationId="getFaqById",
     *      tags={"Faqs"},
     *      summary="Get Faq information",
     *      description="Returns Faq data",
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
     *          description="Faq id",
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
        $data = Faq::find($id);
        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404 , __('messages.not_found') );

            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), FaqResource::make($data));

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
     *      path="/api/faqs/{id}",
     *      operationId="updateFaq",
     *      tags={"Faqs"},
     *      summary="Update existing Faq",
     *      description="Returns updated Faq data",
     *           @OA\Parameter(
     *           name="id",
     *           description="Faq id",
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
    name="title_en",
    in="query",
    description="Title English",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="title_ar",
    in="query",
    description="Title Arabic",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="category",
    in="query",
    description="category",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="body_ar",
    in="query",
    description="Body Arabic",
    @OA\Schema(type="string")
    ),
     *     @OA\Parameter(
    name="body_en",
    in="query",
    description="Body English",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="published",
    in="query",
    description="published",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="status",
    in="query",
    description="status",
    @OA\Schema(type="integer")
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
    function update(FaqRequest $request, string $id)
    {
        $data = Faq::find($id);

        $data->update($request->all());


        return self::makeSuccess(200, __('messages.updated_successfully'), $data);

    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/api/faqs/{id}",
     *      operationId="deleteFaq",
     *      tags={"Faqs"},
     *      summary="Delete existing Faq",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Faq id",
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
        $data = Faq::find($id);
        if(!$data){
            return self::makeError(404 , __('messages.not_found') );
        }
        $data->delete();
        return self::makeSuccess(200, __('messages.delete_successfully'));

    }

    /**
     * @OA\Post(
     *     path="/api/faqs/block",
     *     summary="Update Active Faq",
     *      tags={"Faqs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Faq Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Faq Updated Status successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function block(Request $request)
    {

        $data = Faq::find($request->id);
        if(!$data){
            return self::makeError(404 , __('messages.not_found') );
        }

        $status = ($data->published == true) ? false : true;

        $data->published = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }
}
