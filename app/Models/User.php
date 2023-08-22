<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LaravelPermissionToVueJS, SoftDeletes;

    protected $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'major_id',
        'status_substitute',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function jsPermissions()
    {
        return json_encode([
                'roles' => $this->getRoleNames(),
                'permissions' => $this->getAllPermissions()->pluck('name'),
            ]);
    }

    public function section_adviser(){
        return $this->hasMany(Section::class);
    }
    public function major(){
        return $this->belongsTo(Major::class);
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function my_substitutes(){
        return $this->hasMany(Substitution::class,'assigned_user_id', 'id');
    } 
    public function my_substituted(){
        return $this->hasMany(Substitution::class,'substitute_user_id', 'id');
    }
    // public function upload_document(){
    //     return $this->hasMany(UploadDocuments::class);
    // }

    // public function setCodeAttribute($value)
    // {
    //     $this->attributes['code'] = strtoupper($value);
    // }
    // public function getNameAttribute($value)
    // {
    //     return  str_replace(['null','NULL'],'',ucwords($value));
    // }
}
