<?php

namespace App\Http\Middleware;

use App\Constants\ApiStatus;
use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = $this->getRequiredRoleForRoute($request->route());

        if($request->user()->hasRole($roles) || !$roles) {
            return $next($request);
        }
        return response()->json(['message' => 'Você não está autorizado a acessar este recurso'], ApiStatus::forbidden);
    }

    private function getRequiredRoleForRoute($route){
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}
