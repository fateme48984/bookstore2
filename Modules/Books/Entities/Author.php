<?php

namespace Modules\Books\Entities;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
         'name','nationality','birthdate','description','user_id','aorder','status','avatar'
    ];


    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\User');
    }

    public function book()
    {
        return $this->hasMany('Modules\Books\Entities\Book');
    }

}
