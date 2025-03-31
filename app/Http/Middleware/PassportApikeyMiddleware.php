<?php
namespace App\Http\Middleware;
namespace App\Http\Middleware;

use Closure;
use Laravel\Passport\TokenRepository;
use Illuminate\Http\JsonResponse;

class PassportApikeyMiddleware
{
    public function handle($request, Closure $next)
    {
        // Lấy Authorization header
        $authorizationHeader = $request->header('Authorization');
        \Log::info('Authorization header converted', [$authorizationHeader]);
        // Nếu header bắt đầu bằng "Apikey ", thay thế bằng "Bearer "
        if ($authorizationHeader && str_starts_with($authorizationHeader, 'Apikey ')) {
            $newAuthorizationHeader = str_replace('Apikey ', 'Bearer ', $authorizationHeader);
            $request->headers->set('Authorization', $newAuthorizationHeader);
            \Log::info('Authorization header converted', [$newAuthorizationHeader]);
        }
        if (\Auth::guard('api')->check()) {
            return $next($request);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
