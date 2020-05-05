<?php
$db = new PDO('mysql:host=localhost:3306;dbname=users;charset=utf8','root' , '');

function connect(){
	if(isset($_POST['connectForm'])){
		if(!empty($_POST['login']))
			echo 'not empty';
		else
			echo 'empty';
		echo 'connect';
	}
}