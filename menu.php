<!-- Always shows a header, even in smaller screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title">Flashcards reborn </span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation mdl-layout--large-screen-only">
      <a class="mdl-navigation__link" href="index.php">Home</a>
      <?php
		if (isset($_SESSION['userid'])){
			?>
      <a class="mdl-navigation__link" href="profile.php">Profile</a>
      <?php } ?>
      <?php
		if (isset($_SESSION['userid'])){
	  ?>
      <a class="mdl-navigation__link" href="logout.php">Logout</a>
      <?php } ?>
      </nav>
    </div>
  </header>
 <!-- <div class="mdl-layout__drawer">
    <span class="mdl-layout-title">Flashcards reborn</span>
    <nav class="mdl-navigation">
      <a class="mdl-navigation__link" href="index.php">Home</a>
      <a class="mdl-navigation__link" href="">Profile</a>
      <a class="mdl-navigation__link" href="">Logout</a>
      <a class="mdl-navigation__link" href="">Contact</a>
    </nav>
  </div> -->
  <main class="mdl-layout__content">
    <div class="page-content">
    	<!--content -->
<?php require_once('db_con.php');?>