<?php
session_start();
include_once('classes/profiles.php');
$profiles = new Profiles();
?>
<nav class="header">
  <div class="wrapper">

    <a class="home-btn" href='./'>Home</a>

    <img src="https://s3-us-west-2.amazonaws.com/bloghub-profilepics/logo.PNG" alt="logo">

  <? if (isset($_SESSION['username'])) { ?>

      <a class='lgn-btn' href='logout.php'>Logout</a>
      <a class='lgn-btn' href='profile.php?username=<? echo $_SESSION['username'] ?>'><img  src='https://s3-us-west-2.amazonaws.com/bloghub-bucket/<? echo $profiles->getImage($_SESSION['username']); ?>' > </a>

    <? } else { ?>

      <a class="lgn-btn" href='login.php'>Login</a>
      <a class="lgn-btn" href='register.php'>Register</a>

    <? } ?>
  </div>
  <div style="clear:both;">
</nav>
