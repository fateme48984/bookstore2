<?php

namespace Modules\Books\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'user_id', 'status', 'corder'
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
