<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Genre extends Model
{
    use SoftDeletes;
    use Searchable;

    protected $fillable = [
        'name', 'deleted_at',
    ];

    public function searchableAs()
    {
        return 'genre_index';
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }
    
    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
