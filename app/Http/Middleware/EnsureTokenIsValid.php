<?php

namespace App\Http\Middleware;

use App\Users\Models\Token;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $requestToken = $request->header('Authorization');

        if (is_null($requestToken)) {
            return response()->json(['permission_denied' => 'Need a token'], 403);
        }

        /** @var Token $tokenModel */
        $tokenModel = Token::query()
            ->where('token', '=', $requestToken)
            ->first();

        if (is_null($tokenModel)) {
            return response()->json(['permission_denied' => 'incorrect token'], 403);
        }

        if (now() > $tokenModel->expiration_date) {
            return response()->json([
                'permission_denied' => 'The token was overdue.',
                'tokens_ending_date' => $tokenModel->expiration_date,
                'request_time' => now(),
            ], 403);
        }

        return $next($request);
    }
}
