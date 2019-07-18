<?php

namespace Modules\Books\Entities;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['description'];
    public $timestamps = false;
}
