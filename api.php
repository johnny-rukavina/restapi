<?php
$request_type = $_SERVER['REQUEST_METHOD'];
header('Content-type: application/json');
include_once("config.inc.php");
MYSQL_CONNECT("" . $host . "","" . $user. "","" . $password . "");
MYSQL_SELECT_DB( "Test") or die( "Unable to select database");
if ($request_type == "GET") {
	// GET a single provider
	if ($_GET['id']) {
		$json = getTheData($_GET['id']);
		if (!$json) {
			header("HTTP/1.0 404 Provider Not Found");			
		}
		else {
			echo json_encode($json);
		}			
	}
	// GET the list of services
	else if ($_GET['services']) {
		$query = "SELECT id,service from services order by service";
		$result = MYSQL_QUERY($query);
		$rows = array();
		while($row = mysql_fetch_assoc($result)) {
			$rows[] = $row;
		}
		$json = $rows;
		echo json_encode($json);
	}
	// GET all providers
	else {
		$query = "SELECT id,name,location,phone from providers order by name";
		$result = MYSQL_QUERY($query);
		$rows = array();
		while($row = mysql_fetch_assoc($result)) {
			$rows[] = $row;
		}
		foreach($rows as $key => $row) {	
		  $query1 = "SELECT service from services, provider_services where (services.id = provider_services.servicenumber) and (providernumber=" . $row['id'] . ")";
		  $result1 = MYSQL_QUERY($query1);
		  $rows1 = array();
		  while($r1 = mysql_fetch_row($result1)) {
		 	 $provides[] .= $r1[0];
		  }
		  $rows[$key]['provides'] = $provides;
			unset($provides);
		}
		$json = $rows;
		echo json_encode($json);
	}
}
// UPDATE a provider
else if ($request_type == "PUT") {
	parse_str(file_get_contents("php://input"),$put_vars);
	if (($put_vars['name'] == "") || ($put_vars['location'] == "") || ($put_vars['id'] == "")) {
		header("HTTP/1.0 422 Validation Failed");		
	}
	else {
		$query = "UPDATE providers set name='" . $put_vars['name'] . "',phone='" . $put_vars['phone'] . "',location='" . $put_vars['location'] . "' where id = " . $put_vars['id'] . "";
		$result = MYSQL_QUERY($query);
		$query1 = "DELETE from provider_services where providernumber = " . $put_vars['id'] . "";
		$result1 = MYSQL_QUERY($query1);
		foreach($put_vars['provides'] as $key=>$value) {
			$query3 = "SELECT id from services where service='" . $value . "'";		
			$result3 = MYSQL_QUERY($query3);		
		  $row3 = mysql_fetch_row($result3);
		 	$servicenumber = $row3[0];
			if ($servicenumber) {
				$query2 = "INSERT into provider_services (providernumber,servicenumber) values (" . $put_vars['id'] . "," . $servicenumber . ")";
				$result2 = MYSQL_QUERY($query2);
			}
		}
		header("HTTP/1.0 201 Provider Updated");
		$json = getTheData($put_vars['id']);
		echo json_encode($json);
	}
}
// ADD a new provider
else if ($request_type == "POST") {
	if (($_POST['name'] == "") || ($_POST['location'] == "")) {
		header("HTTP/1.0 422 Validation Failed");		
	}
	else {
		$query = "INSERT into providers (name,phone,location) values ('" . $_POST['name'] . "','" . $_POST['phone'] . "','" . $_POST['location'] . "')";
		$result = MYSQL_QUERY($query);	
		$query4 = "select LAST_INSERT_ID() as new_id";
		$result4 = MYSQL_QUERY($query4);	
	  $row4 = mysql_fetch_row($result4);
	 	$new_id = $row4[0];
		foreach($_POST['provides'] as $key=>$value) {
			$query3 = "SELECT id from services where service='" . $value . "'";		
			$result3 = MYSQL_QUERY($query3);		
		  $row3 = mysql_fetch_row($result3);
		 	$servicenumber = $row3[0];
			$query2 = "INSERT into provider_services (providernumber,servicenumber) values (" . $new_id . "," . $servicenumber . ")";
			$result2 = MYSQL_QUERY($query2);
		}
		$json = $new_id;
		header("HTTP/1.0 201 Provider Created");	
		$json = getTheData($new_id);
		echo json_encode($json);
	}
}
// DELETE a provider
else if ($request_type == "DELETE") {
	parse_str(file_get_contents("php://input"),$put_vars);
	$query = "DELETE from providers where id = " . $put_vars['id'] . "";		
	$result = MYSQL_QUERY($query);
	$query1 = "DELETE from provider_services where providernumber = " . $put_vars['id'] . "";	
	$result1 = MYSQL_QUERY($query1);
	header("HTTP/1.0 204 Provider Deleted");
}
// helper function to get the data for a given id
function getTheData($id) {
	$query = "SELECT id,name,location,phone from providers where id=" . $id . "";		
	$result = MYSQL_QUERY($query);
	if ($result) {
		$rows = array();
		while($row = mysql_fetch_assoc($result)) {
			$rows[] = $row;
		}
		foreach($rows as $key => $row) {	
		  $query1 = "SELECT service from services, provider_services where (services.id = provider_services.servicenumber) and (providernumber=" . $row['id'] . ")";
		  $result1 = MYSQL_QUERY($query1);
		  $rows1 = array();
		  while($r1 = mysql_fetch_row($result1)) {
		 	 $provides[] .= $r1[0];
		  }
		  $rows[$key]['provides'] = $provides;
			unset($provides);
		}
		return $rows;
	}
	else {
		return false;
	}
}
?>