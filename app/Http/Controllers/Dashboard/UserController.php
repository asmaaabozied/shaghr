<?php

namespace App\Http\Controllers\Dashboard;

use Alert;
use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\TwoFactorService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class UserController extends Controller
{


    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(UsersDataTable $usersDataTable)
    {

        return $this->userRepository->getAll($usersDataTable);

    }


    public function show($id)
    {
        return $this->userRepository->show($id);


    }


    public function create()
    {

        return $this->userRepository->create();


    }//end of create


    public function store(Request $request)
    {
        $request->validate([

            'email' => 'required|email|string|unique:users',
            'phone' => 'required|string|unique:users',

            'password' => 'required|confirmed',
        ],
            [
                'password.regex' => __('site.password_regex'),
            ]
        );


        return $this->userRepository->store($request);

    }//end of store

    /*----------------------------------------------------
      || Name     : redirect to edit pages          |
      || Tested   : Done                                    |
      ||                                     |
     ||                                    |
       -----------------------------------------------------*/

    public function edit($id)
    {
        return $this->userRepository->edit($id);


    }//end of user

    /*----------------------------------------------------
     || Name     : update data into database using users        |
     || Tested   : Done                                    |
       ||                                     |
        ||                                    |
           -----------------------------------------------------*/

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', Rule::unique('users')->ignore($user->id)],

        ]);

        return $this->userRepository->update($user, $request);


    }//end of update

    /*----------------------------------------------------
 || Name     : delete data into database using users        |
 || Tested   : Done                                    |
 ||                                     |
 ||                                    |
   -----------------------------------------------------*/

    public function destroy(User $user)
    {

        return $this->userRepository->destroy($user);


    }//end of destroy

}
