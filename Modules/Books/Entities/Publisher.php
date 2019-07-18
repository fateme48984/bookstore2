<?php

namespace Modules\Books\Entities;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = [
        'name', 'description', 'user_id', 'status', 'avatar', 'porder'
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
