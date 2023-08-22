<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class SettingsService
{
    public static function SchoolYear(){
        $data = Setting::where('name','school_year')->first('value');
        return $data->value;
    }
    public static function Logo(){
        $data = Setting::where('name','school_logo')->first();
        return $data->value;
    }
    public static function ShortSchoolName(){
        $data = Setting::where('name','short_school_name')->first();
        return $data->value;
    }
    public static function SchoolName(){
        $data = Setting::where('name','school_name')->first();
        return $data->value;
    }
    public static function Principal(){
        $data = Setting::where('name','principal')->first();
        return $data->value;
    }

}
