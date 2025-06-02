<?php

namespace App\Http\Controllers\Api\Pages;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chains\Requests\Api\Pages\PageRequest;
use App\Http\Resources\Api\Pages\PageResource;
use App\Models\Pages\Page;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/api/pages",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with title_ar, title_en, tags,description_en, description_ar,parent_page, and published",
     *     tags={"Pages"},
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
     *                     property="title_en",
     *                     type="string",
     *                     description="English name",
     *                     example="Title EN"
     *                 ),
     *                 @OA\Property(
     *                     property="title_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="Title AR"
     *                 ),
     *                 @OA\Property(
     *                     property="tags",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example="Tags"
     *                 ),
     *                      @OA\Property(
     *                      property="description_en",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="description_en"
     *                  ),
     *                @OA\Property(
     *                       property="description_ar",
     *                       type="string",
     *                       description="Code (5 characters max)",
     *                       example="description_ar"
     *                   ),
     *                 @OA\Property(
     *                      property="parent_page",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                     example="1"
     *                  ),
     *               @OA\Property(
     *                     property="published",
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

        if ($request->parent) {

            $pages = Page::where('parent_page', '=', $request->parent)->get();
        } elseif ($request->published) {

            $pages = Page::where('published', '=', 1)->get();

        } else {
            $pages = Page::get();

        }
        $data = PageResource::collection($pages);

        return self::makeSuccess(200,  __("messages.success"), $data);

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
     *     path="/api/pages",
     *     summary="Add Page",
     *      tags={"Pages"},
    @OA\Parameter(
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
    name="tags",
    in="query",
    description="tags",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="description_en",
    in="query",
    description="Description English",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="description_ar",
    in="query",
    description="Description Arabic",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="parent_page",
    in="query",
    description="Parent Page",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="published",
    in="query",
    description="Published",
    @OA\Schema(type="integer")
    ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function store(PageRequest $request)
    {
        $request_data=$request->all();
        $request_data['created_by'] = auth()->user()->id ?? null;

        $data = Page::create($request_data);


        return self::makeSuccess(200, __('messages.created_successfully'), $data);


    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *      path="/api/pages/{id}",
     *      operationId="getPageById",
     *      tags={"Pages"},
     *      summary="Get Page information",
     *      description="Returns Page data",
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
     *          description="Page id",
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
        $data =Page::find($id);
        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404 , __('messages.not_found') );

            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), PageResource::make($data));

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
     *      path="/api/pages/{id}",
     *      operationId="updatePage",
     *      tags={"Pages"},
     *      summary="Update existing Page",
     *      description="Returns updated Page data",
     *           @OA\Parameter(
     *           name="id",
     *           description="Page id",
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
    name="tags",
    in="query",
    description="tags",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="description_en",
    in="query",
    description="Description English",
    @OA\Schema(type="string")
    ),
     *     @OA\Parameter(
    name="description_ar",
    in="query",
    description="Description Arabic",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="parent_page",
    in="query",
    description="Parent Page",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="published",
    in="query",
    description="Published",
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
    function update(PageRequest $request, string $id)
    {
        $data = Page::find($id);

        $data->update($request->all());


        return self::makeSuccess(200, __('messages.updated_successfully'), $data);

    }

    /**
     * Remove the specified resource from storage.
     */


    /**
     * @OA\Delete(
     *      path="/api/pages/{id}",
     *      operationId="deletePage",
     *      tags={"Pages"},
     *      summary="Delete existing Page",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Page id",
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
        $data = Page::find($id);
        if(!$data){
            return self::makeError(404 , __('messages.not_found') );
        }
        $data->delete();
        return self::makeSuccess(200, __('messages.delete_successfully'));

    }

    /**
     * @OA\Post(
     *     path="/api/page/block",
     *     summary="Update Active Page",
     *      tags={"Pages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Page Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Page Updated Active successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function block(Request $request)
    {

        $data = Page::find($request->id);
        if(!$data){
            return self::makeError(404 , __('messages.not_found') );
        }

        $status = ($data->status == 0) ? 1 : 0;

        $data->status = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }
}
