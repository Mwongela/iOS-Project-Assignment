<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 }

/*
 * index.php 
 */
if (isset($_REQUEST['tag']) && $_REQUEST['tag'] != '') {

    $tag = $_REQUEST['tag'];

    date_default_timezone_set("Africa/Nairobi");

    $response = array("tag" => $tag, "success" => 0, "error" => 0);

    # Methods
    require_once 'include/DB_Connect.php';

    $db = new DB_Connect();
	$db->connect();
	
	if($tag == 'search') {
	
		$type = $_REQUEST['type'];
		$s = $_REQUEST['s'];
	
		$sql = "";
		
		if($type == 'doctor') {
		
			$sql = "SELECT *  FROM `doctors` WHERE `name` LIKE '%$s%' OR `reg_no` LIKE '%$s%' ORDER BY `name`;";
		
		} else {
			
			$sql = "SELECT *  FROM `facility` WHERE `name` LIKE '%$s%' OR `reg_no` LIKE '%$s%';";
			
		}
		
		$results = mysql_query($sql) or die(mysql_error());
		
		if($results) {
		
			$response['results'] = array();
			
		
			while($row = mysql_fetch_array($results)) {
			
				$result = array();
				$result['reg_no'] = $row['reg_no'];
				$result['name'] = $row['name'];
				$result['info'] = $type == 'doctor' ? $row['speciality'] : $row['address'];
				
				array_push($response['results'], $result);
			
			}
			
			$response['success'] = 1;
		
		} else {

			$response["error"] = 1;
			$response["message"] = "An error occured. We're working on it";
		
		}
		
		generateOutput($response);		
	
	} else if($tag == 'search_doctor') {

		$regNumber = $_REQUEST['reg_no'];
		$sql = "SELECT *  FROM `doctors` WHERE `reg_no` = '$regNumber'";
		$results = mysql_query($sql) or die(mysql_error());
		if($results) {
			$response["success"] = 1;
			if(mysql_num_rows($results) > 0) {
				$row = mysql_fetch_array($results);
				$response["is_existed"] = true;
				$response["message"] = "Record found";
				$response["name"] = $row["name"];
				$response["reg_date"] = $row["reg_date"];
				$response["reg_no"] = $row["reg_no"];
				$response["address"] = $row["address"];
				$response["qualifications"] = $row["qualifications"];
				$response["speciality"] = $row["speciality"];
				$response["sub_speciality"] = $row["sub_speciality"];
			} else {
				$response["is_existed"] = false;
				$response["reg_no"] = $regNumber;
				$response["message"] = "Record not found";			
			}
		} else {
			$response["error"] = 1;
			$response["message"] = "An error occured. We're working on it";
		}

		generateOutput($response);

	} else if($tag == 'search_facility_by_reg') {

		$regNumber = $_REQUEST['reg_no'];
		$sql = "SELECT *  FROM `facility` WHERE `reg_no` = '$regNumber'";
		$results = mysql_query($sql) or die(mysql_error());
		if($results) {
			$response["success"] = 1;
			if(mysql_num_rows($results) > 0) {
				$row = mysql_fetch_array($results);
				$response["is_existed"] = true;
				$response["message"] = "Record found";
				$response["name"] = $row["name"];
				$response["reg_no"] = $row["reg_no"];
				$response["address"] = $row["address"];
				$response["type"] = $row["type"];
				$response["bed_capacity"] = $row["bed_capacity"];
			} else {
				$response["is_existed"] = false;
				$response["reg_no"] = $regNumber;
				$response["message"] = "Record not found";			
			}
		} else {
			$response["error"] = 1;
			$response["message"] = "An error occured. We're working on it";
		}

		generateOutput($response);
		
	} else if($tag == 'search_facility_by_name') {

		$name = $_REQUEST['name'];
		$sql = "SELECT *  FROM `facility` WHERE `name` LIKE '%$name%'";
		$results = mysql_query($sql) or die(mysql_error());
		if($results) {
			$response["success"] = 1;
			if(mysql_num_rows($results) > 0) {
				$response["results"] = array();
				$response["is_existed"] = true;
				$response["message"] = "Record found";
				while($row = mysql_fetch_array($results)):
					$record = array();
					$record["name"] = $row["name"];
					$record["reg_no"] = $row["reg_no"];
					$record["address"] = $row["address"];
					$record["type"] = $row["type"];
					$record["bed_capacity"] = $row["bed_capacity"];
					array_push($response['results'], $record);
				endwhile;
			} else {
				$response["is_existed"] = false;
				$response["message"] = "Record not found";			
			}
		} else {
			$response["error"] = 1;
			$response["message"] = "An error occured. We're working on it";
		}

		generateOutput($response);
		
	} else if($tag == 'report_issue') {
		$phone_number = $_REQUEST['phone_number'];
		$category = $_REQUEST['category'];
		$details = $_REQUEST['details'];
		$reg_number = $_REQUEST['reg_no'];
		$fname = $_REQUEST['fname'];
		$lname = $_REQUEST['lname'];
		$lat = $_REQUEST["lat"];
		$lng = $_REQUEST["lng"];

		$sql = "INSERT INTO `azadauto_trudaktari`.`issues` (`index`, `phone_number`, `fname`, `lname`, `category`, `details`, `reg_no`, `lat`, `lng`) VALUES (NULL, '$phone_number', '$fname', '$lname', '$category', '$details', '$reg_number', '$lat', '$lng');";
		$results = mysql_query($sql) or die(mysql_error());
		if($results) {
			$response["success"] = 1;
			$response["message"] = "Issue reported successfully";
		} else {
			$response["error"] = 1;
			$response["message"] = "An error occured while processing the request. Please try again";
		}
		generateOutput($response);

	} else if($tag == "rate") {
		$type = $_REQUEST["type"];
		$phone_number = $_REQUEST["phone_number"];
		$rating = $_REQUEST["rating"];
		$comment = $_REQUEST["comment"];
		$reg_number = $_REQUEST["reg_no"];
		$fname = $_REQUEST['fname'];
		$lname = $_REQUEST['lname'];

		$sql = "INSERT INTO `azadauto_trudaktari`.`user_rates` (`index`, `type`, `phone_number`, `fname`, `lname`, `time`, `rating`, `comment`, `reg_no`) VALUES (NULL, '$type', '$phone_number', '$fname', '$lname', CURRENT_TIMESTAMP, '$rating', '$comment', '$reg_number');";
		$results = mysql_query($sql) or die(mysql_error());
		if($results) {
			$response["success"] = 1;
			$response["message"] = "Thank you for the feedback";
		} else {
			$response["error"] = 1;
			$response["message"] = "An error occured while processing the request. Please try again";
		}
		generateOutput($response);
	
	} else if($tag == "useful_info") {
	
		$sql = "SELECT * FROM  `useful_info`";
		$results = mysql_query($sql) or die(mysql_error());
		
		if($results) {
		
			$response['info'] = array();
			
		
			while($row = mysql_fetch_array($results)) {
			
				$info = array();
				$info['title'] = $row['title'];
				$info['content'] = $row['content'];
				
				array_push($response['info'], $info);
			
			}
			
			$response['success'] = 1;
		
		} else {

			$response["error"] = 1;
			$response["message"] = "An error occured. We're working on it";
		
		}
		
		generateOutput($response);
	
	} else if($tag == "report_map") {
	
		$sql = "SELECT lat, lng, fname, details FROM  `issues`";
		$results = mysql_query($sql) or die(mysql_error());
		if($results) {
		
			$response["reports"] = array();
			
			while($row = mysql_fetch_array($results)) {
			
				$report = array();
				$report['lat'] = $row['lat'] == "" ? 0 : $row['lat'];
				$report['lng'] = $row['lng'] == "" ? 0 : $row['lng'];
				$report['by'] = $row['fname'] == "" ? "Anonymous" : $row['fname'];
				$report['details'] = $row['details'];
				
				
				array_push($response['reports'], $report);
			
			}
			
			$response['success'] = 1;
		
		} else {

			$response["error"] = 1;
			$response["message"] = "An error occured. We're working on it";
		
		}
		
		generateOutput($response);
	
	} else {

		$res = array('message' => "Invalid Request", 'success' => 0, 'error' => 1 );
		echo json_encode($res);
	}

} else {
	$res = array('message' => "Access Denied", 'success' => 0, 'error' => 1 );
	echo json_encode($res);

}

// Utility functions
/*
 * generate JSON output
 */
function generateOutput($output) {
	//error_reporting(0);
	//header('Content-Type: application/x-json');
	echo json_encode($output);
}
?>