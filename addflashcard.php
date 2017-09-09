<?php session_start();
$url =  'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
if (!isset($_SESSION['userid'])){
    header('HTTP/1.1 303 See other');
    header('LOCATION:'.$url);
}

$catid = filter_input(INPUT_GET, 'catid', FILTER_VALIDATE_INT);
$catname = htmlspecialchars(filter_input(INPUT_GET, 'catname'));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add flashcard</title>
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
			<h2 class="mdl-card__title-text">Add new flashcard in <?=$catname;?></h2>
		  </div>
		  <form action="#" method="post">
			<div class="mdl-card__supporting-text">
				<div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" name="newFlashcardName">
					<label class="mdl-textfield__label" for="sample3">Word</label>
			    </div>
			    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" name="newFlashcardNameTranslation">
					<label class="mdl-textfield__label" for="sample3">Translation</label>
			    </div>

		  	</div>
			  <div class="mdl-card__actions mdl-card--border">
				<input type="submit" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" name="submitNewCat" value="Add new flashcard">
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
        $newFlashcardName = htmlspecialchars(filter_input(INPUT_POST, 'newFlashcardName'))
        	or die('Missing name');
	    $newFlashcardNameTranslation = htmlspecialchars(filter_input(INPUT_POST, 'newFlashcardNameTranslation'))
        	or die('Missing translation');
		$user = $_SESSION['userid']
			or die('User doenst exist or is log out');


        //checking if the flashard exist in the database
        $sqlcheck = 'SELECT word, translation, category_catID FROM flashcards WHERE word=? OR translation=? AND category_catID=?';
        $stmtcheck = $con->prepare($sqlcheck);
        $stmtcheck->bind_param('ssi', $newFlashcardName, $newFlashcardNameTranslation, $catid);
        $stmtcheck->execute();
        $stmtcheck->bind_result($nameCheck, $translationCheck, $catCheck);
        while ($stmtcheck->fetch()) {
        }
        if ($newFlashcardName == $catCheck || $newFlashcardNameTranslation == $translationCheck	&& $catid == $catCheck) {
            echo "it is already in our database";
        } else {

            //now when everything works fine, it's time to put those infromation to the database
            $sqlAddNewCat ='INSERT INTO flashcards (word, translation, category_catID) VALUES (?,?,?)'; 
            $stmt = $con->prepare($sqlAddNewCat);
            $stmt->bind_param('ssi', $newFlashcardName, $newFlashcardNameTranslation, $catid);
            $stmt->execute();

            echo 'Added ' . $stmt->affected_rows . ' flashcard';

        }

}


?>
<?php require_once('footer.php'); ?>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>
