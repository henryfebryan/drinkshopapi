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

	/*
		getall drink list
	*/
	public function getAllDrinks() {
		$result = $this->conn->query("SELECT * FROM drink WHERE 1") or die ($this->conn->error);

		$drinks = array();
		while ($item = $result->fetch_assoc()) {
			$drinks[] = $item;
		}
		return $drinks;
	}


	/*
		Insert new order
		return true or false
	*/
	public function insertNewOrder ($orderPrice, $orderComment, $orderAddress, $orderDetail, $userPhone) {
		$stmt = $this->conn->prepare("INSERT INTO `order`(`OrderStatus`, `OrderPrice`, `OrderDetail`, `OrderComment`, `OrderAddress`, `UserPhone`) VALUES (0,?,?,?,?,?)") or die($this->conn->error);
		$stmt->bind_param("sssss", $orderPrice, $orderDetail, $orderComment, $orderAddress,$userPhone);
		$result = $stmt->execute();
		$stmt->close();

		if($result){
			return true;
		}else{
			return false;
		}
	}

	//Seller
	/*
		Insert new category
		return true or false
	*/
	public function insertNewCategory ($name, $imgPath) {
		$stmt = $this->conn->prepare("INSERT INTO `menu`(`Name`, `Link`) VALUES (?,?)") or die($this->conn->error);
		$stmt->bind_param("ss",$name,$imgPath);
		$result = $stmt->execute();
		$stmt->close();

		if($result){
			return true;
		}else{
			return false;
		}
	}

	/*
		update category
		return true or false
	*/
	public function updateCategory ($id, $name, $imgPath) {
		$stmt = $this->conn->prepare("UPDATE `menu` SET `Name`=?,`Link`=? WHERE `ID`=?");
		$stmt->bind_param("sss",$name,$imgPath,$id);
		$result = $stmt->execute();
		return $result;
	}

	/*
		delete category
		return true or false
	*/
	public function deleteCategory ($id) {
		$stmt = $this->conn->prepare("DELETE FROM `menu` WHERE  `ID`=? ");
		$stmt->bind_param("s",$id);
		$result = $stmt->execute();
		return $result;
	}

	/*
		Insert new drink
		return true or false
	*/
	public function insertNewDrink ($name, $imgPath, $price, $menuId) {
		$stmt = $this->conn->prepare("INSERT INTO `drink`(`Name`, `Link`, `Price`, `MenuId`) VALUES (?,?,?,?)") or die($this->conn->error);
		$stmt->bind_param("ssss",$name,$imgPath,$price,$menuId);
		$result = $stmt->execute();
		$stmt->close();

		if($result){
			return true;
		}else{
			return false;
		}
	}

	/*
		update drink
		return true or false
	*/
	public function updateProduct ($id, $name, $imgPath, $price, $menuId) {
		$stmt = $this->conn->prepare("UPDATE `drink` SET `Name`=?,`Link`=?, `Price`=?,`MenuId`=? WHERE `ID`=?");
		$stmt->bind_param("sssss",$name,$imgPath,$price,$menuId,$id);
		$result = $stmt->execute();
		return $result;
	}

	/*
		delete drink
		return true or false
	*/
	public function deleteProduct ($id) {
		$stmt = $this->conn->prepare("DELETE FROM `drink` WHERE  `ID`=? ");
		$stmt->bind_param("s",$id);
		$result = $stmt->execute();
		return $result;
	}


	/*
		get all order based on userphone and status
		return order list
	*/
	
	public function getOrderByStatus($userPhone,$status) {
		$query = "SELECT * FROM `order` WHERE `OrderStatus` = '".$status. "' AND `UserPhone` = '".$userPhone."' ";
		$result = $this->conn->query($query) or die($this->conn->error);

		$orders = array();
		while ($order = $result->fetch_assoc()) {
			$orders[] = $order;
		}
		return $orders;
	}	


}

?>