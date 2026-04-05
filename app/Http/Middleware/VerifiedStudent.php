<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedStudent
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 🔥 Admin bypass
        if ($user->role->role_name === 'Admin') {
            return $next($request);
        }
        $latest = $user->latestVerification;

        $isValid =
            $latest &&
            $latest->status === 'verified' &&
            $latest->semester === currentSemester() &&
            $latest->academic_year === currentAcademicYear();

        if (!$isValid && $user->account_status !== 'inactive') {
            $user->update(['account_status' => 'inactive']);
        }

        if ($isValid && $user->account_status !== 'active') {
            $user->update(['account_status' => 'active']);
        }

        // 🔥 If inactive → force verify page
        if ($user->account_status !== 'active') {

            // allow access ONLY to verify page
            if (!$request->routeIs('verify.page')) {
                return redirect()->route('verify.page');
            }
        }

        return $next($request);
    }
}
