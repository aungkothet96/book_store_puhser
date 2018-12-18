<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{

    use SoftDeletes;

    protected $fillable = [
      'name','deleted_at'
  	];
  	

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
