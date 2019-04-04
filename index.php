<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'menu.php'; ?>


    <div class="wrapper">

      <div class="main-title">
        <h3 class="main-heading">Main Feed</h3>
        <p class="main-decrib">Recent posts created on BlogHub</p>
        <a class="main-add-post-btn" href="add-post.php">Add post</a>
      </div>



      <div class='posts-block'>
        <?
          include 'classes/posts.php';
          include 'post_preview.php';

          $postsObject = new Posts();
          $posts = $postsObject->getAllPosts();
          foreach ($posts as $post) {
            echo_post_preview($post['id'], $post['title'], $post['username'], $post['content'], $post['img_url']);
          }
        ?>

      </div>


    </div>

  </body>
</html>
