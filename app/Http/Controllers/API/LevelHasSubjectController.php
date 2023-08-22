<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LevelHasSubject;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class LevelHasSubjectController extends Controller
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
    public function index(Request $request)
    {
        abort_if(Gate::denies('list level-subject'), 403, 'You do not have the required authorization.');
        $data = LevelHasSubject::with('subject')->whereNotNull('created_at');
        if($request->search){
            $data = $data->where('level','LIKE', '%'.$request->search.'%');
        }
        $data= $data->paginate($request->length);
        return response(['data' => $data], 200);
    }

    public function set_level_subjects($level){
        $data = LevelHasSubject::with('subject')->where('status','active')
        ->where('level', $level)
        ->get();
        return response()->json(['data' => $data]);
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
        abort_if(Gate::denies('create level-subject'), 403, 'You do not have the required authorization.');
        $request->merge(["subjects_validate"=> empty($request->subject) ? '':'okay']);
        $message = [
            'subjects_validate.required' => 'The subject field is required.',
        ];
        $this->validate($request,[
            'subjects_validate' => 'required|unique:level_has_subjects,level,NULL,id,subject_id,NULL',
        ], $message);
        try {
            LevelHasSubject::create([
                'subject_id' => $request->subject['id'],
                'level' => $request->level,
            ]);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages(['duplicate' => 'The Level subject already exists']);
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
        abort_if(Gate::denies('edit level-subject'), 403, 'You do not have the required authorization.');
        $request->merge(["subjects_validate"=> empty($request->subject) ? '':'okay']);
        $message = [
            'subjects_validate.required' => 'The subject field is required.',
        ];
        $this->validate($request,[
            'subjects_validate' => 'required|unique:level_has_subjects,level,'.$id.',id,subject_id,'.$request->subject['id'],
        ], $message);
        try {
            $level_has_subject = LevelHasSubject::find($id);
            $level_has_subject->update([
                'subject_id' => $request->subject['id'],
                'level' => $request->level,
                'status' => $request->status
            ]);
            return response(['message' => 'success'], 200);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages(['duplicate' => 'The Level subject already exists']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $level_has_subject = LevelHasSubject::findOrFail($id);
        $level_has_subject->delete();
        return response(['message' => 'success'], 200);
    }
}
