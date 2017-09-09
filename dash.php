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
<title>Dashboard</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css" />
<link rel="stylesheet" href="main.css"/>
</head>

<body>
<?php require_once('menu.php'); ?>
<?php echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>'; ?>
<?php 
function countCategories($user){
	$sqlCount='SELECT COUNT(catID) AS categories FROM category WHERE user_ID=?';
	$stmtCount=$con->prepare($sqlCount);
	$stmtCount=bind_param('i', 10);
	$stmtCount=execute();
	$stmtCount=bind_result($catNo);
	while($sttCount->fetch()){
		echo $catNo;
	}
	$stmtCount->close();
}
function countFlashcards($user){
	$sqlCount='SELECT COUNT(flashcards.flashcardID) AS flashcardsNo FROM flashcards, category WHERE flashcards.category_catID=category.catID AND category.user_ID=?';
	$stmtCount=$con->prepare($sqlCount);
	$stmtCount=bind_param('i', $user);
	$stmtCount=execute();
	$stmtCount=bind_result($flashNo);
	while($sttCount->fetch()){
		echo $flashNo;
	}
	$stmtCount->close();
}

	
?>

<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--4-col">
        <div class="demo-card-wide mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title" style="background: url('<?=$_SESSION['avatar']?>') center / cover">
                <h2 class="mdl-card__title-text">Welcome, <?=$_SESSION['person']?></h2>
            </div>
            <div class="mdl-card__supporting-text">
                <p>You have <?php countCategories(10); ?> categories<br>
				   and xxxx flashcards in total</p>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Get Started
                </a>
                <a href="profile.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
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
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text">Categories</h2>
            </div>
            <div class="mdl-card__supporting-text">
             	<div class="mdl-grid">
				  <div class="mdl-cell mdl-cell---9-col">4</div>
				  <div class="mdl-cell mdl-cell--3-col">4</div>
				</div>
              	<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--9">
						Here are all categories you have. If you miss something just add a new one!
					</div>
					<div class="mdl-cell mdl-cell--3">
						<a href="addcat.php" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
						  <i class="material-icons">add</i>
						</a>
					</div>
				</div>
            </div>
            <div class="mdl-card__actions mdl-card--border">
               <?php 
				    $sqlCatDisplay = 'SELECT catID, cat_name, language_langID, language_langID2 FROM category WHERE user_ID=?';
					$stmt = $con->prepare($sqlCatDisplay); //let's prepare to execute our sql, it's gonna be stored in $stmt
					$stmt->bind_param('s', $_SESSION['userid']);
					$stmt->execute();
					$stmt->bind_result($catID, $catName, $inputLang, $outputLang);
					while($stmt->fetch()){
						echo ' <div class="category-card mdl-card mdl-shadow--2dp">
								  <div class="mdl-card__title mdl-card--expand">
									<h2 class="mdl-card__title-text">'.$catName.'</h2>
									
								  </div>
								  <div class="mdl-card__supporting-text">'
									.$inputLang.' '.$outputLang.'
								  </div>
								  <div class="mdl-card__actions mdl-card--border">
									<a href="flashcards.php?catid='.$catID.'&catname='.$catName.'"class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
									  See flashcards inside
									</a>
									<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
									  Edit
									</a>
									
								  </div>
								</div>';
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
