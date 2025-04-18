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
}