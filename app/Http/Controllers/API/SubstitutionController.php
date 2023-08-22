<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Substitution;
use App\Models\User;
use App\Services\SettingsService;
use App\Services\SubstitutionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class SubstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('list subject'), 403, 'You do not have the required authorization.');
        $data = Substitution::with('schedule','schedule.subject:id,code','schedule.section:id,code','assigned_teacher', 'substitute_teacher')->whereNotNull('created_at');
        if($request->search){
            $data = $data->where($request->order_by,'LIKE', '%'.$request->search.'%');
        }
        if($request->order_by){
            $data = $data->orderBy($request->order_by, $request->sort_by);
        }
        $data= $data->paginate($request->length);
        return response(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        abort_if(Gate::denies('create substitution'), 403, 'You do not have the required authorization.');
        $school_year = SettingsService::SchoolYear();
        SubstitutionService::Validate($request);

        try {
            $section = Substitution::create([
                'assigned_user_id' => $request->assigned_user,
                'substitute_user_id' => $request->substitute_user,
                'schedule_id' => $request->schedule,
                'substitute_date' => Carbon::create($request->substitute_date)->format('Y-m-d'),
                'school_year' => $school_year,
                'reason' => $request->reason,
                'approved_by' => $request->approved_by,
                'prepared_by' => $request->prepared_by,
                'principal' => $request->principal,
                'status' => 'Completed',
            ]);

        } catch (\Throwable $th) {
            dd($request);
            throw ValidationException::withMessages(['duplicate' => 'The substitute already existing.']);
        }
        $user = User::select('id','status_substitute')->where('id', $section->substitute_user_id)->first();
        $user->status_substitute = '1';
        $user->save();
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
