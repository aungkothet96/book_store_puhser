<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{

    use SoftDeletes;
    use Searchable;

    protected $fillable = [
      'name','deleted_at'
  	];
    
    public function searchableAs()
    {
        return 'author_index';
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }
    
    protected static function boot() 
    {
      parent::boot();

      static::deleting(function($author) {
         foreach ($author->books()->get() as $book) {
            $book->delete();
         }
      });
    }
  	public function books()
  	{
      return $this->hasMany('App\Book');
  	}
}
