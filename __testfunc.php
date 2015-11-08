<?php
	$action = $_GET['action'];
	switch ($action) {
		case 'getcat':
			$toreturn = getAllSubCategories();
			break;
		case 'searchsubcat':
			$toreturn = searchSubCategories($_GET['value']);
			break;
		case 'searchproductcheap':
			$toreturn = searchProductCheap($_GET['value']);
			break;
		case 'searchproductname':
			$toreturn = searchProductName($_GET['value']);
			break;
		case 'getcarts':
			$toreturn = getAllCarts($_GET['value']);
			break;
		case 'getcartcontent':
			$toreturn = getCartContent($_GET['value']);
			break;
		case 'savecarts':
			$toreturn = saveCart($_GET['name'], $_GET['user'], $_GET['value']);
			break;	
		default:
			$toreturn = array("status"=>0, "title"=>"Forbidden", "msg"=>"Forbidden attempt at backend functionallity.");
			break;
	}
	
	echo json_encode($toreturn);
	exit();

	function searchProductCheap($value){
		$product = mysqli_real_escape_string(db_connect(), $value);
		
		$query = sprintf(
			"SELECT * FROM products p
			WHERE p.price = (SELECT MIN(price) FROM products WHERE products.product_brand = '%s')
			AND p.product_brand = '%s'", $product, $product
		);
		
		$results = do_query($query);
		
		if ($results) {
			$rows = parse_results($results);
			return array("status"=>1, "title"=>"Success", "msg"=>"Succesfully search cheapest product", "results"=>$rows);
		} else {
			return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to connect to server.");
		}
	}

	function searchProductName($value){
		$product = mysqli_real_escape_string(db_connect(), $value);
		
		$query = sprintf(
			"SELECT * FROM products p
			WHERE p.product_brand = '%s'", $product
		);
		
		$results = do_query($query);
		
		if ($results) {
			$rows = parse_results($results);
			return array("status"=>1, "title"=>"Success", "msg"=>"Succesfully search product", "results"=>$rows);
		} else {
			return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to connect to server.");
		}
	}

	function saveCart($name, $userid, $value){
		$ok = TRUE;
		
		$query = sprintf("SELECT create_cart(%u,'%s')", (int)$userid, $name);
		
		$cartid = do_query($query);
		
		$products = explode(",",$value);
		
		foreach ($products as $productid){
			$insert = sprintf("INSERT INTO cart_details (cart_id, product_id) VALUES (%u, %u)", $cartid, (int)$productid);
			
			$result = do_query($insert);
			
			if (!$result){
				$ok = FALSE;
				return array ("status"=>0, "title"=>"Failure", "msg"=>"Failed to connect to server.");
			}
		}
		
		if ($ok == TRUE){
			return array("status"=>1, "title"=>"Success", "msg"=>"Cart saved successful.");
		}
	}

	function getCartContent($cartid){
		$query = sprintf("SELECT cd.product_id FROM cart_details cd WHERE cd.user_id = %u", (int)$cartid);
		
		$results = do_query($query);
		
		if ($results){
			$productids = parse_results($results);
			
			$rows = "";
			
			foreach ($productids as $product_id){
				$query = sprintf("SELECT * FROM products p WHERE p.product_id = %u", (int)$product_id);
				$result = do_query($query);
				
				if ($result){
					$rows .= $result . ",";
				} else {
					return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to retrieve cart product");
				}
			}
			
			return array("status"=>1, "title"=>"Success", "msg"=>"Succesfully get cart content", "results"=>$rows);
		} else {
			return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to connect to server.");
		}
	}

	function getAllCarts($userid){
		$query = sprintf("SELECT * FROM carts WHERE carts.user_id = %u", (int)$userid);
		
		$results = do_query($query);
		
		if ($results){
			$rows = parse_results($results);
			return array("status"=>1, "title"=>"Success", "msg"=>"Succesfully get all carts", "results"=>$rows);
		} else {
			return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to connect to server.");
		}
	}

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

	function getAllSubCategories(){
		$query = sprintf(
			"SELECT c.category_name, s.subcategory_name
			FROM categories c
			JOIN subcategories s 
			ON c.category_id = s.category_id"
		);
		
		$results = do_query($query);

		if ($results){
			$rows = parse_categories($results);
			return array("status"=>1, "title"=>"Success", "msg"=>"Succesfully retrieved subcategories.", "results"=>$rows);
		} else {
			return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to connect to server.");
		}	
	}

	function db_connect(){		
		static $connection;
		
		if(!isset($connection)) {
			$db = parse_ini_file("database.ini");
			$username 	= $db['username'];
			$password 	= $db['password'];
			$dbname 	= $db['dbname'];
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

	function parse_categories($results){
		$rows = array();
		$i = 0;
		$prevRow = 0;
		while ($result = $results->fetch_assoc()) {
			$keys = array_keys($result);
			if ($i == 0) {
				$row 	 = array();
				$row[]   = $result[$keys[1]];
				$prevRow = $result[$keys[0]];
		    } else {
		    	if ($result[$keys[0]] == $prevRow){ //if this category is same as previous
		    		$row[] = $result[$keys[1]];
		    	} else {
		    	$rows[]  = array($result[$keys[0]] => $row);
		    	$prevRow = $result[$keys[0]];
		    	$row 	 = array();
		    	$row[]   = $result[$keys[1]];
		    	}
		    }
		    $i++;	
		}
		return $rows;
	}
?>