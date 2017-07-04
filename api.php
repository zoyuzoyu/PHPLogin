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

function responseError() {
	$response = [
		'state' => 0,
	];
	http_response_code(405);
	header('Content-Type: application/json');
	print json_encode($response);
}

function responseSuccess($body) {
	$response = [
		'state' => 1,
		'data' => $body
	];
	http_response_code(200);
	header('Content-Type: application/json');
	print json_encode($response);
}


?>