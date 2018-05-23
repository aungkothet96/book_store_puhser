<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'name','deleted_at'
  	];

  	public function books()
  	{
      return $this->hasMany('App\Book');
  	}
}
