<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Book extends Model
{

	use SoftDeletes;

	protected $fillable = [
		'name','description','price','image_name','pdf_name','published_date','author_id','genre_id','publisher_id','deleted_at'
	];

	public function authors()
	{
		return $this->belongsTo('App\Author');
	}

	public function genres()
	{
		return $this->belongsTo('App\Genre');
	}
	
	public function publishers()
	{
		return $this->belongsTo('App\Publisher');
	}

}
