<?php

namespace App\Actions;

use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Services\SettingsService;
class ScheduleAction
{
    public function TimeTable(){
        //06:00 am to 06:00 pm
        $time = Carbon::create('05:30:00');
        $t = [];
        for ($i=0; $i < 25; $i++) {
            $a = $time->addMinutes(30);
            array_push($t, $a->format('H:i:s'));
        }
        return $t;
    }
    public function ScheduleTable($time_table){
        $day = ['mon','tue','wed','thu','fri'];
        $newSchedule = array(
            'mon' => array(),
            'tue' => array(),
            'wed' => array(),
            'thu' => array(),
            'fri' => array(),
        );
        for ($i=0; $i < count($time_table); $i++) {
            for ($x=0; $x < count($newSchedule); $x++) {
                $data = $this->isSched($day[$x], $time_table[$i]);
                if($data){
                    array_push($newSchedule[$day[$x]], $data);
                }
            }
        }
        return $newSchedule;
    }
    public function isSched($day, $time_start){
        $user = Auth::user();
        $school_year = SettingsService::SchoolYear();
        $data = Schedule::with(
            'section:id,adviser_user_id,code,name,level',
            'section.adviser:id,major_id,name',
            'section.adviser.major:id,name',
            'subject:id,code,name')
        ->where('school_year', $school_year)->where('teacher_user_id', $user->id)
        ->where('day', $day)
        ->where('time_start', $time_start)->first();
        return $data ?? false;
    }
    public function TeacherConflictSchedule($teacher_id, $day, $time_start, $time_end, $id = null){
        $school_year = SettingsService::SchoolYear();
        $t_start = Carbon::create($time_start)->addSecond()->toTimeString();
        $t_start_e = Carbon::create($time_start)->toTimeString();
        $t_end = Carbon::create($time_end)->subSecond()->toTimeString();
        $t_end_e = Carbon::create($time_end)->toTimeString();
        $data = Schedule::with('section:id,code,name','subject:id,code,name','teacher:id,name');
        if($id){
            $data = $data->whereNotIn('id',[$id]);
        }
        $data = $data->where(function($query) use ($t_start_e, $t_start, $t_end, $t_end_e) {
            $query->whereBetween('time_start', [$t_start_e, $t_end])->
            orWhereBetween('time_end', [$t_start, $t_end_e]);
        })
        ->where('teacher_user_id', $teacher_id)
        ->where('day', $day)
        ->where('school_year', $school_year)
        ->orderByRaw('FIELD(day,"mon","tue","wed","thu","fri")')
        ->orderBy('time_start', "asc")
        ->get();
        return $data;
    }
    public function SectionConflictSchedule($section_id, $day, $time_start, $time_end, $id = null){
        $school_year = SettingsService::SchoolYear();
        $t_start = Carbon::create($time_start)->addSecond()->toTimeString();
        $t_start_e = Carbon::create($time_start)->toTimeString();
        $t_end = Carbon::create($time_end)->subSecond()->toTimeString();
        $t_end_e = Carbon::create($time_end)->toTimeString();
        $data = Schedule::with('section:id,code,name','subject:id,code,name','teacher:id,name');
        if($id){
            $data = $data->whereNotIn('id',[$id]);
        }
        $data = $data->where(function($query) use ($t_start_e, $t_start, $t_end, $t_end_e) {
            $query->whereBetween('time_start', [$t_start_e, $t_end])->
            orWhereBetween('time_end', [$t_start, $t_end_e]);
        })
        ->where('section_id', $section_id)
        ->where('day', $day)
        ->where('school_year', $school_year)
        ->orderByRaw('FIELD(day,"mon","tue","wed","thu","fri")')
        ->orderBy('time_start', "asc")
        ->get();
        return $data;
    }
    public function SectionSubjectDoubleSchedule($section_id, $subject_id, $day, $id = null){
        $school_year = SettingsService::SchoolYear();
        $data = Schedule::with('section:id,code,name','subject:id,code,name','teacher:id,name');
        if($id){
            $data = $data->whereNotIn('id',[$id]);
        }
        $data = $data->where('section_id', $section_id)
        ->where('subject_id', $subject_id)
        ->where('day', $day)
        ->where('school_year', $school_year)
        ->orderByRaw('FIELD(day,"mon","tue","wed","thu","fri")')
        ->orderBy('time_start', "asc")
        ->get();
        return $data;
    }
    public function ValidateSchedule($teacher_id, $time_start, $time_end, $section_id, $subject_id, $day, $id = null){
        $teacher_check_conflict = $this->TeacherConflictSchedule($teacher_id, $day, $time_start, $time_end, $id);
        if(count($teacher_check_conflict) > 0){
            throw ValidationException::withMessages(['conflict' => $teacher_check_conflict]);
        }
        $section_check_conflict = $this->SectionConflictSchedule($section_id, $day, $time_start, $time_end, $id);
        if(count($section_check_conflict) > 0){
            throw ValidationException::withMessages(['conflict' => $section_check_conflict]);
        }
        $double_schedule = $this->SectionSubjectDoubleSchedule($section_id, $subject_id, $day, $id);
        if(count($double_schedule) > 0){
            throw ValidationException::withMessages(['conflict' => $double_schedule]);
        }
    }
}
