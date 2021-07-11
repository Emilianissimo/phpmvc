<?php

namespace Config\Core;

class Route{
	static function start(){
		$controllerName = 'Main';
		$actionName = 'index';

		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (!empty($routes[1])) {
			$controllerName = $routes[1];
		}

		if (!empty($routes[2])) {
			$actionName = $routes[2];
		}

		$modelName = $controllerName;
		$controllerName = $controllerName.'Controller';
		$actionName = $actionName;

		$modelFile = strtolower($modelName).'.php';
		$modelPath = '../models/'.$modelFile;
		if (file_exists($modelPath)) {
			include '../models/'.$modelFile;
		}

		$controllerFile = $controllerName.'.php';
		$controllerPath = "../controllers/".$controllerFile;
		if(file_exists($controllerPath))
		{
			include "../controllers/".$controllerFile;
		}
		else
		{
			Route::ErrorPage404();
		}
		$controller = 'Controllers\\'.$controllerName;
		$controller = new $controller;
		$action = $actionName;
		
		if(method_exists($controller, $action))
		{
			$controller->$action();
		}
		else
		{
			Route::ErrorPage404();
		}
	}

	function ErrorPage404()
	{
  //       $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
  //       header('HTTP/1.1 404 Not Found');
		// header("Status: 404 Not Found");
		// header('Location:'.$host.'404');
		die('404');
    }
}