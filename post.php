<?php
include 'classes/posts.php';

session_start();
$posts = new Posts();

if(isset($_GET['id'])){
  $post = $posts->getPost($_GET['id']);
}else {
  }

?>
<!DOCTYPE html>
<html>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'menu.php'; ?>

    <div class='wrapper'>

      <div class="post-view">

        <div>
          <img style="max-width: 100%;" src="https://s3-us-west-2.amazonaws.com/bloghub-bucket/<?=$post['img_url']?>">
        </div>

        <div class="post-meta">
          <h2><?=$post['title']?></h2>
          <h4>By <a href="profile.php?username=<?=$post['username']?>"><?=$post['username']?></a></h4>
        </div>

        <div class="post-actions">
          <?
            if( isset($_SESSION['username']) ){
              if($_SESSION['username'] == $post['username']){
                ?>
                <a href="delete-post.php?id=<?=$_GET['id']?>">delete post</a>
                <a href="edit-post.php?id=<?=$_GET['id']?>">edit post</a>
                <?
              }
            }
          ?>
        </div>

        <div style="clear:both;"></div>

        <p class="post-content"><?=$post['content']?></p>

      </div>

    </div>

  </body>
</html>
