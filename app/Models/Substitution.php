<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Substitution extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    protected $table_name = 'substitutions';
    protected $guard_name = 'api';
    protected $guarded = [];

    public function assigned_teacher(){
        return $this->belongsTo(User::class,'assigned_user_id', 'id');
    }
    public function substitute_teacher(){
        return $this->belongsTo(User::class,'substitute_user_id', 'id');
    }
    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
}
