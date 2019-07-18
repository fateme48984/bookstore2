<?php

namespace Modules\Books\Entities;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'category_id', 'author_id', 'translator_id', 'publisher_id', 'summary', 'description', 'image', 'status', 'border', 'user_id' , 'avatar','image1','image2'
    ];

    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\User');
    }

    public function author()
    {
        return $this->belongsTo('Modules\Books\Entities\Author');
    }
    public function translator()
    {
        return $this->belongsTo('Modules\Books\Entities\Translator');
    }
    public function category()
    {
        return $this->belongsTo('Modules\Books\Entities\Category');
    }
    public function publisher()
    {
        return $this->belongsTo('Modules\Books\Entities\Publisher');
    }
}
