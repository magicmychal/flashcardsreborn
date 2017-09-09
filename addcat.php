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
<title>Add category</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css" />
<link rel="stylesheet" href="main.css"/>
</head>

<body>
<?php require_once('menu.php'); ?>

<!-- add new category modal -->
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--6-col mdl-cell--3-offset">
	  	<div class="demo-card-wide mdl-card mdl-shadow--2dp">
		  <div class="mdl-card__title">
			<h2 class="mdl-card__title-text">Add new Category</h2>
		  </div>
		  <form action="#" method="post">
			<div class="mdl-card__supporting-text">
				<div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" name="newCatName">
					<label class="mdl-textfield__label" for="sample3">Category name</label>
			    </div>
			     <div class="mdl-cell mdl-cell--12 mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
					<label>Input language</label>
					<select name="inputLang">
						<?php $sqlSelect = 'SELECT langID,lang_name FROM language';
										$stmt = $con->prepare($sqlSelect); //let's prepare to execute our sql, it's gonna be stored in $stmt
										//$stmt->bind_param('s', $mail);
										$stmt->execute();
										$stmt->bind_result($langID, $langName);
										while($stmt->fetch()){
											echo "<option value='".$langID."'>".$langName."</option>";
										}
						?>
					</select>
				</div>
				<div class="mdl-cell mdl-cell--12 mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
					<label>Output language</label>
					<select name="outputLang">
						<?php $sqlSelect = 'SELECT langID,lang_name FROM language';
										$stmt = $con->prepare($sqlSelect); //let's prepare to execute our sql, it's gonna be stored in $stmt
										//$stmt->bind_param('s', $mail);
										$stmt->execute();
										$stmt->bind_result($langID, $langName);
										while($stmt->fetch()){
											echo "<option value='".$langID."'>".$langName."</option>";
										}
						?>
					</select>
				</div>
		  	</div>
			  <div class="mdl-card__actions mdl-card--border">
				<input type="submit" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" name="submitNewCat" value="Add new category">
			  </div>
		  </form>
		  <div class="mdl-card__menu">
			<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
			  <i class="material-icons">share</i>
			</button>
		  </div>
		</div>
	  </div>
	</div>

<?php 
if (!empty(filter_input(INPUT_POST, 'submitNewCat'))) {
       //read all inputs and validate them
        $newCatName = filter_input(INPUT_POST, 'newCatName')
        	or die('Missing name');
        $inputLang = filter_input(INPUT_POST, 'inputLang')
        	or die('Missing lang');
		$outputLang = filter_input(INPUT_POST, 'outputLang')
        	or die('Missing second lang');
		$user = $_SESSION['userid']
			or die('User doenst exist or is log out');


        //checking if the category exist in the database
        $sqlcheck = 'SELECT `cat_name` FROM `category` WHERE `cat_name`=?';
        $stmtcheck = $con->prepare($sqlcheck);
        $stmtcheck->bind_param('s', $newCatName);
        $stmtcheck->execute();
        $stmtcheck->bind_result($catCheck);
        while ($stmtcheck->fetch()) {
        }
        if ($newCatName == $catCheck) {
            echo "it is already in our database";
        } else {

            //now when everything works fine, it's time to put those infromation to the database
            $sqlAddNewCat ='INSERT INTO `category`(cat_name, user_ID, language_langID, language_langID2) VALUES (?,?,?,?)'; 
            $stmt = $con->prepare($sqlAddNewCat);
            $stmt->bind_param('siii', $newCatName, $user, $inputLang, $outputLang);
            $stmt->execute();

            echo 'Added ' . $stmt->affected_rows . ' category';

        }

}


?>
<?php require_once('footer.php'); ?>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>
