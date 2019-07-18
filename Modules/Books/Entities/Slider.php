<?php

namespace Modules\Books\Entities;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'sec_id', 'avatar', 'text', 'user_id', 'status' , 'sorder'
    ];

    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\User');
    }
}
