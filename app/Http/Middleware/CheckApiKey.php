<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;
use App\Models\ApiKey;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->key_id || !$request->secret) {
            return response(['errors' => ['Key ID and Secret required']], 422);
        }

        $apiKey = ApiKey::where('uuid', $request->key_id)->first();

        if (!$apiKey) {
            return response(['errors' => ['Key not found']], 404);
        }

        if ($apiKey->revoked) {
            return response(['errors' => ['This key is revoked']], 422);
        }

        if (!Hash::check($request->secret, $apiKey->secret)) {
            return response(['errors' => ['Key mismatch']], 403);
        }

        return $next($request);
    }
}
