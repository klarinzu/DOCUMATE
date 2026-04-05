<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureStudentIsVerified
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) return redirect('/login');

        // Admin bypass
        if ($user->role->role_name === 'Admin') {
            return $next($request);
        }

        $latest = $user->latestVerification;

        $needsVerification = (
            !$latest ||
            $latest->status !== 'verified' ||
            $latest->semester !== currentSemester() ||
            $latest->academic_year !== currentAcademicYear()
        );

        // 🔥 If verification required
        if ($needsVerification) {

            // If verification window is open → redirect to verification page
            if (isVerificationOpen()) {
                return redirect()->route('verify.page');
            }

            // If outside schedule → block access
            abort(403, 'Verification period is closed.');
        }

        return $next($request);
    }
}