<?php
	$action = $_GET['action'];
	switch ($action) {
		case 'getcat':
			$toreturn = getAllSubCategories();
			break;
		case 'searchproducts':
			$toreturn = searchProducts($_GET['value']);
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
	
	function searchProducts($subcatname){
		$query = sprintf("SELECT sub.subcategory_id FROM subcategories sub WHERE sub.subcategory_name = '%s'", $subcatname);
		
		$results = do_query($query);
		
		$row = parse_results($results);
		
		$subcatid = $row[0][key($row[0])];
		
		$query = sprintf("SELECT * 	FROM products WHERE products.subcategory_id = %u", (int)$subcatid);
		
		$results = do_query($query);

		if ($results){
			$rows = parse_results($results);
			return array("status"=>1, "title"=>"Success", "msg"=>"Succesfully retrieved products.", "results"=>$rows);
		} else {
			return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to connect to server.");
		}
	}

	function searchProductCheap($value){
		$product = mysqli_real_escape_string(db_connect(), $value);
		
		$query = sprintf(
			"SELECT p.product_id FROM compare_prices p
			WHERE p.ppu = (SELECT MIN(ppu) FROM compare_prices WHERE compare_prices.product_brand = '%s')
			AND p.product_brand = '%s'", $product, $product
		);
		
		$results = do_query($query);
		
		if ($results) {
			$product_id = parse_results($results);

			$query = sprintf("SELECT * FROM products p WHERE p.product_id = %u", $product_id[0][key($product_id[0])]);
			
			$product = parse_results(do_query($query));
			
			return array("status"=>1, "title"=>"Success", "msg"=>"Succesfully search cheapest product", "results"=>$product);
		} else {
			return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to connect to server.");
		}
	}

	function searchProductName($value){
		$product = mysqli_real_escape_string(db_connect(), $value);
		
		if (strtolower($product) == 'beer'){
			$query = " SELECT * FROM products p
			WHERE p.product_brand = 'Heineken' OR p.product_brand = 'Amstel' OR p.product_brand = 'Hertog Jan'";
		} else {
			$query = sprintf(
			"SELECT * FROM products p
			WHERE p.product_brand = '%s'", $product);
		}
		
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
		
		$query = sprintf("SELECT create_cart(%u,'%s')", 902909309, $name);
		
		$cartid = do_query($query);
		
		$results = parse_results($cartid);
		
		$products = explode(",",$value);
		
		foreach ($products as $productid){
			if($productid){
				$insert = sprintf("INSERT INTO cart_details (cart_id, product_id) VALUES (%u, %u)", $results[0][key($results[0])], (int)$productid);
				
				$result = do_query($insert);
				
				if (!$result){
					$ok = FALSE;
					$query = sprintf("SELECT delete_cart(%u)", $results[0][key($results[0])]);
					$result = do_query($query);
					return array ("status"=>0, "title"=>"Failure", "msg"=>"Failed to save the cart.");
				}
			}
		}
		
		if ($ok == TRUE){
			return array("status"=>1, "title"=>"Success", "msg"=>"Cart saved successful.");
		}
	}
	
	function getCartContent($cartid){
		$query = sprintf("SELECT cd.product_id FROM cart_details cd WHERE cd.cart_id = %u", (int)$cartid);
		
		$results = do_query($query);
		
		if ($results){
			$productids = parse_results($results);
			
			$products = array();
			
			foreach ($productids as $product_id){

				$query = sprintf("SELECT * FROM products p WHERE p.product_id = %u", $product_id[key($product_id)]);
				
				$product = parse_results(do_query($query));
				
				
				if ($product){
					$products[] = $product;
				} else {
					return array("status"=>0, "title"=>"Failure", "msg"=>"Failed to retrieve cart product");
				}
			}
			return array("status"=>1, "title"=>"Success", "msg"=>"Succesfully got cart content", "results"=>$products);
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
		    	$rows[]  = array($prevRow => $row);
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