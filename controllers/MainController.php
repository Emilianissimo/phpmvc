<?php

namespace Controllers;

use Config\Core\Controller;

class MainController extends Controller{

	public function index()
	{
		$this->view->render('main.php', 'layout.php');
	}

}