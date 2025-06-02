<?php

namespace App\Http\Controllers\Dashboard;

use Alert;
use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class RoleController extends Controller
{

    private RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index(RolesDataTable $roleRepository)
    {
        return $this->roleRepository->getAll($roleRepository);

    }

    /*----------------------------------------------------
    || Name     : open pages create                     |
    || Tested   : Done                                    |
    ||                                     |
     ||                                    |
     -----------------------------------------------------*/

    public function create()
    {
        return $this->roleRepository->create();


    }//end of create


    public function store(Request $request)
    {



        $request->validate([
            'name' => 'required|unique:roles|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
            'display_name' => 'required',
        ]);

        return $this->roleRepository->store($request);

    }//end of store


    public function edit(Role $role)
    {
        return $this->roleRepository->edit($role);


    }//end of role


    public function update(Request $request, role $role)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^[a-zA-ZÑñ\s]+$/',

            'display_name' => 'required',
        ]);
        return $this->roleRepository->update($role, $request);


    }//end of update


    public function destroy(role $role)
    {
        return $this->roleRepository->destroy($role);

    }//end of destroy
}//end of controller
