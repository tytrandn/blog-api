<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Config;

class ConfigRepository
{
    /**
     * Get the cache expiration time.
     *
     * @return int The cache expiration time in minutes.
     */
    public function getCacheExpiration(): int
    {
        return Config::get('cache.cache_expiration_time', 10);
    }

    /**
     * Get the API rate limit per minute.
     *
     * @return int The API rate limit.
     */
    public function getApiRateLimit(): int
    {
        return Config::get('ratelimit.limits.api', 60);
    }
}