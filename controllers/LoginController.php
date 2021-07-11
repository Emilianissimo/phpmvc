<?php

namespace Controllers;

use Config\Core\Controller;

class LoginController extends Controller{

	public function index()
	{
		$this->view->render('loginForm.php', 'layout.php');
	}

	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$login = $_POST['login'];
			$password = $_POST['password'];
			$expectingLogin = 'admin';
			$expectingPassword = '123';
			if ($login == $expectingLogin and $password == $expectingPassword) {
				$_SESSION['admin'] = 1;
				header("Location: ". $_POST['location']);
				exit();
			}else{
				return $this->view->render('loginForm.php', 'layout.php', ['message'=>'Неверный логин или пароль']);
			}
		}
	}

	public function logout()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			unset($_SESSION['admin']);
			header("Location: ". $_POST['location']);
			exit();
		}
	}

}