<?php

// $user = $_POST['user'];
$path_info = explode('/', $_GET['PATH_INFO'])[0];
$strQuery = $_SERVER['QUERY_STRING'];

$method = strtolower($_SERVER['REQUEST_METHOD']);
switch ($method) {
	case 'post':
		post($path_info,json_decode(file_get_contents('php://input'),true));
		break;
	
	default:
		responseError();
		break;
}

function post($space,$param) {
	switch ($space) {
		case 'login':
			login($param);
			break;	
		default:
			responseError();
			break;
	}
}

function login($param) {
	// return $param;
	responseSuccess($param);
}

function responseError($message) {
	$response = [
		'state' => 0,
		'message' => $message,
	];
	http_response_code(405);
	header('Content-Type: application/json');
	print json_encode($response);
	die;
}

function responseSuccess($body) {
	$response = [
		'state' => 1,
		'message' => 'Login Success!',
		'data' => $body
	];
	http_response_code(200);
	header('Content-Type: application/json');
	print json_encode($response);
	die;
}



function connectDB() {	
	$user = 'root';
	$password = 'root';
	$db = 'phplogin';
	$host = 'localhost';
	$port = 8889;

	$link = mysqli_connect(
	   "$host:$port", 
	   $user, 
 	   $password
	);

	if (mysqli_connect_errno()) {
    	responseError();

	}

	$db_selected = mysqli_select_db(
    	$link,
    	$db
	);

	return $link;
}

function closeDB($link) {
	mysqli_close($link);
}

function addUserIntoDB($link,$username,$password) {
	mysqli_query($link,"INSERT INTO user (username, password) VALUES (" .$username. "," .$password. ")");
}



















?>