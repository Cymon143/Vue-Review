<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeacherLoadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $school_year = DB::table('settings')->where('name','school_year')->pluck('value')->first();
        abort_if(Gate::denies('list user'), 403, 'You do not have the required authorization.');
        $data = User::with('roles','permissions','major')
        ->whereHas('roles', function($q) {
            $q->where('name', 'Faculty');
        })
        ->latest();
        if($request->search){
            $data = $data->where('name','LIKE', '%'.$request->search.'%');
        }
        if($request->status){
            $data = $data->where('status_substitute',$request->status);
        }
        $data= $data->paginate($request->length);
        return response(['data' => $data], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $school_year = DB::table('settings')->where('name','school_year')->pluck('value')->first();
        $loads = User::with(
            'schedules:id,teacher_user_id,subject_id,section_id,room,day,time_start,time_end,school_year',
            'schedules.subject:id,code,name,hour,unit,level',
            'schedules.section:id,adviser_user_id,code,name,level',
            'schedules.section.adviser:id,name'
        )->find($id);
        $adviser_loads = DB::table('sections')->
        where('adviser_user_id', $id)->
        whereNull('deleted_at')->
        get();
        return response([
            'loads' => $loads,
            'adviser_loads' => $adviser_loads,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
