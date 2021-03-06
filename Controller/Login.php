<?php
require_once('utils.php');
class Login{

	public function index(){
		close_user_session();
		require_once(ROOT.'View/login.php');
	}
	
	public function ConnectionAttempt(){
		if(!(isset($_POST['login']) && !empty($_POST['login'])
		&& isset($_POST['password']) && !empty($_POST['password']))){
			redirect('Login');
		}

		require_once('Model/Auth.php');
		init_user_session();

		$log = $_POST['login'];
		$pw = hash('sha256',$_POST['password']);
		$_POST['password'] = null;
		(new Auth())->checkCreds($log, $pw);
		if(!isset($_SESSION['login']) || !isset($_SESSION['userStatus']))
			redirect('Login');
		else
			redirect('Home');
	}
}