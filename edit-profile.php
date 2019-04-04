
<?
  session_start();

  if( !(isset($_SESSION['username'])) ){
    header("Location: login.php");
    die();
  }


  include ("classes/s3-service.php");
  include ("classes/profiles.php");
 ?>

<!DOCTYPE html>
<html>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'menu.php'; ?>
    <div class="wrapper">
    <?php
      $s3 = new S3();
      $profiles = new profiles();


      if(isset($_GET['username'])){
        $username = $_GET['username'];
        $profile = $profiles->getProfile($username);
        //if username was not found send to 404 page
        if($profile == NULL){
          header("Location: 404notfound.php");
          die();
        }

        if($_GET['username'] != $_SESSION['username']){
          echo "<h1> Access denied </h1>\n";
          die();
        }

      } else {
        header("Location: 404notfound.php");
        die();
      }





      if(isset($_POST['submit'])){

        $urlToImg = $profile['img']['S'];

        if($_POST['name'] == "" || $_POST['bio'] == ""){

          echo "Bio and name can't be left empty\n";

        } else {
          
          if($_FILES["fileToUpload"]["tmp_name"]  != ""){

            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
              $s3->deletePic($profile['img']['S']);
              $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
              $urlToImg = $s3->uploadPic($_FILES["fileToUpload"]["tmp_name"], $imageFileType, $username);
              $profiles->editProfile($_POST['name'], $_GET['username'], $urlToImg, $_POST['bio']);
              echo " succefully edited";
            } else {
              echo "Invalid file type: you can upload pictures only";
            }

          } else {
            $urlToImg = $profile['img']['S'];
            $profiles->editProfile($_POST['name'], $_GET['username'], $urlToImg, $_POST['bio']);
            echo " succefully edited";
          }


        }

        $username = $_GET['username'];
        $profile = $profiles->getProfile($username);

      }


    ?>


      <h1>Edit profile</h1>
      <p>Click to edit the following: </p>


      <form action="edit-profile.php?username=<? echo $_GET['username']; ?>" method="post" enctype="multipart/form-data">

        <div class="img-resizer-profile">
          <img src="https://s3-us-west-2.amazonaws.com/bloghub-bucket/<?=$profile['img']['S']?>">
        </div>

        <div class="profile-img-upload">
          <label>Select profile image to upload:</label>
          <input class="form" type="file" name="fileToUpload" id="fileToUpload">
        </div>

        <div style="clear:both;"></div>

        <label>Enter your profile name:</label>
        <input class="form" type="text" name="name" id="name" value="<?=$profile['profileName']['S']?>">

        <label>Enter your bio here</label>
        <textarea name="bio" id="bio" rows="4" cols="50"><?=$profile['bio']['S']?></textarea>


        <input type="submit" accept="image/*" value="Update Profile" name="submit">

      </form>

    </div>


  </body>
</html>
