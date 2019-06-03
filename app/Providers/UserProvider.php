<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Str;

class UserProvider extends EloquentUserProvider
{

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return;
        }
        $query = $this->createModel()->newQuery();
        foreach ($credentials as $key => $value) {
            if (!Str::contains($key, 'password')) {
                if ($key == 'login') {
                    $query->where(function ($subquery) use ($value) {
                        $subquery->where('username', $value)->orWhere('email', $value);
                    });
                } else {
                    $query->where($key, $value);
                }
            }
        }
        $query->whereNull('banned_at');
        return $query->first();
    }

}
