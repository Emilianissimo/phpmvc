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
		$dt = new Database; 
		$page = $_GET['page'];
		$tasks = Task::paginate(3, $page);
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
			$tasks = Task::paginate(3, $page);
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
				$tasks = Task::paginate(3, $page);
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
				$tasks = Task::paginate(3, $page);
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
				$tasks = Task::paginate(3, $page);
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
		$tasks = Task::select('id', 'name', 'email', 'text', 'status')->limit(3)->get();
		if ($option == 'name' || $option == 'email' || $option == 'status') {
			if (!isset($page) || $page == 1) {
			$tasks = Task::select('id', 'name', 'email', 'text', 'status')->limit(3)->offset(0)->orderBy($option, 'ASC')->get();
			}elseif($page == 2){
				$tasks = Task::select('id', 'name', 'email', 'text', 'status')->limit(3)->offset(3)->orderBy($option, 'ASC')->get();
			}else{
				$tasks = Task::select('id', 'name', 'email', 'text', 'status')->limit(3)->offset(3 * $page)->orderBy($option, 'ASC')->get();
			}
		}
		return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks]);
	}
}