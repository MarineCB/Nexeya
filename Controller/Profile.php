<?php
require_once('utils.php');
class Profile{

	public function index(){
		require_once(ROOT.'View/profile.php');
		if(isset($_POST['inputOldPassword']) && !empty($_POST['inputOldPassword']) && isset($_POST['inputNewPassword']) && !empty($_POST['inputNewPassword'])){
			require_once('Model/Auth.php');
			$login = $_SESSION['login'];
			$inputOldPassword = hash('sha256',$_POST['inputOldPassword']);
			$inputNewPassword = hash('sha256',$_POST['inputNewPassword']);
			$response = (new Auth)->changePassword($login, $inputOldPassword, $inputNewPassword);
			$_POST['inputOldPassword'] = null;
			$_POST['inputNewPassword'] = null;
			echo $response;
		}
	}
}