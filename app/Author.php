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
  	
}