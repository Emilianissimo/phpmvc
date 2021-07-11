<?php

namespace Config\Core;

class Route{
	static function start(){
		$controllerName = 'Main';
		$actionName = 'index';

		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (!empty($routes[1])) {
			$controllerName = ucfirst($routes[1]);
			if (strpos($routes[1], '?')) {
				$controllerName = substr(ucfirst($routes[1]), 0, strpos(ucfirst($routes[1]), "?"));;
			}
		}

		if (!empty($routes[2])) {
			$actionName = $routes[2];
			if (strpos($routes[2], '?')) {
				$actionName = substr($routes[2], 0, strpos($routes[2], "?"));;
			}
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
		die('404');
    }
}