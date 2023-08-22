<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MajorController extends Controller
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
        abort_if(Gate::denies('list major'), 403, 'You do not have the required authorization.');
        $data = Major::whereNotNull('created_at');
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
        $data = Major::all();
        return response(['data' => $data], 200);
    }
    public function index_all_not_in($id){
        $data = Major::whereNotIn('id', [$id])->get();
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
        abort_if(Gate::denies('create major'), 403, 'You do not have the required authorization.');
        $this->validate($request,[
            'name' => 'required|string|unique:majors,name',
        ]);
        Major::create([
            'name' => $request->name,
            'preferable' => json_encode($request->preferable),
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
        abort_if(Gate::denies('edit major'), 403, 'You do not have the required authorization.');
        $this->validate($request,[
            'name' => 'required|string|unique:majors,name,'.$request->id,
        ]);
        $major = Major::findOrFail($id);
        $major->update([
            'name' => $request->name,
            'preferable' => json_encode($request->preferable),
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
        $major = Major::findOrFail($id);
        $major->delete();
        return response(['message' => 'success'], 200);
    }
}
