<?php
require 'vendor/autoload.php';

include 'profiles.php';
include 'getPDO.php';



function registerUser($username, $password)
{
    $username = strip_tags($username, '<br>');
    $password = strip_tags($password, '<br>');

    try {
        $pdo = getPDO();

        $selectStatement = $pdo->select()
            ->from('users')
            ->where('username', '=', $username);
        $pdostatement = $selectStatement->execute();

        if ($pdostatement->rowCount() > 0) {
            return 'Username already exists.';
        } else {
            $insertStatement = $pdo->insert(array('username', 'password'))
                ->into('users')
                ->values(array($username, hash('sha512', $password)));

            $insertId = $insertStatement->execute();

            //create profiles
            $profiles = new Profiles();
            $profiles->addProfile($username);

            return '';
        }
    } catch (PDOException $e) {
        return 'There was an error registering the account. Please try again.';
    }
}

function loginUser($username, $password)
{
    $username = strip_tags($username, '<br>');
    $password = strip_tags($password, '<br>');

    try {
        $pdo = getPDO();

        $selectStatement = $pdo->select(array('id'))
            ->from('users')
            ->where('username', '=', $username)
            ->where('password', '=', hash('sha512', $password));
        $pdostatement = $selectStatement->execute();
        $result = $pdostatement->fetch();

        if ($pdostatement->rowCount() == 0) {
            return 'Login failed; that username/password combination does not exist.';
        } else {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $result[id];
            header('Location: ./');
        }
    } catch (PDOException $e) {
        return 'There was an error logging in. Please try again.';
    }
}
