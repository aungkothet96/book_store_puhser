<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Book extends Model
{
	use Searchable;
	use SoftDeletes;

	protected $fillable = [
		'name','description','price','image_name','pdf_name','published_date','author_id','genre_id','publisher_id','deleted_at'
	];

	public function searchableAs()
    {
        return 'book_index';
	}
	
	public function toSearchableArray()
    {
		$array = $this->toArray();
		$array['author_name'] = $this->authors()->first()->name;
		$array['genre_name'] = $this->genres()->first()->name;
		$array['publisher_name'] = $this->publishers()->first()->name;
         return $array;
	}
	
	public function authors()
	{
		return $this->belongsTo('App\Author','author_id');
	}

	public function genres()
	{
		return $this->belongsTo('App\Genre','genre_id');
	}
	
	public function publishers()
	{
		return $this->belongsTo('App\Publisher','publisher_id');
	}

}
