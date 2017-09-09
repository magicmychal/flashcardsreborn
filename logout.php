<?php session_start();
$url =  'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php'; ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Log out</title>
</head>
<?php
	//log out
	//unsetting all variables in a session, creating empty array
	$_SESSION = array();
	
	if (ini_get('session.use_cookies')){
		$params = session_get_cookie_params();
		setcookie(
			session_name(), '', time() - 4200,
			$params['path'], $params['domain'],
			$params['secure'], $params['httponly']
			);
		header('HTTP/1.1 303 See other');
		header('LOCATION:'.$url);	
	}
	else{
		echo 'It looks like you are already logged out';
	}
	session_destroy();
?>
<body>
	
</body>
</html>