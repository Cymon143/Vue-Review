<?php

namespace App\Http\Controllers\API;

use App\Actions\ScheduleAction;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_search_schedule(Request $request){
        $school_year = SettingsService::SchoolYear();
        $search = $request->search;
        $data = Schedule::whereNotNull('created_at')
        ->where('school_year', $school_year)
        ->with('section:id,adviser_user_id,code,name,level','section.adviser:id,name','teacher:id,name','subject:id,code,name')
        ->whereHas('section', function($q) use ($search){
            $q ->where('code', 'LIKE','%'.$search.'%');
        })
        ->orWhereHas('teacher', function($q) use ($search){
            $q ->where('name', 'LIKE','%'.$search.'%');
        })
        ->orderByRaw('FIELD(day,"mon","tue","wed","thu","fri")')
        ->orderBy('time_start')
        ->paginate($request->length);
        return response(['data' => $data], 200);
    }
    public function index(ScheduleAction $scheduleAction)
    {
        $time_table =  $scheduleAction->TimeTable();
        $schedule_table = $scheduleAction->ScheduleTable($time_table);
        return response(['data' => $schedule_table], 200);
    }
    public function index_schedule(Request $request)
    {
        $school_year = SettingsService::SchoolYear();
        $data = Schedule::with('section','subject')
        ->where('school_year', $school_year)
        ->where('teacher_user_id', $request->id);
        if($request->search){
            if($request->table_search == 'section'){
                $data = $data->whereHas('section', function ($query) use ($request) {
                    $query->where('code', 'like', "%{$request->search}%");
                });
            }
            else if($request->table_search == 'subject'){
                $data = $data->whereHas('subject', function ($query) use ($request) {
                    $query->where('code', 'like', "%{$request->search}%");
                });
            }
            else if($request->table_search == 'time'){
                $data = $data->where('time_start', 'like', "%{$request->search}%");
            }
            else{
                $data = $data->where('day', 'like', "%{$request->search}%");
            }
        }
        $data = $data->paginate($request->length);
        // dd($data, $request->id, $school_year);
        return response(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ScheduleAction $scheduleAction)
    {
        $school_year = SettingsService::SchoolYear();
        // dd($school_year);
        $user = Auth::user();
        Validator::make($request->all(), [
            'room' => 'required|string',
            'day' => 'required|string',
            'time_start' => 'required|date_format:"H:i"',
            'time_end' => 'required|date_format:"H:i"|after:time_start',
            'section_id' => 'required|integer',
            'subject_id' => 'required|integer',
        ])->validate();
        $scheduleAction->ValidateSchedule($user->id, $request->time_start, $request->time_end, $request->section_id, $request->subject_id, $request->day);
        try {
            Schedule::create([
                'teacher_user_id' => $user->id,
                'subject_id' => $request->subject_id,
                'section_id' => $request->section_id,
                'room' => $request->room,
                'day' => $request->day,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
                'school_year' => $school_year,
            ]);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages(['duplicate' => 'The section, subject and day already exists']);
        }
        return response(['message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, ScheduleAction $scheduleAction )
    {
        $school_year = SettingsService::SchoolYear();
        $user = Auth::user();
        Validator::make($request->all(), [
            'room' => 'required|string',
            'day' => 'required|string',
            'time_start' => 'required|date_format:"H:i"',
            'time_end' => 'required|date_format:"H:i"|after:time_start',
            'section_id' => 'required|integer',
            'subject_id' => 'required|integer',
        ])->validate();
        $scheduleAction->ValidateSchedule($user->id, $request->time_start, $request->time_end, $request->section_id, $request->subject_id, $request->day, $id);
        try {
            $schedule = Schedule::find($id);
            $schedule->update([
                'teacher_user_id' => $request->teacher_user_id,
                'subject_id' => $request->subject_id,
                'section_id' => $request->section_id,
                'room' => $request->room,
                'day' => $request->day,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
                'school_year' => $school_year,
            ]);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages(['duplicate' => 'The section, subject and day already exists']);
        }
        return response(['message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return response(['message' => 'success'], 200);
    }
}
