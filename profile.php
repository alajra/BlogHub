<?php
include 'classes/profiles.php';
include 'classes/posts.php';
include 'post_preview.php';

session_start();
$profiles = new Profiles();
$posts = new Posts();

$username = $_GET['username'];
$profile = $profiles->getProfile($username);

if (!$profile) {
  header("Location: 404notfound.php");
  die();
}

?>
<!DOCTYPE html>
<html>
  <? include 'head.php'; ?>
  <body>
    <? include 'menu.php'; ?>

    <div class='wrapper'>

          <div class="profile-info">
                <div class="img-resizer-profile">
                  <img src="https://s3-us-west-2.amazonaws.com/bloghub-bucket/<?=$profile['img']['S']?>">
                </div>

                <div>
                  <h3><?=$profile['profileName']['S'] ?></h3>
                  <p><?=$profile['bio']['S'] ?></p>
                </div>

                <a class='edit-profile-btn' href='edit-profile.php?username=<?=$username?>'>Edit Profile</a>

            </div>

            <div style="clear:both;"></div>

            <div class="main-title">
              <h3 class="main-heading">Posts</h3>
              <p class="main-decrib">Recent posts <?=$profile['profileName']['S']?> created on BlogHub</p>
              <a class="main-add-post-btn" href="add-post.php">Add post</a>
            </div>

            <div class="posts-block">
              <?
              $userPosts = $posts->getUserPosts($username);
              foreach ($userPosts as $post) {
                echo_post_preview($post['id'], $post['title'], $post['username'], $post['content'],$post['img_url']);
              }
              ?>
            </div>

      </div>
    </div>

  </body>
</html>
