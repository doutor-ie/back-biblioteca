<?php

namespace App\Http\Middleware;

use App\Models\Roles;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidatePermission
{
    public function handle(Request $request, Closure $next, $permissionName = null)
    {
        if (!Roles::validateFilialPermission(
            Auth::id(),
            $permissionName,
            $request->header('filial', $request->filial_id)
        )) {
            return response()->json(['status' => 'unauthorized'], 401);
        }
        return $next($request);
    }
}
