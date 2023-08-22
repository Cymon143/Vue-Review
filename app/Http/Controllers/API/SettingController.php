<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function reset_substitute_status(){
        DB::statement('UPDATE users SET status_substitute = 0;');
        return response(['message' => 'success'], 200);
    }
    public function update_profile_image(Request $request)
    {
        $request->validate([
            'profile_image.value' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);
        $user = User::find(Auth::user()->id);
        if($request->profile_image){
            if('/images/default_image.png' != $user->image){
                $image_path = public_path().$user->image;
                unlink($image_path);
            }
        }
        $file_name = time().'_'.$request->profile_image['value']->getClientOriginalName();
        $file_path = $request->profile_image['value']->storeAs('profile_image', $file_name, 'public');
        $user->image = '/storage/' . $file_path;
        $user->save();
        return response(['message' => 'message'], 200);
    }
    public function index_school_logo()
    {
        $data = Setting::where('name','school_logo')->first();
        if(!$data){
            $data = Setting::create([
                'name' => 'school_logo',
                'value' => '/images/5aae503e4f037a5a4375944d8861fb6a.png',
            ]);
        }
        return response(['data' => $data], 200);
    }
    public function update_school_logo(Request $request)
    {
        $request->validate([
            'school_logo.value' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);
        $setting = Setting::find($request->school_logo['id']);
        if($request->school_logo){
            if('/images/5aae503e4f037a5a4375944d8861fb6a.png' != $setting->value){
                $image_path = public_path().$setting->value;
                unlink($image_path);
            }
        }
        $file_name = time().'_'.$request->school_logo['value']->getClientOriginalName();
        $file_path = $request->school_logo['value']->storeAs('uploads', $file_name, 'public');
        $setting = Setting::find($request->school_logo['id']);
        $setting->value = '/storage/' . $file_path;
        $setting->save();
        return response(['message' => 'message'], 200);
    }
    public function index_short_school_name()
    {
        $data = Setting::where('name','short_school_name')->first();
        if(!$data){
            $data = Setting::create([
                'name' => 'short_school_name',
                'value' => 'SHS',
            ]);
        }
        return response(['data' => $data], 200);
    }
    public function update_short_school_name(Request $request, $id)
    {
        // dd($id, $request);
        $setting = Setting::find($id);
        $setting->value = $request->short_school_name['value'];
        $setting->save();
        return response(['message' => 'message'], 200);
    }
    public function index_school_name()
    {
        $data = Setting::where('name','school_name')->first();
        if(!$data){
            $data = Setting::create([
                'name' => 'school_name',
                'value' => 'test school name',
            ]);
        }
        return response(['data' => $data], 200);
    }
    public function update_school_name(Request $request, $id)
    {
        // dd($id, $request);
        $setting = Setting::find($id);
        $setting->value = $request->school_name['value'];
        $setting->save();
        return response(['message' => 'message'], 200);
    }
    public function index_principal()
    {
        $data = Setting::where('name','principal')->first();
        if(!$data){
            $data = Setting::create([
                'name' => 'principal',
                'value' => 'John Doe Centillas',
            ]);
        }
        return response(['data' => $data], 200);
    }
    public function update_principal(Request $request, $id)
    {
        // dd($id, $request);
        $setting = Setting::find($id);
        $setting->value = $request->principal['value'];
        $setting->save();
        return response(['message' => 'message'], 200);
    }
    public function index_schedule_encoding()
    {
        $data = Setting::where('name','schedule_encoding')->first();
        if(!$data){
            $school_year = Carbon::now()->format('Y-m-d');
            $data = Setting::create([
                'name' => 'schedule_encoding',
                'date_start' => $school_year,
                'date_end' => $school_year,
            ]);
        }
        $d = array(
            'id' => $data->id,
            'start' => $data->date_start,
            'end' => $data->date_end,
        );
        return response(['data' => $d], 200);
    }
    public function update_schedule_encoding(Request $request, $id)
    {
        // dd($request);
        $setting = Setting::find($id);
        $setting->date_start = Carbon::create($request->schedule_encoding['start'])->format('Y-m-d');
        $setting->date_end = Carbon::create($request->schedule_encoding['end'])->format('Y-m-d');
        $setting->save();
        return response(['message' => 'message'], 200);
    }

    public function period_schedule_encoding()
    {
        $date = carbon::now()->format('Y-m-d');
        $data = Setting::where('name','schedule_encoding')
        ->where('date_start','<=',$date)
        ->where('date_end','>=',$date)
        ->exists('id');
        return response(['data' => $data], 200);
    }

    public function index_school_year()
    {
        $data = Setting::where('name','school_year')->first();
        if(!$data){
            $school_year = Carbon::now()->format('Y');
            $data = Setting::create([
                'name' => 'school_year',
                'value' => $school_year,
            ]);
        }
        return response(['data' => $data], 200);
    }

    public function update_school_year(Request $request, $id)
    {
        $setting = Setting::find($id);
        $setting->value = $request->school_year['value'];
        $setting->save();
        return response(['message' => 'message'], 200);
    }
}
