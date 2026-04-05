<?php

use App\Models\Setting;
use Carbon\Carbon;

if (!function_exists('systemSetting')) {
    function systemSetting()
    {
        return Setting::orderByDesc('id')->first();
    }
}

if (!function_exists('currentSemester')) {
    function currentSemester()
    {
        return systemSetting()?->current_semester;
    }
}

if (!function_exists('currentAcademicYear')) {
    function currentAcademicYear()
    {
        return systemSetting()?->academic_year;
    }
}

if (!function_exists('isVerificationOpen')) {
    function isVerificationOpen()
    {
        $setting = systemSetting();

        if (!$setting || !$setting->verification_start_date || !$setting->verification_end_date) {
            return false;
        }

        $today = Carbon::today();

        return $today->between(
            Carbon::parse($setting->verification_start_date),
            Carbon::parse($setting->verification_end_date)
        );
        
    }
}