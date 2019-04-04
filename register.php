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
        $registerResult = registerUser($username, $password);
        if ($registerResult !== '')
          $errors[] = $registerResult;
        if (count($errors) == 0) {
            loginUser($username, $password);
        }
    }
}
?>
<!DOCTYPE html>
<html>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'menu.php'; ?>



    <div class='wrapper'>
      <h2>Register an Account</h2>
      <form action='register.php' method='post'>
        <?
            if (count($errors) > 0) {
                ?>
                <ul class='errors'>
                <?
                foreach ($errors as $error) {
                    ?>
                  <li class='text-danger'><?=$error ?></li>
                <?
                }
                ?>
                </ul>
              <?
            } else {
              if(isset($_POST['username'])){
                header("Location: edit-profile.php?username=".$_POST['username']."&success=true");
                die();
              }
            }
        ?>

        <div class='form-group'>
          <label for='username'>Username:</label>
          <input class="form" type='text' id='username' name='username'>
        </div>

        <div class='form-group'>
          <label for='password'>Password:</label>
          <input class='form' type='password'  id='password' name='password'>
        </div>

        <input type='submit' value="Register">
        Already have an account? <a href='login.php'>Login here.</a>

      </form>


    </div>
  </body>
</html>
