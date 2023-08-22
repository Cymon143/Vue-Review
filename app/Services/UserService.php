<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    public static function PreferableMajor($teachher_id, $schedule_id){
        $teacher = User::with('major:id,name,preferable')->find($teachher_id);
        $schedule = Schedule::find($schedule_id);
        $preferable = json_decode($teacher->major->preferable);
        $preferable_first_ids = UserService::NotAvailableTeacherSchedule($teacher->major_id, $schedule->day, $schedule->time_start, $schedule->time_end);
        $preferable_first = UserService::AvailableTeacherSchedule($teachher_id, $teacher->major_id, $preferable_first_ids, 1);
        $preferable_by_rank = new Collection();
        for ($i=0; $i < count($preferable); $i++) { 
            $preferable_data_ids = UserService::NotAvailableTeacherSchedule($preferable[$i]->id, $schedule->day, $schedule->time_start, $schedule->time_end);
            $preferable_data = UserService::AvailableTeacherSchedule($teachher_id, $preferable[$i]->id, $preferable_data_ids, 2);
            $preferable_by_rank = $preferable_by_rank->merge($preferable_data);
        }
        return $preferable_first->merge($preferable_by_rank);
    }
    public static function NotAvailableTeacherSchedule($major_id, $day, $time_start, $time_end){
        $school_year = SettingsService::SchoolYear();
        $user_ids = User::where('major_id', $major_id)->pluck('id')->toArray();
        $t_start = Carbon::create($time_start)->addSecond()->toTimeString();
        $t_start_e = Carbon::create($time_start)->toTimeString();
        $t_end = Carbon::create($time_end)->subSecond()->toTimeString();
        $t_end_e = Carbon::create($time_end)->toTimeString();

        $t_start_t = Carbon::create($time_start)->subSecond()->toTimeString();

        $data = Schedule::whereIn('id',$user_ids)
        ->where(function($query) use ($t_start_e, $t_start, $t_end, $t_end_e, $t_start_t) {
            $query->whereBetween('time_start', [$t_start_e, $t_end])->
            orWhereBetween('time_end', [$t_start, $t_end_e]);
        })
        ->where('day', $day)
        ->where('school_year', $school_year)
        ->orWhere(function($query) use ($t_start, $t_start_t) {
            $query->whereTime('time_start', '<', $t_start)->
            orWhereTime('time_end','>', $t_start_t);
        })
        ->where(function($query) use ($t_start_e, $t_start, $t_end, $t_end_e, $t_start_t) {
            $query->whereBetween('time_start', [$t_start_e, $t_end])->
            orWhereBetween('time_end', [$t_start, $t_end_e]);
        })
        ->where('day', $day)
        ->where('school_year', $school_year)
        ->pluck('id')->toArray();
        return $data;
    }
    public static function AvailableTeacherSchedule($teacher_id, $major_id, $user_ids, $priority){
        $data = User::select(
            '*',
            DB::raw(''.$priority.' as priority')
        )
        ->with('major')
        ->where('status_substitute', 0)
        ->whereNotIn('id',[$teacher_id])
        ->where('status','Active')
        ->where('major_id',$major_id)
        ->whereNotIn('id', $user_ids)
        ->get();
        return $data;
    }
}
