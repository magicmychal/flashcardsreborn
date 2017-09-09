<?php session_start(); 

$url =  'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/dash.php';
if (!isset($_SESSION['userid'])){
    header('HTTP/1.1 303 See other');
    header('LOCATION:'.$url);
}

$flashid = filter_input(INPUT_GET, 'flashid', FILTER_VALIDATE_INT);
//$catname = htmlspecialchars(filter_input(INPUT_GET, 'catname'));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Flashcards</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css" />
<link rel="stylesheet" href="main.css"/>
<link rel="stylesheet" href="less/getmdl-select.css"/>
</head>

<body>
<?php require_once('menu.php'); ?>
<?php echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>'; ?>
	

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
                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Get Started
                </a>
                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Edit your profile
                </a>
                
            </div>
            <div class="mdl-card__menu">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">share</i>
                </button>
            </div>
        </div>
    </div>
    <div class="mdl-cell mdl-cell--6-col">
        <div class="demo-card-wide mdl-card mdl-shadow--2dp">
            <div class="mdl-card__actions mdl-card--border">
               <?php 
				    $sqlFlashDisplay = 'SELECT f.flashcardID, f.word, f.translation, c.cat_name
										FROM flashcards f, category c
										WHERE f.category_catID=c.catID
										AND f.flashcardID=?';
					$stmt = $con->prepare($sqlFlashDisplay); //let's prepare to execute our sql, it's gonna be stored in $stmt
					$stmt->bind_param('i', $flashid);
					$stmt->execute();
					$stmt->bind_result($flashcardID, $word, $translation, $catName);
					while($stmt->fetch()){
						echo ' <div class="category-card mdl-card mdl-shadow--2dp">
								  <div class="mdl-card__title mdl-card--expand">
									<h2 class="mdl-card__title-text">'.$word.'</h2>
								  </div>
								  <div class="mdl-card__title mdl-card--border">
									<h2 class="mdl-card__title-text">'.$translation.'</h2>
									
									
								  </div>
								  <div class="mdl-card__actions mdl-card--border">
									<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
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
			 <div class="category-card mdl-card mdl-shadow--2dp">
			  <form action="" method="post">
				  <div class="mdl-card__title mdl-card--expand">
					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" name="newWord" placeholder="$word">
						<label class="mdl-textfield__label" for="sample3">Word</label>
					  </div>
				  </div>
				  <div class="mdl-card__title mdl-card--expand">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" name="newTranslation" placeholder="$translation">
						<label class="mdl-textfield__label" for="sample3">Translation</label>
					  </div>
				  </div>
				  <div class="mdl-card__title mdl-card--border">
				  	Category 
				  	<select>
				  		<option value="1">Cat1</option>
				  	</select>
				  	
				  </div>
				  <div class="mdl-card__actions mdl-card--border">
					<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
					  Edit
					</a>
				  </div>
				</div>
			</div>            
            </div>
            <div class="mdl-card__menu">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">share</i>
                </button>
            </div>
        </div>
    </div>
</div>



<?php require_once('footer.php'); ?>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="js/getmdl-select.js"></script>
</body>
</html>
