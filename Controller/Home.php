<?php
require_once('utils.php');
class Home {
	public function index(){
		if(isAdmin())
			$this->admin();
		elseif($_SESSION['userStatus'] == 'commercial')
			require('View/homeCommercial.php');
		elseif($_SESSION['userStatus'] == 'meca')
			echo nl2br("\nHome Meca");
	}

	private function admin(){
		require('View/homeAdmin.php');
	}

	public function users(){
		if(!isAdmin())
			redirect('Home');
		echo 'userlist clicked';
	}
	public function deleteUser(){
		if(!isAdmin())
			return;
		
		if(isset($_POST['usernameToDel']) && !empty($_POST['usernameToDel'])){
			$username = $_POST['usernameToDel'];
			$_POST['usernameToDel'] = null;
			require_once('Model/Auth.php');
			(new Auth)->deleteUser($username);
			echo 'ok ex from js' . $username;
		}else
			redirect('Home');
	}

	public function ChangeProductPrice(){
		echo 'OK change price';
		require('View/homeAdmin.php');
	}
} 