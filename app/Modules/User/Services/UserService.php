<?php

namespace App\Modules\User\Services;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Repositories\ConfigRepository;

class UserService
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
     * Get all users from the cache or the database.
     *
     * This method checks if the users data is available in the Redis cache.
     * If not, it retrieves the data from the database and stores it in the cache for a specified duration.
     *
     * @return \Illuminate\Database\Eloquent\Collection|User[] The list of all users.
     */
    public function getAllUsers()
    {
        return Cache::store('redis')->remember('users.all', now()->addMinutes($this->configRepository->getCacheExpiration()), function () {
            return User::all();
        });
    }

    /**
     * Get a specific user by their ID from the cache or the database.
     *
     * This method checks if the user with the given ID is available in the Redis cache.
     * If not, it retrieves the data from the database and stores it in the cache for a specified duration.
     *
     * @param int $id The ID of the user to retrieve.
     * @return User The user with the given ID.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user with the given ID is not found.
     */
    public function getUserById($id)
    {
        return Cache::store('redis')->remember("user_{$id}", now()->addMinutes($this->configRepository->getCacheExpiration()), function () use ($id) {
            return User::findOrFail($id);
        });
    }

    /**
     * Create a new user.
     *
     * @param array $data The data for the new user.
     * @return User The created user.
     */
    public function createUser(array $data)
    {
        return User::create($data);
    }

    /**
     * Update an existing user by their ID.
     *
     * @param int $id The ID of the user to update.
     * @param array $data The data to update the user with.
     * @return User The updated user.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user with the given ID is not found.
     */
    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    /**
     * Delete a user by their ID.
     *
     * @param int $id The ID of the user to delete.
     * @return bool True if the user was successfully deleted, false otherwise.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user with the given ID is not found.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }
}
