<?php
	$action = $_GET['action'];
	switch ($action) {
		case 'getcat':
			$toreturn = getCategories();
			break;
		case 'searchsubcat':
			$toreturn = searchSubCategories($_GET['value']);
			break;	
		default:
			$toreturn = array("status"=>0, "title"=>"Forbidden", "msg"=>"Forbidden attempt at backend functionallity.");
			break;
	}
	echo json_encode($toreturn);
	exit();

	function getCategories(){
		$query = sprintf("SELECT * 	FROM categories");
		
		$results = do_query($query);

		if ($results){
			$rows = parse_results($results);
			return array("status"=>1, "title"=>"Success", "msg"=>"Succesfully retrieved categories.", "results"=>$rows);
		} else {
			return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to connect to server.");
		}
	}

	function searchSubCategories($value){
		$query = sprintf(
			"SELECT p.* 
			FROM products p, subcategories s
			WHERE s.subcategory_name =  '%s'
			AND p.subcategory_id = s.subcategory_id", 
			mysqli_real_escape_string(db_connect(), $value)
		);
		
		$results = do_query($query);

		if ($results){
			$rows = parse_results($results);
			return array("status"=>1, "title"=>"Success", "msg"=>"Succesfully search subcategories.", "results"=>$rows);
		} else {
			return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to connect to server.");
		}
	}

	function db_connect(){
		$username 	= "grogo";
		$password 	= "#fusehack";
		$dbname 	= "grogo_db";
		
		static $connection;
		
		if(!isset($connection)) {
			$connection = mysqli_connect('localhost',$username, $password, $dbname);
		}
		return $connection;
	}

	function do_query($query){
		$result = mysqli_query(db_connect(), $query);
		return $result;
	}

	function parse_results($results){
		$rows = array();
		while ($row = $results->fetch_assoc()){
			$rows[] = $row;
		}
		return $rows;
	}


?>
