<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class AdminBasicAuth
{
    public function handle(Request $request, Closure $next)
    {
        $ADMIN_USER = env('ADMIN_USER', 'admin');
        $ADMIN_PASS = env('ADMIN_PASS', 'secret');

        if (! $request->getUser() || ! $request->getPassword()
            || $request->getUser() !== $ADMIN_USER
            || $request->getPassword() !== $ADMIN_PASS) {
            $headers = ['WWW-Authenticate' => 'Basic'];
            return response('Unauthorized', 401, $headers);
        }
        return $next($request);
    }
}
