<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isEmpty;

class SectionController extends Controller
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
        abort_if(Gate::denies('list section'), 403, 'You do not have the required authorization.');
        $data = Section::with('adviser','adviser.major','subjects', 'subjects.subject')->whereNotNull('created_at');
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
        $data = Section::all();
        return response(['data' => $data], 200);
    }
    public function index_all_level($level){
        $data = Section::with('adviser:id,major_id,name','adviser.major:id,name','subjects', 'subjects.subject')->where('level', $level)->get();
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
        abort_if(Gate::denies('create section'), 403, 'You do not have the required authorization.');
        $request->merge(["adviser"=> empty($request->adviser) ? '':$request->adviser['id']]);
        $this->validate($request,[
            'code' => 'required|string',
            'name' => 'required|string',
            'level' => 'required|string',
            'adviser' => 'required|integer',
        ]);
        try {
            $section = Section::create([
                'adviser_user_id' => $request->adviser,
                'code' => $request->code,
                'name' => $request->name,
                'level' => $request->level,
            ]);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages(['duplicate' => 'The code, name and level already exists']);
        }
        for ($i=0; $i < count($request->subjects); $i++) {
            SectionSubject::create([
                'section_id' => $section['id'],
                'subject_id' => $request->subjects[$i]['id'],
            ]);
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
        abort_if(Gate::denies('edit section'), 403, 'You do not have the required authorization.');
        $this->validate($request,[
            'code' => 'required|string|unique:sections,code,'.$id,
            'name' => 'required|string|unique:sections,name,'.$id,
            'level' => 'required|integer',
        ]);
        $section = Section::findOrFail($id);
        try {
            $section->update([
                'adviser_user_id' => $request->advisers['id'],
                'code' => $request->code,
                'name' => $request->name,
                'level' => $request->level,
            ]);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages(['duplicate' => 'The code, name and level already exists']);
        }
        SectionSubject::where('section_id', $id)->delete();
        for ($i=0; $i < count($request->subjects); $i++) {
            SectionSubject::create([
                'section_id' => $id,
                'subject_id' => $request->subjects[$i]['id'],
            ]);
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
        $subject = Section::findOrFail($id);
        $subject->delete();
        return response(['message' => 'success'], 200);
    }
}
