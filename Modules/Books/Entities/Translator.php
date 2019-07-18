<?php

namespace Modules\Books\Entities;

use Illuminate\Database\Eloquent\Model;

class Translator extends Model
{
    protected $fillable = [
        'name', 'description', 'user_id', 'status', 'torder' , 'avatar'
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
