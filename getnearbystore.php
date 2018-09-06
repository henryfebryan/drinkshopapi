<?php 
	require_once 'db_functions.php';
	$db = new DB_Functions();

	if(isset($_POST['lat']) && isset($_POST['lng'])){
		$lat = $_POST['lat'];
		$lng = $_POST['lng'];

		$stores = $db->getNearbyStore($lat,$lng);
		if($stores){
			echo json_encode($stores);
		}
		else{
			echo json_encode("Store is not exists");
		}
	}else{
		$response = "Required parameter (lat,lng) is missing!";
		echo json_encode($response);
	}

?>
