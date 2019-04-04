<?

  session_start();

  if( !(isset($_SESSION['username'])) ){
    header("Location: login.php");
    die();
  }

  include ("classes/s3-service.php");
  include ("classes/posts.php");

?>

<!DOCTYPE html>
<html>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'menu.php'; ?>
    
    <div class="wrapper">

    <?php
      $posts = new Posts();

      if( isset($_GET['id']) ){
        //get the post informarion
        $postID = $_GET['id'];
        $currentPost = $posts->getPost($postID);

        //if post not found send to not found page
        if(count($currentPost) == 1){
          header("Location: 404notfound.php");
          die();
        }

        //if found check if this is the owner
        if( $_SESSION['username'] != $currentPost['username'] ){
          //access not permitted
           echo "<h1>Access denied</h1>";
           die();
        }

      } else {
        //send to not found page
        header("Location: 404notfound.php");
        die();
      }

      $s3 = new S3();

      if(isset($_POST['submit'])){

        $urlToImg = $currentPost['img_url'];

        if($_FILES["fileToUpload"]["tmp_name"]  != ""){
          $s3->deletePic($profile['img']['S']);
          $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
          $urlToImg = $s3->uploadPic($_FILES["fileToUpload"]["tmp_name"], $imageFileType, $username);
        }

        $posts->editPost($postID, $_POST['postTitle'], $urlToImg, $_POST['content']);
        echo " succefully edited post";

        $postID = $_GET['id'];
        $currentPost = $posts->getPost($postID);

      }

    ?>

      <h1>Edit post</h1>
      <p>Complete the following data to Edit post:</p>
      <br>

      <form action="edit-post.php?id=<? echo $postID; ?>" method="post" enctype="multipart/form-data">

        <label for="postTitle">Enter Post title:</label>
        <input class="form" class="form" type="text" name="postTitle" id="postTitle" value="<? echo $currentPost['title']; ?>">

        <label for="content">Enter Post text:</label>
        <textarea name="content" id="content" rows="4" cols="50"><? echo $currentPost['content']; ?></textarea>

        <img width="100" src="https://s3-us-west-2.amazonaws.com/bloghub-bucket/<? echo $currentPost['img_url']; ?>" alt>
        <br>

        <label for="fileToUpload">Select post image to upload:</label>
        <input class="form" type="file" name="fileToUpload" accept="image/*" id="fileToUpload">

        <input type="submit" value="Edit post" name="submit">


      </form>
    </div>


  </body>
</html>
