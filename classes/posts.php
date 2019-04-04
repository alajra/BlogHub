<?php
set_include_path('../');
require 'vendor/autoload.php';

include 'getPDO.php';


class Posts
{
    public function getAllPosts()
    {
        try {
            $pdo = getPDO();

            // SELECT title, img_url, content, username
            // FROM posts
            // INNER JOIN users ON posts.owner_id = users.id
            // ORDER BY posts.id DESC
            $posts = $pdo->select(array('posts.id','title', 'img_url', 'content', 'username'))
                ->from('posts')
                ->join('users', 'posts.owner_id', '=', 'users.id')
                ->orderBy('posts.id', 'DESC')
                ->execute()
                ->fetchAll();
            return $posts;
        } catch (PDOException $e) {
            echo 'There was an error registering the account. Please try again.';
        }
    }

    public function getUserPosts($username) {
        try {
            $pdo = getPDO();

            // SELECT title, img_url, content, username
            // FROM posts
            // INNER JOIN users ON posts.owner_id = users.id
            // ORDER BY posts.id DESC
            $posts = $pdo->select(array('posts.id','title', 'img_url', 'content', 'username'))
                ->from('posts')
                ->join('users', 'posts.owner_id', '=', 'users.id')
                ->where('username', '=', $username)
                ->orderBy('posts.id', 'DESC')
                ->execute()
                ->fetchAll();
            return $posts;
        } catch (PDOException $e) {
            echo 'There was an error registering the account. Please try again.';
        }
    }

    public function addPost($title, $author, $text, $img)
    {

      $text = strip_tags($text, '<br>');
      $title = strip_tags($title, '<br>');
      $img = strip_tags($img, '<br>');

      $pdo = getPDO();
      // INSERT INTO users ( id , usr , pwd ) VALUES ( ? , ? , ? )
      $insertStatement = $pdo->insert(array('title', 'img_url', 'content', 'owner_id'))
                             ->into('posts')
                             ->values(array($title, $img, $text, $author));

      $insertId = $insertStatement->execute(false);
      return $insertID;
    }

    public function getPost($postID)
    {
      $pdo = getPDO();
      // SELECT * FROM users WHERE id = ?
      $selectStatement = $pdo->select()
                             ->from('posts')
                             ->join('users', 'posts.owner_id', '=', 'users.id')
                             ->where('posts.id', '=', $postID)
                             ;

      $stmt = $selectStatement->execute();
      $data = $stmt->fetch();
      return $data;
    }

    public function removePost($postID)
    {
      $pdo = getPDO();
      $deleteStatement = $pdo->delete()
                       ->from('posts')
                       ->where('id', '=', $postID);

      $affectedRows = $deleteStatement->execute();

    }

    public function editPost($id, $title, $img, $text)
    {
      $text = strip_tags($text, '<br>');
      $title = strip_tags($title, '<br>');
      $img = strip_tags($img, '<br>');

      $pdo = getPDO();
      // UPDATE users SET pwd = ? WHERE id = ?
      $updateStatement = $pdo->update(array('title' => $title,'img_url' => $img,'content' => $text))
                             ->table('posts')
                             ->where('id', '=', $id);

      $affectedRows = $updateStatement->execute();
    }

}
