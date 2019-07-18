<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }


    public function author()
    {
        return $this->hasMany('Modules\Books\Entities\Author');
    }

    public function slider()
    {
        return $this->hasMany('Modules\Books\Entities\Slider');
    }

    public function translator()
    {
        return $this->hasMany('Modules\Books\Entities\Translator');
    }

    public function publisher()
    {
        return $this->hasMany('Modules\Books\Entities\Publisher');
    }

    public function book()
    {
        return $this->hasMany('Modules\Books\Entities\Book');
    }

    public function category()
    {
        return $this->hasMany('Modules\Books\Entities\Category');
    }
}
