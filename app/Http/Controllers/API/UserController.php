<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        abort_if(Gate::denies('list user'), 403, 'You do not have the required authorization.');
        $data = User::with('roles','permissions','major')->latest();
        if($request->search){
            $data = $data->where('name','LIKE', '%'.$request->search.'%');
        }
        if($request->status){
            $data = $data->where('status_substitute',$request->status);
        }
        $data= $data->paginate($request->length);
        return response(['data' => $data], 200);
    }
    public function index_all(){
        $data = User::with('major')->where('status','Active')->get();
        return response(['data' => $data], 200);
    }
    public function index_all_available_teacher($id, $schedule_id){
        $data = UserService::PreferableMajor($id, $schedule_id);
        return response(['data' => $data], 200);
        // dd($preferable_ids, $data_preferable);
        // dd(json_decode($data[0]->major->preferable));
        // return response(['data' => $data], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->major != '[]'){
            $request->merge(['major_id' => 'okay']);
        }
        $this->validate($request,[
            'major_id' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::create([
            'major_id' => $request->major['id'],
            'name' => $request->name,
            'email' => $request->email,
            'status_substitute' => $request->status_substitute,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role['name']);
        foreach ($request->permissions as $permission) {
            $user->givePermissionTo($permission['name']);
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
        if($request->major != '[]'){
            $request->merge(['major_id' => 'okay']);
        }
        $this->validate($request,[
            'major_id' => 'required|string',
            'name' => 'required|string|unique:users,name,'.$request->id,
            'email' => 'required|email|unique:users,email,'.$request->id,
            'password' => 'required|sometimes',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'major_id' => $request->major['id'],
            'name' => $request->name,
            'email' => $request->email,
            'status_substitute' => $request->status_substitute,
        ]);
        if($request->password){
            $user->password = Hash::make($request->password);
            $user->save();
        }
        $user->assignRole($request->roles[0]['name']);
        foreach ($user->permissions as $permission) {
            $user->revokePermissionTo($permission['name']);
        }
        foreach ($request->permissions as $permission) {
            $user->givePermissionTo($permission['name']);
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
        $user = User::findOrFail($id);
        $user->delete();
        return response(['message' => 'success'], 200);
    }
}
