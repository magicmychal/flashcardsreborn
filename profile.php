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
<?php require_once('menu.php');
	$sqlUser='SELECT ID, username, mail, imig_url FROM user WHERE ID=?';
	$stmt = $con->prepare($sqlUser); //let's prepare to execute our sql, it's gonna be stored in $stmt
	$stmt->bind_param('i', $_SESSION['userid']);
	$stmt->execute();
	$stmt->bind_result($userID, $username, $mail, $imig_url);
	while($stmt->fetch()){}
function changes($con, $mail){	
	if (!empty(filter_input(INPUT_POST, 'submitChanges'))) {
			$newUsername = htmlspecialchars(filter_input(INPUT_POST, 'name'))
				or die('incorrect username');
			$newMail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL)
				or die('incorrect mail');	
		
			//checking if the user exist in the database
			$sqlcheck = 'SELECT mail FROM user WHERE mail=?';
			$stmtcheck = $con->prepare($sqlcheck);
			$stmtcheck->bind_param('s', $newMail);
			$stmtcheck->execute();
			$stmtcheck->bind_result($mailcheck);
			while ($stmtcheck->fetch()) {
			}
			if ($newMail == $mailcheck && $newMail!==$mail) {
				echo 'This mail is already in our database.';
			} else {
				$sqlUser='UPDATE user SET username=?, mail=? WHERE ID=?';
				$stmt = $con->prepare($sqlUser); //let's prepare to execute our sql, it's gonna be stored in $stmt
				$stmt->bind_param('ssi',$newUsername, $newMail ,$_SESSION['userid']);
				$stmt->execute();
				$_SESSION['person'] = $newUsername;
			}
	}
	if (!empty(filter_input(INPUT_POST, 'accountDelete'))) {
			$url =  'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/logout.php';
			$sqlUser='DELETE FROM user WHERE ID=?';
			$stmt = $con->prepare($sqlUser); //let's prepare to execute our sql, it's gonna be stored in $stmt
			$stmt->bind_param('i', $_SESSION['userid']);
			$stmt->execute();
			header('HTTP/1.1 303 See other');
            header('LOCATION:'.$url);
	}
}
?>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--6-col mdl-cell--3-offset">
		<div class="demo-card-wide mdl-card mdl-shadow--2dp">
		  <div class="mdl-card__title" style="background: url('<?=$_SESSION['avatar']?>') center / cover">
			<h2 class="mdl-card__title-text">Welcome, <?=$_SESSION['person']?></h2>
		  </div>
		  <div class="mdl-card__supporting-text">
			Here you can manage your account.<br>
			<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" name="name" value="<?=$username;?>">
					<label class="mdl-textfield__label">Name</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="email" name="mail" value="<?=$mail;?>">
					<label class="mdl-textfield__label">Mail</label>
				</div>
				<input type="submit" name="submitChanges" value="Submit changes" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
			</form>
			<?php changes($con, $mail); ?>
		  </div>
		  <div class="mdl-card__actions mdl-card--border">
			<a href="" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored modal__trigger" data-modal="#modal">
        	  Set a new profile picture!
     		</a>
     		<a href="" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored modal__trigger" data-modal="#deleteAsk">
        	  Delete a profile
     		</a>
			<a href="dash.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
              Go back to the dashboard
            </a>
            
		  </div>
		  <div class="mdl-card__menu">
		  
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
                <h2 class="modal__title-text">Upload a file</h2>
              </div>
              <span class="mdl-button mdl-button--icon mdl-js-button  material-icons  modal__close"></span>
            </div>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            	<div class="modal__text">
             		<p>Choose a image file, such as png, jpg or gif.</p>
              		<p><input type="file" name="fileToUpload"></p>
			    </div>
				<div class="modal__footer">
				  <input type="submit" name="upload" value="Upload" class="mdl-button mdl-button--colored mdl-js-button">
				</div>
         	</form>
          </div>
        </div>
      </div>
      <div id="deleteAsk" class="modal modal__bg">
        <div class="modal__dialog">
          <div class="modal__content">
            <div class="modal__header">
              <div class="modal__title">
                <h2 class="modal__title-text">Are you sure?</h2>
              </div>
              <span class="mdl-button mdl-button--icon mdl-js-button  material-icons  modal__close"></span>
            </div>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            	<div class="modal__text">
              		Are you sure you want to delete your account? Once deleted it&#39;s gone forever...
			    </div>
				<div class="modal__footer">
				  <input type="submit" name="accountDelete" value="Yes, delete my account and end the session" class="mdl-button mdl-button--colored mdl-js-button">
				  <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored modal__close">
				  	NO! Take me back 
				  </button>
				</div>
         	</form>
          </div>
        </div>
      </div>
      
 </div>
<?php require_once('php/profilepicupload.php'); ?>
<?php require_once('footer.php'); ?>
</body>
</html>
