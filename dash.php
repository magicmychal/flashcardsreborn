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
<link rel="stylesheet" href="less/material-modal.css"/>
<link rel="stylesheet" href="main.css"/>
</head>

<body>
<?php require_once('menu.php'); 
function countCategories($con){
		$sqlCount='SELECT COUNT(catID) AS categories FROM category WHERE user_ID=?';
		$stmt = $con->prepare($sqlCount); //let's prepare to execute our sql, it's gonna be stored in $stmt
		$stmt->bind_param('s', $_SESSION['userid']);
		$stmt->execute();
		$stmt->bind_result($catID);
		while($stmt->fetch()){
			echo '<b>'.$catID.'</b>';
		}
}
function countFlashcards($con){
	$sqlCount='SELECT COUNT(flashcards.flashcardID) AS flashcardsNo FROM flashcards, category WHERE flashcards.category_catID=category.catID AND category.user_ID=?';
			$stmt = $con->prepare($sqlCount); //let's prepare to execute our sql, it's gonna be stored in $stmt
			$stmt->bind_param('s', $_SESSION['userid']);
			$stmt->execute();
			$stmt->bind_result($catID);
			while($stmt->fetch()){
				echo '<b>'.$catID.'</b>';
			}
}

	
?>

<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--4-col">
        <div class="demo-card-wide mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title" style="background: url('<?=$_SESSION['avatar']?>') center / cover">
                <h2 class="mdl-card__title-text">Welcome, <?=$_SESSION['person']?></h2>
            </div>
            <div class="mdl-card__supporting-text">
                <p>You have <?php countCategories($con);?> categories<br>
				   and <?php countFlashcards($con); ?> flashcards in total</p>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect modal__trigger" data-modal="#getStarted">
                    Get Started
                </a>
                <a href="profile.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Edit your profile
                </a>
                
            </div>
            <div class="mdl-card__menu">
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
				  <div class="mdl-cell mdl-cell--10-col">Here are all categories you have. If you miss something just add a new one!</div>
				  <div class="mdl-cell mdl-cell--2-col">
				  	<a href="addcat.php" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored add-btn">
						  <i class="material-icons">add</i>
					</a>
				  </div>
				</div>
            </div>
            <div class="mdl-card__actions mdl-card--border">
               <?php 
				    $sqlCatDisplay = 'SELECT c.catID, c.cat_name, l.lang_name
									FROM category c, language l
									WHERE c.language_langID2=l.langID
									AND user_ID=?';
					$stmt = $con->prepare($sqlCatDisplay); //let's prepare to execute our sql, it's gonna be stored in $stmt
					$stmt->bind_param('i', $_SESSION['userid']);
					$stmt->execute();
					$stmt->bind_result($catID, $catName, $outputLang);
					while($stmt->fetch()){
						echo ' <div class="category-card mdl-card mdl-shadow--2dp">
								  <div class="mdl-card__title mdl-card--expand">
									<h2 class="mdl-card__title-text">'.$catName.'</h2>
								  </div>
								  <div class="mdl-card__supporting-text">
									Output language <i>'.$outputLang.'</i>
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
 <div class="content">  
      <div id="getStarted" class="modal modal__bg">
        <div class="modal__dialog">
          <div class="modal__content">
            <div class="modal__header">
              <div class="modal__title">
                <h2 class="modal__title-text">Get started with Flashcards reborn</h2>
              </div>
              <span class="mdl-button mdl-button--icon mdl-js-button  material-icons  modal__close"></span>
            </div>
            	<div class="modal__text">
              		Flashcards reborn is a part of a Fiszki Android app and it takes a next step in learning new vocab. Soon you&#39;ll be able to experience a new way of managing your flashcards via web. Please notice that this is not finished product, therefore it still doesn&#39;t support our native app, but we&#39;re working on it. <br>
					If you find aby bugs or you want to share an idea, please open a new issue on our <a href="https://github.com/magicmychal/flashcardsreborn/issues" target="_blank">GitHub repository.</a>

			    </div>
				<div class="modal__footer">
				  <a href="" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored modal__close">
				  	Got it! Let&#39;s get started!
				  </a>
				</div>
          </div>
        </div>
      </div>
      
 </div>

<?php require_once('footer.php'); ?>
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>
