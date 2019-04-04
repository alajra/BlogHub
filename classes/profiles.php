<?php
require 'vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
use Aws\S3\S3Client;

date_default_timezone_set('UTC');


$sdk = new Aws\Sdk([
    'region' => 'us-west-2',
    'version' => 'latest',
    'scheme' => 'http',
]);


$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();
$tableName = 'bloghub-profiles';


class Profiles
{

    public function getImage($username){
      $key = $GLOBALS['marshaler']->marshalJson('
          {
              "username": "' . $username . '"
          }
      ');

      $params = [
          'TableName' => $GLOBALS['tableName'],
          'Key' => $key,
      ];


      try {
          $result = $GLOBALS['dynamodb']->getItem($params);
          return $result['Item']['img']['S'];
      } catch (DynamoDbException $e) {
          echo "Unable to query:\n";
          echo $e->getMessage() . "\n";
      }

    }


    public function addProfile($username)
    {
      $item = $GLOBALS['marshaler']->marshalJson('
          {
              "username": "' . $username . '",
              "img": "default-user.png"
          }
      ');
      $params = [
          'TableName' => $GLOBALS['tableName'],
          'Item' => $item
      ];


      try {
          $result = $GLOBALS['dynamodb']->putItem($params);
          echo "Added item.\n";

      } catch (DynamoDbException $e) {
          echo "Unable to add item:\n";
          echo $e->getMessage() . "\n";
      }


    }

    public function getProfile($username)
    {
        $key = $GLOBALS['marshaler']->marshalJson('
            {
                "username": "' . $username . '"
            }
        ');

        $params = [
            'TableName' => $GLOBALS['tableName'],
            'Key' => $key,
        ];


        try {
            $result = $GLOBALS['dynamodb']->getItem($params);
            return $result['Item'];
        } catch (DynamoDbException $e) {
            echo "Unable to query:\n";
            echo $e->getMessage() . "\n";
        }
    }

    public function deleteProfile($username)
    {
        $key = $GLOBALS['marshaler']->marshalJson('
            {
                "username": "' . $username . '"
            }
        ');

        $params = [
            'TableName' => $GLOBALS['tableName'],
            'Key' => $key,
        ];

        try {
            $result = $GLOBALS['dynamodb']->deleteItem($params);
            echo "Deleted profile with a user name item." . $username . "\n";

        } catch (DynamoDbException $e) {
            echo "Unable to delete item:\n";
            echo $e->getMessage() . "\n";
        }

    }

    public function editProfile($name, $username, $img, $bio)
    {
        $name = strip_tags($name, '<br>');
        $bio = strip_tags($bio, '<br>');
        $img = strip_tags($img, '<br>');


        $marshaler = new Marshaler();

        $keyString = '{"username": "' . $username . '"}';
        $key = $marshaler->marshalJson($keyString);

        $eavString  = '
            {
                ":name": "'.$name.'" ,
                ":img": "'.$img.'",
                ":bio": "'.$bio.'"
            }
        ';
        $eav = $marshaler->marshalJson($eavString);

        $params = [
            'TableName' => $GLOBALS['tableName'],
            'Key' => $key,
            'UpdateExpression' =>
                'set profileName = :name, img=:img, bio=:bio',
            'ExpressionAttributeValues'=> $eav,
            'ReturnValues' => 'UPDATED_NEW'
        ];

        try {
            $result = $GLOBALS['dynamodb']->updateItem($params);

        } catch (DynamoDbException $e) {
            echo "Unable to update item:\n";
            echo $e->getMessage() . "\n";
        }

    }

}
