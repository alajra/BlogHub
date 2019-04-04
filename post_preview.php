<?php
function echo_post_preview($id, $title, $owner, $content, $img)
{
    ?>

    <div class='post-block'>
      <a href='post.php?id=<? echo $id; ?>'>
        <div class="img-resizer">
          <img src="https://s3-us-west-2.amazonaws.com/bloghub-bucket/<?=$img?>">
        </div>
        <h1><?=$title ?></h1>
      </a>
      <p>By <a href="profile.php?username=<?=$owner?>"><?=$owner?></a></p>

    </div>

  <?php
}
?>
