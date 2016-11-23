<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;

class Project extends Model
{
	use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

	protected $table 		= 'projects';
	protected $primaryKey 	= 'id';
	// public $timestamps 	= false;
	// protected $guarded 	= ['id'];
	protected $fillable 	= ['name', 'description', 'due_date', 'status'];
	// protected $hidden 	= [];
    protected $dates 		= ['due_date'];
    protected $appends 		= ['acronym'];

	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

	public function getAcronymAttribute() {
		
		$words = explode(" ", $this->name);
		$acronym = "";

		foreach ($words as $w) {
		  $acronym .= $w[0];
		}
		
		return $acronym;
	}

	public function getColorAttribute() {
		$code = dechex(crc32($this->name));
		$code = substr($code, 0, 6);
		return $code;
	}

	public function getCriticalityAttribute() {
		$now = new Carbon();
		$diff = $now->diffInDays($this->due_date);

		if ($diff >= 14) {
			return 'green';
		} elseif ($diff >= 7) {
			return 'yellow';
		} else {
			return 'red';
		}
	}

	public function getInProgressCountAttribute() {
		return $this->tasks()->where('status', '=', 'IN PROGRESS')->count();
	}

	public function getOpenCountAttribute() {
		return $this->tasks()->where('status', '=', 'OPEN')->count();
	}

	public function getClosedCountAttribute() {
		return $this->tasks()->where('status', '=', 'COMPLETE')->count();
	}

	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

	public function tasks() {
		return $this->hasMany('App\Models\Task');
	}

	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
