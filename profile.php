<?php session_start();

$url =  'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
if (!isset($_SESSION['userid'])){
    header('HTTP/1.1 303 See other');
    header('LOCATION:'.$url);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Profile</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css" />
<link rel="stylesheet" href="main.css"/>
<link rel="stylesheet" href="less/material-modal.css"/>
</head>

<body>
<?php require_once('menu.php'); ?>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--6-col mdl-cell--3-offset">
		<div class="demo-card-wide mdl-card mdl-shadow--2dp">
		  <div class="mdl-card__title" style="background: url('<?=$_SESSION['avatar']?>') center / cover">
			<h2 class="mdl-card__title-text">Welcome, <?=$_SESSION['person']?></h2>
		  </div>
		  <div class="mdl-card__supporting-text">
			Here you can manage your account.<br>
			Youre mail is bla bla<br>
			<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
			  Change profile 
			</a>	
		  </div>
		  <div class="mdl-card__actions mdl-card--border">
			<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
			  Get Started
			</a>
			<a href="" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored modal__trigger" data-modal="#modal">
        	  Set a new profile picture!
     		</a>

		  </div>
		  <div class="mdl-card__menu">
			<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
			  <a href="" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored modal__trigger" data-modal="#modal">
			  	<i class="material-icons">edit</i>
			  </a>
			</button>
		  </div>
		</div>
	</div>
</div>
 <div class="content">  
      <div id="modal" class="modal modal__bg">
        <div class="modal__dialog">
          <div class="modal__content">
            <div class="modal__header">
              <div class="modal__title">
                <h2 class="modal__title-text">Modal</h2>
              </div>

              <span class="mdl-button mdl-button--icon mdl-js-button  material-icons  modal__close"></span>
            </div>

			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            	<div class="modal__text">
              		<p><input type="file" name="fileToUpload"></p>
			    </div>
				<div class="modal__footer">
				  <input type="submit" name="upload" value="Upload" class="mdl-button mdl-button--colored mdl-js-button">
				</div>
         	</form>
          </div>
        </div>
      </div>
    </div>
<?php require_once('php/profilepicupload.php'); ?>
<?php require_once('footer.php'); ?>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="js/material-modal.js"></script>
</body>
</html>
