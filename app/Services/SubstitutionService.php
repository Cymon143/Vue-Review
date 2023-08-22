<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubstitutionService
{
    public static function Validate(Request $request){
        $request->merge(["assigned_user"=> empty($request->assigned_user) ? '':$request->assigned_user['id']]);
        $request->merge(["substitute_user"=> empty($request->substitute_user) ? '':$request->substitute_user['id']]);
        $request->merge(["schedule"=> empty($request->schedule) ? '':$request->schedule['id']]);
        $request->merge(["substitute_date"=> empty($request->substitute_date) ? '':$request->substitute_date]);
        $request->validate([
            'assigned_user' => 'required|integer',
            'substitute_user' => 'required|integer',
            'schedule' => 'required|integer',
            'substitute_date' => 'required|date',
            'approved_by' => 'required|string',
        ]);
    }
}
