<?php

namespace App\Modules\Post\Controllers;

use App\Modules\Post\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use OpenApi\Annotations as OA;
use App\Helpers\ApiResponse;
use App\Helpers\HttpStatusCode;
use App\Modules\Post\Services\PostService;

/**
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Post Title"),
 *     @OA\Property(property="content", type="string", example="Content of the post"),
 *     @OA\Property(property="author_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-16T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-16T00:00:00Z")
 * )
 */
class PostController extends BaseController
{

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get a list of posts",
     *     description="Fetch a list of all posts",
     *     @OA\Response(
     *         response=200,
     *         description="A list of posts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         )
     *     )
     * )
     */
    public function index() 
    {

        $posts = $this->postService->getAllPosts();

        return ApiResponse::success($posts, 'Posts retrieved successfully');

    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     description="Create a new post with required fields",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content", "author_id"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="author_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
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
    public function store(PostRequest $request)
    {

        $post = $this->postService->createPost($request->validated());

        return ApiResponse::success($post, 'Create post successfully', HttpStatusCode::CREATED);

    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a single post",
     *     description="Fetch details of a single post by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post found",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function show($id)
    {

        $post = $this->postService->getPostById($id);

        return ApiResponse::success($post, 'Post retrieved successfully');

    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Update post",
     *     description="Update post details",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content", "author_id"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="author_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
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
    public function update(PostRequest $request, $id)
    {

        $post = $this->postService->updatePost($id, $request->validated());

        return ApiResponse::success($post, 'Post updated successfully');

    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete a post",
     *     description="Delete a post by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function destroy($id)
    {

        $this->postService->deletePost($id);

        return ApiResponse::message('Post deleted successfully', HttpStatusCode::NO_CONTENT);

    }
}
