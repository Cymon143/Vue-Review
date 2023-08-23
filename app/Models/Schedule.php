<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Schedule extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $table_name = 'schedules';
    protected $guard_name = 'api';
    protected $guarded = [];

    public function teacher(){
        return $this->belongsTo(User::class,'teacher_user_id', 'id');
    }
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function substitute(){
        return $this->hasMany(Substitution::class);
    }
    public function getTimeStartAttribute($value)
    {
        return Carbon::create($value)->format('H:i');
    }
    public function getTimeEndAttribute($value)
    {
        return Carbon::create($value)->format('H:i');
    }

}
