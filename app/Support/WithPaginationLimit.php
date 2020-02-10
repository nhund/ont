<?php

namespace App\Support;

use Illuminate\Http\Request;

trait WithPaginationLimit
{
    /**
     * Get pagination limit from the request data or default to the default limit.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $key
     * @param  integer|null $default
     * @return \Illuminate\Config\Repository|int|mixed
     */
    public function getPaginationLimit(Request $request, $key = 'limit', $default = null)
    {
        $default = $default ?? 10;

        return ($request->filled($key) && is_numeric($request->get($key))) ? (int) $request->get($key) : $default;
    }
}
