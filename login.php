<?php
session_start();
$errors = array();
if (isset($_POST['username']) || isset($_POST['password'])) {
    include 'classes/users.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === '') {
        $errors[] = 'Username cannot be empty.';
    }

    if ($password === '') {
        $errors[] = 'Password cannot be empty.';
    }

    if (count($errors) == 0) {
        $errors[] = loginUser($username, $password);
    }
}
?>
<!DOCTYPE html>
<html>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'menu.php'; ?>
    <div class='wrapper'>

      <h2>Login to your Account</h2>

      <form action='login.php' method='post'>

        <? if (count($errors) > 0) { ?>
            <ul class='error'>
              <?foreach ($errors as $error) { ?>
                <li class='text-danger'><?=$error ?></li>
              <? }?>
            </ul>
        <? } ?>


        <div class='form-group'>
          <label for='username'>Username:</label>
          <input class="form" type='text' id='username' name='username'>
        </div>

        <div class='form-group'>
          <label for='password'>Password:</label>
          <input class='form' type='password'  id='password' name='password'>
        </div>

        <input type='submit' value="Login" >
        New user? <a href='register.php'>Register here.</a>
      </form>






    </div>
  </body>
</html>
