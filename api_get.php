<?php

// define("BR", "</br>");

// echo 'api.php';
// echo BR;
// $path = $_GET['PATH_INFO'];

// RewriteRule ^api/(.*)$ api.php?PATH_INFO=$1


// echo error;
$path_info = $_GET['PATH_INFO'];
$strQuery = $_SERVER['QUERY_STRING'];

// echo '<br>';
// print_r($path);
// echo '<br>';
// echo $path1;
// echo BR;

// echo '123';
// $method = strtolower($_SERVER['REQUEST_METHOD']); 
// echo 'method'.'='.$method;
// echo BR;


// $request = explode('/', $path);
// $request = $path['space'];

// print_r($request);
// echo BR;


switch ($path_info) {
	/*
	case 'job':	
		resultWithJson(job($request[1]));
		break;
		*/
	case 'login':
		// resultWithJson(json_decode($request[1]));
		loginWithData([
			'username' => $_GET['username'],
			'password' => $_GET['password'],
		]);
		break;
	
	default:
		echo "I don't no the url";
		die;
		// echo BR;
		break;
}

function loginWithData($data) {
	$username = $data['username'];
	$password = $data['password'];
	global $strQuery;
	$result = [
		'username' => $username,
		'password' => $password,
		'param' => $strQuery,
	];
	$resultJson = json_encode($result);
	resultWithJson($resultJson);
}



function resultWithJson($json) {
	if ($json) {
		$result = json_encode($json);
		http_response_code(200);
		header('Content-Type: application/json');
		print $result;
		return;
	}

	http_response_code(404);
}






?>