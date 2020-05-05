<?php
define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
require_once('utils.php');

$params = explode('/',$_GET['p']);

if(!empty($params[0])){
	$controllerName = ucfirst(strtolower($params[0]));
	$action = isset($params[1]) ? $params[1] : 'index';
	$controller = null;

	if(file_exists(ROOT.'Controller/'.$controllerName.'.php')){
		require_once(ROOT.'Controller/'.$controllerName.'.php');
		$controller = new $controllerName();
	}

	// echo 'controller '.$controllerName.' action '.$action;
	switch ($controllerName){
		case 'Home':
			session_start();
			if(isset($_SESSION['login'])){
				if(method_exists($controller,$action) && is_callable(array($controller, $action)))
					$controller->$action();
				else
					redirect('Home'); //envoyer sur 404 plutot que redirect ???
			}else
				redirect('Login'); // message not connected (message en $_POST['message'])
		break;

		case 'Login':
			if(method_exists($controller,$action) && is_callable(array($controller, $action)))
				$controller->$action();
			else
				redirect('Login'); //envoyer sur 404 plutot que redirect ???
		break;

		case 'deleteUser':
			echo 'delete user';
		break;
		default:
			http_response_code(404);
			echo 'cette page n\'existe pas';
	}

}elseif (session_start() && !isset($_SESSION['login'])){
	redirect('Login');
}else{
	redirect('Home');
}