<?php

namespace Controllers;

use Models\Task;
use Config\Core\View;
use Database\Database;
use Config\Core\Controller;

class TaskController extends Controller{

	function __construct()
	{
		$this->view = new View;
	}

	public function index()
	{
		$dt = new Database; 
		$page = $_GET['page'] ?? 1;
		$pageCount = ceil(Task::all()->count() / 3);
		$tasks = Task::paginate(3, $page);
		$option = $_GET['option'];
		$order = $_GET['order'];
		if (isset($option)) {
			$tasks = Task::select('id', 'name', 'email', 'text', 'status')->limit(3)->get();
			if ($option == 'name' || $option == 'email' || $option == 'status') {
				if (!isset($page) || $page == 1) {
				$tasks = Task::select('id', 'name', 'email', 'text', 'status')->limit(3)->offset(0)->orderBy($option, $order)->get();
				}elseif($page == 2){
					$tasks = Task::select('id', 'name', 'email', 'text', 'status')->limit(3)->offset(3)->orderBy($option, $order)->get();
				}elseif($page == ''){
				    $tasks = Task::select('id', 'name', 'email', 'text', 'status')->limit(3)->offset(0)->orderBy($option, $order)->get();
				}else{
					$tasks = Task::select('id', 'name', 'email', 'text', 'status')->limit(3)->offset(3 * $page)->orderBy($option, $order)->get();
				}
			}
		}
		return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks, 'pageCount'=>$pageCount, 'page'=>$page, 'option'=>$option, 'order'=>$order]);
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
			$pageCount = ceil(Task::all()->count() / 3);
			return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks, 'message' => 'Задача добавлена', 'pageCount'=>$pageCount, 'page'=>$page]);
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
				$pageCount = ceil(Task::all()->count() / 3);
				return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks, 'messageEdit' => 'Задача изменена', 'pageCount'=>$pageCount, 'page'=>$page]);
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
				$pageCount = ceil(Task::all()->count() / 3);
				return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks, 'messageDelete' => 'Задача удалена', 'pageCount'=>$pageCount, 'page'=>$page]);
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
				$pageCount = ceil(Task::all()->count() / 3);
				return $this->view->render('tasks.php', 'layout.php', ['tasks'=>$tasks, 'messageChange' => 'Статус изменён', 'pageCount'=>$pageCount, 'page'=>$page]);
			}
			header("Location: ". $_POST['location']);
			exit();
		}else{
			header("Location: ". $_POST['login']);
			exit();
		}
	}
}
