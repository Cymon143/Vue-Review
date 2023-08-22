<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Subject extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    protected $table_name = 'subjects';
    protected $guard_name = 'api';
    protected $guarded = [];

    public function section_adviser(){
        return $this->hasMany(Section::class);
    }
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    public function level_has_subject(){
        return $this->hasOne(LevelHasSubject::class);
    }
    public function section_subjects(){
        return $this->hasMany(SectionSubject::class);
    }
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
}
