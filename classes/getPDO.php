<?
set_include_path('../');
require 'vendor/autoload.php';

function getPDO()
{
    $host = 'localhost';
    $user = getenv('RDS_USERNAME');
    if (!$user) {
        $user = 'root';
    } else {
        $host = 'bloghub-rds.cisqnd3qf2b5.us-west-2.rds.amazonaws.com';
    }

    $password = getenv('RDS_PASSWORD');
    if (!$password) {
        $password = 'rootroot';
    }

    $dsn = 'mysql:host='.$host.';dbname=bloghub;charset=utf8';

    return new \Slim\PDO\Database($dsn, $user, $password);
}
