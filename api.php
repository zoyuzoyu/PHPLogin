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
		case 'regist':
			regist($param);
			break;	
		default:
			responseError();
			break;
	}
}

function login($param) {
	// return $param;
	$username = $param['username'];
	$password = $param['password'];
	if (strlen($username) < 6|| strlen($password)<6) {
		responseError('用户名或密码错误');
	}

	$link = connectDB();

	if ($link) {
		$result = isExsiteFromDB($link,$username,$password);
		$err_message = mysqli_error($link);
		closeDB($link);

		if ($result) {
			responseSuccess('Login Success!');
		} else {
			responseError($err_message?:'用户名或密码错误');
		}
	} else {
		responseError('connectDB error');
	}
}

function regist($param) {
	// return $param;
	$username = $param['username'];
	$password = $param['password'];
	if (strlen($username) < 6|| strlen($password)<6) {
		responseError('用户名或密码最少需要6位');
	}

	$link = connectDB();

	if ($link) {
		$result = addUserIntoDB($link,$username,$password);
		$err_message = mysqli_error($link);
		closeDB($link);

		if ($result) {
			responseSuccess('Register Success!');
		} else {
			responseError($err_message);
		}
	} else {
		responseError('connectDB error');
	}

}

function responseError($message) {
	$response = [
		'state' => 0,
		'message' => $message,
	];
	http_response_code(200);
	header('Content-Type: application/json');
	print json_encode($response);
	die;
}

function responseSuccess($message) {
	$response = [
		'state' => 1,
		'message' => $message,
	];
	http_response_code(200);
	header('Content-Type: application/json');
	print json_encode($response);
	die;
}



function connectDB() {	
	$user = 'root';
	$password = 'root';
	$db = 'user';
	$host = 'localhost';
	$port = 8889;

	$link = mysqli_connect(
	   "$host:$port", 
	   $user, 
 	   $password
	);

	if (mysqli_connect_errno()) {
    	return;
	}

	$db_selected = mysqli_select_db(
    	$link,
    	$db
	);

	if ($db_selected) {
		return $link;
	}
}

function closeDB($link) {
	mysqli_close($link);
}

function addUserIntoDB($link,$username,$password) {
	return mysqli_query($link,"INSERT INTO user (username, password) VALUES ('$username', '$password')");
}

function isExsiteFromDB($link,$username,$password) {
	$result = mysqli_query($link,"select * from user where username = '$username' and password = '$password'");
	while ($row = mysqli_fetch_array($result)) {
		return true;
	}
}





















?>