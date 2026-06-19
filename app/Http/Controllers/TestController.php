<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group Manage Users
 *
 * APIs for managing Users
*/
class TestController extends Controller
{

    /**
     * Get Specific User
     *
     * Get Specific User by his id
     *
     * @header Authorization Bearer {token}
     *
     * @urlParam id required The id of the user. Example: 1
     * @response 200 {
     *     "id": 1,
     *     "name": "Karim Aouaouda",
     *     "email": "example@gmail.com"
     * }
     *
     * @response 404 {
     *     "message": "User not found"
     * }
     *
     * @response 401 scenario="Unauthenticated" {
     *     "message": "Unauthenticated."
     * }
     *
     * @responseField id integer The id of the user.
     * @responseField name string The name of the user.
     * @responseField email string The email of the user.
     *
     * @bodyParam user_id integer required The id of the user. Example: 1
    */
    public function index(User $user){
        return UserResource::make($user);
    }

    /**
     * Get All Users
     *
     * Get all users from database
     *
     * @group Manage Else
     * @authenticated
     *
     * @response 200 [
     *      {
     *          "name": "karim"
     *      }
     * ]
    */
    public function fetchAll()
    {
        return User::all();
    }
}
