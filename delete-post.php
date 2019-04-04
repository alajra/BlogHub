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

        $s3->deletePic($profile['img']['S']);

        $posts->removePost($postID);
        echo "Succefully deleted post <br>";
        echo "<a href='./'>Back to Home</a>";

        die();
      }

    ?>
    <div class="wrapper">
      <h1>Delete post</h1>
      <p>Are you sure you want to delete the post?</p>


      <form action="delete-post.php?id=<? echo $postID; ?>" method="post" enctype="multipart/form-data">
        <input type="submit" value="Delete post" name="submit">
        <br>
      </form>

      <a href='./'>Back to Home</a>
    </div>  

  </body>
</html>
