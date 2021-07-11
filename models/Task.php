<?php

namespace Models;

use Database\Database;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Task extends EloquentModel{

	protected $table = "tasks";
	protected $fillable = [
		'name',
		'email',
		'text'
	];

	public function add($fields)
	{
		$dt = new Database;
		//Непонятно почему, но без декларирования не работает (может я и нуб, скорее всего, однако если грузить их в точки входа, то они не работают по маршрутам, а передавать автоматически на все пути через Middleware (его еще и писать) мне лень, да и смысла нет). Костыль, но, как говорится, и так сойдет.
		$task = new self;
		$task->fill($fields);
		$task->save();

		return $task;
	}

	public function edit($fields)
	{
		$this->fill($fields);
		$this->save();
	}

	public function remove()
	{
		$this->delete();
	}

	public function changeStatus($value)
	{
		$this->status = $value;
		$this->save();
	}

	public function paginate($limit, $page)
	{
		$dt = new Database; 
		if (!isset($page) || $page == 1) {
			$tasks = self::select('id', 'name', 'email', 'text', 'status')->limit(3)->offset(0)->get();
		}elseif($page == 2){
			$tasks = self::select('id', 'name', 'email', 'text', 'status')->limit(3)->offset(3)->get();
		}else{
			$tasks = self::select('id', 'name', 'email', 'text', 'status')->limit(3)->offset(3 * $page)->get();
		}
		return $tasks;
	}

}

