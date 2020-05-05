<?php

class Auth{
	private $host='localhost';
	private $dbname='users';
	private $username='root';
	private $password='';

	protected $db;

	public function getDb(){
		$this->db = null;
		
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

		/*if( $password == false){
			redirect_to_connexion("Un probleme est survenu, merci de vous reconnecter");
		}*/

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
			}
			$count++;
		}
		$result ->closeCursor();		
	}

	public function getUsersList(){
		$this->getDb();
		$SQL= "SELECT username,user_type FROM users";
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

	public function getOrdersList(){
		$this->getDb();
		$SQL= "SELECT * FROM orders o";
		$result = $this->db->prepare($SQL);
		if($result->execute()){
			return $result;
		}
	}

	public function deleteUser($username){
		$this->getDb();
		$SQL= "DELETE FROM users WHERE username = ?";
		$result = $this->db->prepare($SQL);
		$result->bindParam(1,$username);
		if($result->execute()){
			echo 'success deleted';
		}else
			echo 'error not deleted';
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