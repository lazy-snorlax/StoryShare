<?php

namespace App\Http\Middleware;

use App\Support\Enums\UserRole;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VerifyAdminUser
{
    public function handle(Request $request, $next) 
    {
        if ($request->user()->isNotA(UserRole::Admin->value)) {
            throw new BadRequestHttpException('This user does not have admin role assigned.');
        }
        return $next($request);
    }
}