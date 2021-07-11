<?php

namespace Controllers;

use Models\Task;
use Config\Core\View;
use Database\Database;
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
		return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks]);
	}

	public function store()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$task = Task::add([
				'name'=> $_POST['name'],
				'email'=> $_POST['email'],
				'text'=> $_POST['text'],
			]);
			$tasks = Task::getData();
			return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks, 'message' => 'Задача добавлена']);
		}
		header("Location: ". $_POST['location']);
		exit();
	}

	public function update()
	{
		if ($_SESSION['admin'] === 1) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$dt = new Database;
				$task = Task::find($_POST['id']);
				$task->edit([
					'name'=> $_POST['name'],
					'email'=> $_POST['email'],
					'text'=> '(Отредактировано администиратором) '.$_POST['text'],
				]);
				$tasks = Task::getData();
				return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks, 'messageEdit' => 'Задача изменена']);
			}
			header("Location: ". $_POST['location']);
			exit();
		}else{
			header("Location: ". $_POST['login']);
			exit();
		}
	}

	public function destroy()
	{
		if ($_SESSION['admin'] === 1) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['admin'] === 1) {
				$dt = new Database;
				$task = Task::find($_POST['id']);
				$task->remove();
				$tasks = Task::getData();
				return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks, 'messageDelete' => 'Задача удалена']);
			}
			header("Location: ". $_POST['location']);
			exit();
		}else{
			header("Location: ". $_POST['login']);
			exit();
		}
	}

	public function changestatus()
	{
		if ($_SESSION['admin'] === 1) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['admin'] === 1) {
				$dt = new Database;
				$task = Task::find($_POST['id']);
				$task->changeStatus($_POST['status']);
				$tasks = Task::getData();
				return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks, 'messageChange' => 'Статус изменён']);
			}
			header("Location: ". $_POST['location']);
			exit();
		}else{
			header("Location: ". $_POST['login']);
			exit();
		}
	}

	public function order()
	{
		$dt = new Database;
		$option = $_GET['option'];
		$tasks = Task::getData();
		if ($option == 'name' || $option == 'email' || $option == 'status') {
			$tasks = Task::orderBy($option, 'ASC')->get();
		}
		return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks]);
	}
}