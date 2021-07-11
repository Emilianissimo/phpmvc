<?php

namespace Config\Core;

use Config\Core\View;

class Controller{
	public $model;
	public $view;

	function __construct(){
		$this->view = new View;
	}

	public function index(){}
}