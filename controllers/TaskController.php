<?php

namespace Controllers;

use Models\Task;
use Config\Core\View;
use Config\Core\Controller;

class TaskController extends Controller{

	function __construct()
	{
		// $this->model = new Task;
		$this->view = new View;
	}

	public function index()
	{
		$tasks = Task::getData();
		// $tasks = $this->model->getData();
		$this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks]);
	}

	public function store()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$task = Task::add([
				'name'=> $_POST['name'],
				'email'=> $_POST['email'],
				'text'=> $_POST['text'],
			]);
		}
		header("Location: ". $_POST['location']);
		exit();
	}

	public function update($id)
	{
		header("Location: ". $_SERVER['HTTP_HOST']."/task"); 
		exit();
	}

	public function delete($id)
	{
		header("Location: ". $_SERVER['HTTP_HOST']."/task"); 
		exit();
	}

}