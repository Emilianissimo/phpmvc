<?php

namespace Models;

use Config\Core\Model;
use Database\Database;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Task extends EloquentModel{

	protected $table = "tasks";
	protected $fillable = [
		'name',
		'email',
		'text'
	];

	public function getData()
	{
		$dt = new Database; //Непонятно почему, но без декларирования не работает (может я и нуб, скорее всего, однако если грузить их в точки входа, то они не работают по маршрутам, а передавать автоматически на все пути через Middleware (его еще и писать) мне лень, да и смысла нет). Костыль, но, как говорится, и так сойдет.
		return Task::all();
	}

	public function add($fields)
	{
		$dt = new Database;
		$task = new self;
		$task->fill($fields);
		$task->save();

		return $task;
	}

	public function edit($fields)
	{
		$dt = new Database;
		$this->fill($fields);
		$this->save();
	}

	public function remove()
	{
		$dt = new Database;
		$this->delete();
	}

	public function changeStatus($value)
	{
		$dt = new Database;
		$this->status = $value;
	}

}

