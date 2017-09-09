<?php 
session_start();

$url =  'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/dash.php';
if (isset($_SESSION['userid'])){
    header('HTTP/1.1 303 See other');
    header('LOCATION:'.$url);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Flashcards reborn</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css" />
<link rel="stylesheet" href="main.css"/>
</head>

<body>
<?php require_once('menu.php'); ?>
<?php require_once('login.php'); ?>
<div class="mdl-grid">
<div class="mdl-cell mdl-cell--12-col mdl-cell--5-offset">
	<div class="mdl-card mdl-shadow--4dp">
	  <div class="mdl-card__title">
		<h2 class="mdl-card__title-text">Login</h2>
	  </div>
	  <div class="mdl-card__supporting-text">
		If you don&#39;t have an account, you can eaisly make one. 
	  </div>
	  <div class="mdl-card__supporting-text">
			<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
			  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="email" pattern="[^@\s]+@[^@\s]+" id="mail" name='mailLogin' required>
				<label class="mdl-textfield__label" for="mail">your&#64;mail.com</label>
				<span class="mdl-textfield__error">Write your mail</span>
			  </div>
			  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="password" id="password" name="passwordLogin">
				<label class="mdl-textfield__label" for="sample3">Password</label>
			  </div>
			  <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" value="go login!" name="loginSubmit">
			  <i>
			  	<?php if(!empty(filter_input(INPUT_POST, 'loginSubmit'))){
						login($con, $url);
					}
				?>
			  </i>
			</form>
	  </div>
	</div>
	<div class="mdl-card mdl-shadow--4dp">
			<div class="mdl-card__title">
			<h2 class="mdl-card__title-text">Sign up to	&nbsp; <i> Flashcards reborn</i></h2>
	  </div>
	  <div class="mdl-card__supporting-text">
			We do NOT send spam
	  </div>
	  <div class="mdl-card__supporting-text">
			<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
			  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="nameRegister" name="nameRegister">
				<label class="mdl-textfield__label" for="sample3">Name</label>
			  </div>
			  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="email" pattern="[^@\s]+@[^@\s]+" id="mail" name='mailRegister' required>
				<label class="mdl-textfield__label" for="mail">your&#64;mail.com</label>
				<span class="mdl-textfield__error">Write your mail</span>
			  </div>
			  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="password" id="password" name="passwordRegister">
				<label class="mdl-textfield__label" for="sample3">Password</label>
			  </div>
			  <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" value="go sign up	!" name="registerSubmit">
			  <i>
			  	<?php
				 	if (!empty(filter_input(INPUT_POST, 'registerSubmit'))) { register($con); }
				 ?>
			  </i>
			</form>
	  </div>
	  <div class="mdl-card__actions mdl-card--border">
		<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
		</a>
	  </div>
	</div>
	
</div>
</div>


<!-- dont mess up from here -->
<?php require_once('footer.php'); ?>	
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>