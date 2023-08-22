<?php

namespace App\Http\Controllers;

use App\Models\Substitution;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function print_report($id){
        $data = Substitution::with('schedule','assigned_teacher:id,major_id,name','assigned_teacher.major:id,name','substitute_teacher:id,major_id,name','substitute_teacher.major:id,name','schedule.subject:id,code,name','schedule.section:id,code,name,level')
        ->find($id);
        $logo = SettingsService::Logo();
        $school_name = SettingsService::SchoolName();
        $short_school_name = SettingsService::ShortSchoolName();
        $principal = SettingsService::Principal();

        // dd(json_decode($data), $data->schedule->section);
        return view('template.substitution_report', compact(
            'data',
            'logo',
            'school_name',
            'short_school_name',
            'principal'
        ));
    }
}
