<?php

class Auth{
	private $host='localhost';
	private $dbname='users';
	private $username='root';
	private $password='';

	protected $db;

	public function getDb(){
		$this->db = null;
		require_once('utils.php');
		try{
			$this->db = new PDO('mysql:host='.$this->host.':3306;dbname='.$this->dbname.';charset=utf8',$this->username , $this->password);
		}catch(PDOException $e){
			echo 'Erreur : '. $e->getMessage();
		}
	}

	public function checkCreds(){
		$this->getDb();
		#Hash le password
		$password = hash('sha256',$_POST['password']);
		$_POST['password']=null;

		$login = $_POST['login'];

		$SQL= "SELECT DISTINCT user_type FROM users WHERE username=? AND password=? ";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1,$login);
		$result->bindParam(2,$password);
		$result->execute();
		$count=0;
		foreach ($result as $row){
			if(isset($row) && !empty($row)){
				init_user_session();
				$_SESSION["login"] = $login;
				$_SESSION["userStatus"] = $row["user_type"];
				$count++;
			}
		}
		$result ->closeCursor();		
	}

	public function getUsersList(){
		$this->getDb();
		$SQL= "SELECT id,username,user_type FROM users";
		$result = $this->db->prepare($SQL);
		if($result->execute()){
			return $result;
		}
	}

	public function getProductsList(){
		$this->getDb();
		$SQL= "SELECT * FROM products";
		$result = $this->db->prepare($SQL);
		if($result->execute()){
			return $result;
		}
	}

	public function getProduct($product_id){
		$this->getDb();
		$SQL= "SELECT * FROM products WHERE id=?";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1, $product_id);
		if($result->execute()){
			return $result->fetch();
		}
	}

	public function addProduct($productName, $productPrice, $productQuantity){
		$this->getDb();
		$SQL= "INSERT INTO products (name, price, quantity) VALUES (?,?,?)";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1,$productName);
		$result->bindParam(2,$productPrice);
		$result->bindParam(3,$productQuantity);
		if($result->execute()){
			return 'Product successfully added';
		}else
			return 'Error: product not added';
	}

	public function changeProductPrice($productName, $newPrice){
		$this->getDb();
		$SQL= "UPDATE products SET price = ? WHERE name=?";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1, $newPrice);
		$result->bindParam(2, $productName);
		if($result->execute()){
			echo 'success price changed';
		}else
			echo 'Error: price not changed';
	}

	public function getOrdersList(){
		$this->getDb();
		$SQL= "SELECT * FROM orders o";
		$result = $this->db->prepare($SQL);
		if($result->execute()){
			return $result;
		}
	}

	public function deleteUser($id){
		$this->getDb();
		$SQL= "DELETE FROM users WHERE id = ?";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1,$id);
		if($result->execute()){
			echo 'success deleted';
		}else
			echo 'error not deleted';
	}

	public function addUser($username, $password, $status){
		$this->getDb();
		$SQL= "INSERT INTO users (username, password, user_type) VALUES (?,?,?)";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1,$username);
		$result->bindParam(2,$password);
		$result->bindParam(3,$status);
		if($result->execute()){
			return 'User successfully added';
		}else
			return 'Error: user not added';
	}

	public function addOrder($productId, $quantity){
		$this->getDb();
		if(isSalesman())
			$SQL= "INSERT INTO orders (product_id, quantity, status) VALUES (?,?,'En attente de validation')";
		else
			$SQL= "INSERT INTO orders (product_id, quantity, status) VALUES (?,?,'Commandé')";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1,$productId);
		$result->bindParam(2,$quantity);
		if($result->execute()){
			return 'Ordered successfully';
		}else
			return 'Error';
	}

	public function validateOrder($orderId){
		$this->getDb();
		$SQL= "UPDATE orders SET status = 'Commandé' WHERE id =?";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1,$orderId);
		if($result->execute()){
			return '';
		}else
			return '';
	}

	public function orderDelivered($orderId){
		$this->getDb();
		$SQL= "UPDATE orders SET status = 'Livré' WHERE id =?";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1,$orderId);
		if($result->execute()){
			$this->updateStock($orderId);
			return '';
		}else
			return '';
	}

	public function updateStock($orderId){
		$this->getDb();
		$SQL= "SELECT product_id,quantity FROM orders WHERE id =?";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1,$orderId);
		if($result->execute()){
			$row = $result->fetch();
			$product_id = $row['product_id'];
			$quantity = $row['quantity'];
			$SQL2= "UPDATE products SET quantity = quantity + ? WHERE id =?";
			$result2 = $this->db->prepare($SQL2);
			$result2->bindParam(1,$quantity);
			$result2->bindParam(2,$product_id);
			$result2->execute();
			return '';
		}else
			return '';
	}

	public function getStock(){
		$this->getDb();
		$SQL= "SELECT name,quantity FROM products";
		$result = $this->db->prepare($SQL);
		if($result->execute()){
			return $result;
		}
	}

}