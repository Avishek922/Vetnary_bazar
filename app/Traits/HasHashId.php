<?php

namespace App\Traits;

use App\Helpers\HashIdHelper;

trait HasHashId
{
    /**
     * Get the obfuscated version of the ID.
     */
    public function getHashIdAttribute(): string
    {
        return HashIdHelper::encode($this->id);
    }

    /**
     * Use hash_id for route model binding.
     */
    public function getRouteKey()
    {
        return $this->hash_id;
    }

    /**
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $id = HashIdHelper::decode($value);
        if (!$id) return null;

        return $this->where('id', $id)->first();
    }
}
