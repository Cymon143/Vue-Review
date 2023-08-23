<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SubjectController extends Controller
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
        abort_if(Gate::denies('list subject'), 403, 'You do not have the required authorization.');
        $data = Subject::whereNotNull('created_at');
        if($request->search){
            $data = $data->where($request->order_by,'LIKE', '%'.$request->search.'%');
        }
        if($request->order_by){
            $data = $data->orderBy($request->order_by, $request->sort_by);
        }
        $data= $data->paginate($request->length);
        return response(['data' => $data], 200);
    }
    public function index_all(){
        $data = Subject::all();
        return response(['data' => $data], 200);
    }
    public function index_all_by_level($level){
        $data = Subject::where('level', $level)->get();
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
        abort_if(Gate::denies('create subject'), 403, 'You do not have the required authorization.');
        $this->validate($request,[
            'code' => 'required|string|unique:subjects,code',
            'name' => 'required|string|unique:subjects,name',
            'unit' => 'required|numeric',
            'hour' => 'required|numeric',
            'minute' => 'required|numeric',
            'level' => 'required|integer',
        ]);
        $request->merge(['hour' => $request->hour.':'.$request->minute.':00']);
        $request->request->remove('minute');
        Subject::create([
            'code' => $request->code,
            'name' => $request->name,
            'level' => $request->level,
            'hour' => $request->hour,
            'unit' => $request->unit,
        ]);
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
        abort_if(Gate::denies('edit subject'), 403, 'You do not have the required authorization.');
        $this->validate($request,[
            'code' => 'required|string|unique:subjects,code,'.$request->id,
            'name' => 'required|string|unique:subjects,name,'.$request->id,
            'unit' => 'required|integer',
            'hour' => 'required|time',
            'level' => 'required|integer',
        ]);
        $subject = Subject::findOrFail($id);
        $subject->update([
            'code' => $request->code,
            'name' => $request->name,
            'level' => $request->level,
            'hour' => $request->hour,
            'unit' => $request->unit,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return response(['message' => 'success'], 200);
    }
}
