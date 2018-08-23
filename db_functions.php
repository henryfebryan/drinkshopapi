<?php

class DB_Functions{

	private $conn;

	function __construct(){
		require_once 'db_connect.php'; 
		$db = new DB_Connect();
		$this->conn = $db->connect();
	}

	function __destruct(){

	}

	/*
		CheckUser exist
	*/
	function checkExistsUser($phone){
		$stmt = $this->conn->prepare("SELECT * FROM user WHERE Phone=?");
		$stmt->bind_param("s", $phone);
		$stmt->execute();
		$stmt->store_result();

		if($stmt->num_rows > 0){
			$stmt->close();
			return true;
		}else{
			$stmt->close();
			return false;
		}
	}

	/*
		Register new user
		return User object if user was created
		return false and show Error message if have exception
	*/
	public function registerNewUser ($phone, $name, $birthdate, $address) {
		$stmt = $this->conn->prepare("INSERT INTO user(Phone,Name,Birthdate,Address) VALUES(?,?,?,?)");
		$stmt->bind_param("ssss", $phone, $name, $birthdate, $address);
		$result = $stmt->execute();
		$stmt->close();

		if($result){
			$stmt = $this->conn->prepare("SELECT * FROM user WHERE Phone = ?");
			$stmt->bind_param("s", $phone);
			$stmt->execute();
			$user = $stmt->get_result()->fetch_assoc();
			$stmt->close();			
			return $user;
		}else{
			return false;
		}
	}

	/*
		Get User Information
		return User object if user exists
		return NULL if user not exists
	*/
	
	public function getUserInformation ($phone) {
		$stmt = $this->conn->prepare("SELECT * FROM User WHERE Phone=?");
		$stmt->bind_param("s",$phone);

		if($stmt->execute()){
			$user = $stmt->get_result()->fetch_assoc();
			$stmt->close();

			return $user;
		}else{
			return NULL;
		}
	}		

	/*
		Get Banner
		return Banner list
	*/
	
	public function getBanners() {
		$result = $this->conn->query("SELECT * FROM Banner ORDER BY ID LIMIT 3");

		$banners = array();

		while($item = $result->fetch_assoc()){
			$banners[] = $item;
		}
		return $banners;
	}	

	/*
		Get Menu
		return Menu list
	*/
	
	public function getMenu() {
		$result = $this->conn->query("SELECT * FROM Menu");

		$menu = array();

		while($item = $result->fetch_assoc()){
			$menu[] = $item;
		}
		return $menu;
	}	

	/*
		Get Drink base menu Id
		return drink list
	*/
	
	public function getDrinkByMenuID($menuId) {
		$result = $this->conn->query("SELECT * FROM Drink WHERE MenuId = '".$menuId."'");

		$drinks = array();

		while($item = $result->fetch_assoc()){
			$drinks[] = $item;
		}
		return $drinks;
	}	


	/*
		Update avatar url
		
	*/
	
	public function updateAvatar($phone,$fileName) {
		return $result = $this->conn->query("UPDATE user SET avatarUrl = '$fileName' WHERE Phone= '$phone' ");
	}	

}

?>