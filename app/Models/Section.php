<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Section extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    protected $table_name = 'sections';
    protected $guard_name = 'api';
    protected $guarded = [];

    public function adviser(){
        return $this->belongsTo(User::class,'adviser_user_id', 'id');
    }
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    public function subjects(){
        return $this->hasMany(SectionSubject::class);
    }
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
}
