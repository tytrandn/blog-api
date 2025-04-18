<?php

namespace App\Modules\Post\Services;

use App\Modules\Post\Models\Post;
use Illuminate\Support\Facades\Cache;
use App\Repositories\ConfigRepository;

class PostService
{

    protected $configRepository;

    /**
     * PostService constructor.
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * Get all posts with user details from the cache or the database.
     * 
     * If the posts data is available in the Redis cache.
     * If not, it retrieves the data from the database and stores it in the cache for a specified duration.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Post[] The list of all posts with user information.
     */
    public function getAllPosts()
    {
        return Cache::store('redis')->remember('posts.all', now()->addMinutes($this->configRepository->getCacheExpiration()), function () {
            return Post::with('user')->get();
        });
    }

    /**
     * Get a specific post by its ID, with user details, from the cache or the database.
     * 
     * If the post with the given ID is available in the Redis cache.
     * If not, it retrieves the data from the database and stores it in the cache for a specified duration.
     *
     * @param int $id The ID of the post to retrieve.
     * @return Post The post with the given ID.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the post with the given ID is not found.
     */
    public function getPostById($id)
    {
        return Cache::store('redis')->remember("post_{$id}", now()->addMinutes($this->configRepository->getCacheExpiration()), function () use ($id) {
            return Post::with('user')->findOrFail($id);
        });
    }

    /**
     * Create a new post.
     *
     * @param array $data The data for the new post.
     * @return Post The created post.
     */
    public function createPost(array $data)
    {
        return Post::create($data);
    }

    /**
     * Update an existing post by its ID.
     *
     * @param int $id The ID of the post to update.
     * @param array $data The data to update the post with.
     * @return Post The updated post.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the post with the given ID is not found.
     */
    public function updatePost($id, array $data)
    {
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    /**
     * Delete a post by its ID.
     *
     * @param int $id The ID of the post to delete.
     * @return bool True if the post was successfully deleted, false otherwise.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the post with the given ID is not found.
     */
    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        return $post->delete();
    }
}
