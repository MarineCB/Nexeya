<?php
require_once('utils.php');
class Home {
	public function index(){
		if(isAdmin())
			$this->admin();
		elseif($_SESSION['userStatus'] == 'commercial')
			require('View/homeSalesman.php');
		elseif($_SESSION['userStatus'] == 'meca')
		require('View/homeMeca.php');
		elseif($_SESSION['userStatus'] == 'responsable-commercial')
			require('View/homeSalesmanager.php');
	}

	public function login(){
		redirect('Login');
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
			redirect('Home');
		
		if(isset($_POST['userId']) && !empty($_POST['userId'])){
			$id = $_POST['userId'];
			$_POST['userId'] = null;
			require_once('Model/Auth.php');
			(new Auth)->deleteUser($id);
		}
		redirect('Home');
	}
	public function addUser(){
		if(!isAdmin())
			redirect('Home');

		require('View/addUser.php');
		if(isset($_POST['inputUsername']) && !empty($_POST['inputUsername']) && isset($_POST['inputPassword1']) && !empty($_POST['inputPassword1'])){
			require_once('Model/Auth.php');
			$inputUsername = $_POST['inputUsername'];
			$inputPassword1 = hash('sha256',$_POST['inputPassword1']);
			$inputStatus = $_POST['inputStatus'];
			$response = (new Auth)->addUser($inputUsername, $inputPassword1, $inputStatus);
			$_POST['inputUsername'] = null;
			$_POST['inputPassword1'] = null;
			$_POST['inputPassword2'] = null;
			$_POST['inputStatus'] = null;
			echo $response;
		}
	}

	public function orderProduct(){
		if(!isAdmin() && !isSalesman() && !isSalesmanager())
			redirect('Home');

		require('View/orderProduct.php');
		if(isset($_POST['inputProduct']) && !empty($_POST['inputProduct']) && isset($_POST['inputQuantity']) && !empty($_POST['inputQuantity'])){
			require_once('Model/Auth.php');
			$inputProduct = $_POST['inputProduct'];
			$inputQuantity = $_POST['inputQuantity'];
			$response = (new Auth)->addOrder($inputProduct, $inputQuantity);
			$_POST['inputProduct'] = null;
			$_POST['inputQuantity'] = null;
			echo $response;
		}
	}

	public function ValidateOrder(){
		if(!isAdmin() && !isSalesmanager())
			redirect('Home');

		if(isset($_POST['orderId']) && !empty($_POST['orderId'])){
			$orderId = $_POST['orderId'];
			$_POST['orderId'] = null;
			require_once('Model/Auth.php');
			(new Auth)->validateOrder($orderId);
		}
		redirect('Home');
	}

	public function OrderDelivered(){
		if(!isMeca() && !isAdmin())
			redirect('Home');

		if(isset($_POST['orderIdDeliv']) && !empty($_POST['orderIdDeliv'])){
			$orderId = $_POST['orderIdDeliv'];
			$_POST['orderIdDeliv'] = null;
			require_once('Model/Auth.php');
			(new Auth)->orderDelivered($orderId);
		}
		redirect('Home');
	}

//a modifier
	public function ChangeProductPrice(){
		if(!isAdmin() && !isSalesman() && !isSalesmanager())
			redirect('Home');

		if(isset($_POST['price']) && !empty($_POST['price']) && isset($_POST['productName']) && !empty($_POST['productName'])){
			require_once('Model/Auth.php');
			$inputProductName = $_POST['productName'];
			$inputPrice = $_POST['price'];
			$response = (new Auth)->changeProductPrice($inputProductName, $inputPrice);
			$_POST['productName'] = null;
			$_POST['price'] = null;
			echo $response;
		}else
			echo 'Error !'.$_POST['productName'].$_POST['price'];
		redirect('Home');
	}

	public function addProduct(){
		if(!isAdmin() && !isSalesman() && !isSalesmanager())
			redirect('Home');

		require('View/addProduct.php');
		if(isset($_POST['inputProductname']) && !empty($_POST['inputProductname']) && isset($_POST['inputProductPrice']) && !empty($_POST['inputProductPrice'])){
			require_once('Model/Auth.php');
			$inputProductname = $_POST['inputProductname'];
			$inputProductPrice = $_POST['inputProductPrice'];
			$inputProductQuantity = isset($_POST['inputProductQuantity']) && !empty($_POST['inputProductQuantity']) ? $_POST['inputProductQuantity'] : 0;
			$response = (new Auth)->addProduct($inputProductname, $inputProductPrice, $inputProductQuantity);
			$_POST['inputProductname'] = null;
			$_POST['inputProductPrice'] = null;
			$_POST['inputProductQuantity'] = null;
			echo $response;
		}
	}
	
} 