<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LevelHasSubject extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $table_name = 'level_has_subjects';
    protected $guard_name = 'api';
    protected $guarded = [];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
