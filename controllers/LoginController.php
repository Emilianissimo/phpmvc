<?php

namespace Controllers;

use Config\Core\Controller;

class LoginController extends Controller{

	public function index()
	{
		$this->view->render('login.php', 'layout.php');
	}

}