<?php

namespace App\Http\Controllers\Api\Roles;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Roles\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Trait\ApiResponse;

class RoleController extends Controller
{
    use ApiResponse;


    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name, team_id, and guard_name",
     *     tags={"Roles"},

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
     *                     property="name",
     *                     type="string",
     *                     description="English name",
     *                     example="Name"
     *                 ),
     *                 @OA\Property(
     *                     property="team_id",
     *                     type="string",
     *                     description="Arabic name",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="guard_name",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example="web"
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

    public function index()
    {
        $data = Role::with('permissions')->get();

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
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Add roles",
     *      tags={"Roles"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *         @OA\Parameter(
     *         name="team_id",
     *         in="query",
     *         description="Team Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="permission",
     *         in="query",
     *         description="permission",
     *         @OA\Schema(type="string")
     *     ),

     *     @OA\Response(response="201", description="Roles registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function store(RoleRequest $request)
    {

        $request_data = $request->except('permissions');
        $request_data['created_by'] = auth()->user()->id ?? null;

        $data = Role::create($request_data);

        if ($request->has('permissions')) {
            $all_permissions = array_merge($request->permissions, []);
            $data->syncPermissions($all_permissions);

        }

        return self::makeSuccess(200, __('messages.created_successfully'), $data);


    }


    /**
     * @OA\Get(
     *      path="/api/roles/{id}",
     *      operationId="getRoleById",
     *      tags={"Roles"},
     *      summary="Get Role information",
     *      description="Returns Role data",
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
     *          description="Role id",
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
        $data = Role::with('permissions')->find($id);
        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404 , __('messages.not_found') );

            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), $data);

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
     *      path="/api/roles/{id}",
     *      operationId="updateRole",
     *      tags={"Roles"},
     *      summary="Update existing role",
     *      description="Returns updated role data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Role id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *               @OA\Parameter(
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
     *          @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="Name Role",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *           @OA\Parameter(
     *           name="team_id",
     *           description="Team id",
     *           in="query",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
     *             @OA\Parameter(
     *           name="permission",
     *           description="permission",
     *           in="query",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
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
    function update(RoleRequest $request, string $id)
    {
        $data = Role::find($id);

        $data->update($request->except('permissions'));
        if ($request->has('permissions')) {
            $all_permissions = array_merge($request->permissions, []);
            $data->permissions()->detach();
            $data->syncPermissions($all_permissions);
        } else {
            $data->permissions()->detach();
        }

        return self::makeSuccess(200, __('messages.updated_successfully'), $data);

    }


    /**
     * @OA\Delete(
     *      path="/api/roles/{id}",
     *      operationId="deleteRoles",
     *      tags={"Roles"},
     *      summary="Delete existing role",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Role id",
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
        $data = Role::find($id);
        if(!$data){
            return self::makeError(404 , __('messages.not_found') );
        }
        $data->permissions()->detach();
        $data->delete();
        return self::makeSuccess(200, __('messages.delete_successfully'));

    }
}
