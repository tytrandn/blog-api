<?php

namespace App\Modules\User\Controllers;

use App\Modules\User\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use OpenApi\Annotations as OA;
use App\Helpers\ApiResponse;
use App\Helpers\HttpStatusCode;
use App\Modules\User\Services\UserService;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-16T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-16T00:00:00Z")
 * )
 */
class UserController extends BaseController
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get a list of users",
     *     description="Fetch a list of all users",
     *     @OA\Response(
     *         response=200,
     *         description="A list of users",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function index()
    {

        $users = $this->userService->getAllUsers();

        return ApiResponse::success($users, 'Users retrieved successfully');

    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a new user",
     *     description="Create a new user with required fields",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid input")
     *         )
     *     )
     * )
     */
    public function store(UserRequest $request)
    {

        $user = $this->userService->createUser($request->validated());

        return ApiResponse::success($user, 'Create user successfully', HttpStatusCode::CREATED);

    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get a single user",
     *     description="Fetch details of a single user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User found",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show($id)
    {

        $user = $this->userService->getUserById($id);

        return ApiResponse::success($user, 'User retrieved successfully');

    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Update user",
     *     description="Update user details",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid input")
     *         )
     *     )
     * )
     */
    public function update(UserRequest $request, $id)
    {

        $user = $this->userService->updateUser($id, $request->validated());

        return ApiResponse::success($user, 'User updated successfully');

    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete a user",
     *     description="Delete a user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="User deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->userService->deleteUser($id);

        return ApiResponse::message('User deleted successfully', HttpStatusCode::NO_CONTENT);
    }
}
