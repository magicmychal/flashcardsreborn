<?php session_start(); 

$url =  'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/dash.php';
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
<title>Flashcards</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css" />
<link rel="stylesheet" href="main.css"/>
</head>

<body>
<?php require_once('menu.php'); ?>
	

<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--4-col">
        <div class="demo-card-wide mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text">Welcome</h2>
            </div>
            <div class="mdl-card__supporting-text">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Mauris sagittis pellentesque lacus eleifend lacinia...
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <button onclick="goBack()" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Go back
                </button>
                
            </div>
            <div class="mdl-card__menu">
            </div>
        </div>
    </div>
    <div class="mdl-cell mdl-cell--6-col">
        <div class="demo-card-wide mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text"><?=$catname;?> category</h2>
            </div>
            <div class="mdl-card__supporting-text">
              	<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--9">
						Add and manage your flashcards
					</div>
					<div class="mdl-cell mdl-cell--3">
						<a href="addflashcard.php?catid=<?=$catid;?>&catname=<?=$catname;?>" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
						  <i class="material-icons">add</i>
						</a>
					</div>
				</div>
            </div>
            <div class="mdl-card__actions mdl-card--border">
               <?php 
				    $sqlFlashDisplay = 'SELECT flashcardID, word, translation, picture FROM flashcards WHERE category_catID=?';
					$stmt = $con->prepare($sqlFlashDisplay); //let's prepare to execute our sql, it's gonna be stored in $stmt
					$stmt->bind_param('i', $catid);
					$stmt->execute();
					$stmt->bind_result($flashcardID, $word, $translation, $picture);
					while($stmt->fetch()){
						echo ' <div class="category-card mdl-card mdl-shadow--2dp">
								  <div class="mdl-card__title mdl-card--expand">
									<h2 class="mdl-card__title-text">'.$word.'</h2>
								  </div>
								  <div class="mdl-card__title mdl-card--border">
									<h2 class="mdl-card__title-text">'.$translation.'</h2>
									
									
								  </div>
								  <div class="mdl-card__actions mdl-card--border">
									<a href="editflashcard.php?flashid='.$flashcardID.'" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
									  Edit
									</a>
								  </div>
								</div>';
					}
				if(!empty(filter_input(INPUT_POST, 'submitDelete', FILTER_VALIDATE_INT))){
					$sqlDelete='DELETE FROM flashcards WHERE flashcardID = ?';
					$stmtDelete=$con->prepare($sqlDelete);
					$stmtDelete->bind_param('i', $flashcardID);
					$stmtDelete->execute();
					$stmtDelete->close(); 	
				}
				?>              
            </div>
            <div class="mdl-card__menu">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">share</i>
                </button>
            </div>
        </div>
    </div>
    <div class="mdl-cell mdl-cell--2-col">2</div>
</div>


<?php require_once('footer.php'); ?>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>
