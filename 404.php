<?php

$action = $_GET['action'];

switch (variable) {
	case 'getcat':
		$toreturn = getCategories();
		break;
	case 'searchSubCategories':
		$toreturn = searchSubCategories($_GET('value'));
		break;	
	default:
		$toreturn = array("status"=>0, "title"=>"Forbidden", "msg"=>"Forbidden attempt at backend functionallity.");
		break;
}
echo json_encode($toreturn);
exit();