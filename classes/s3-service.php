<?php
require 'vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
use Aws\S3\S3Client;

date_default_timezone_set('UTC');



class S3 {


  public function generateRandomString($length) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }

  public function uploadPic($imgPath, $imageFileType, $username){
    $s3 = new Aws\S3\S3Client([
      'region'  => 'us-west-2',
      'version' => 'latest',
      'scheme' => 'http',
    ]);

    // Send a PutObject request and get the result object.
    $randomString = $this->generateRandomString(10);


    $key = $randomString.'-'. $username .'.'.$imageFileType.'';


    $result = $s3->putObject([
      'Bucket' => 'bloghub-bucket',
      'Key'    => $key,
      'Body'   => 'this is the body!',
      'ACL' => 'public-read',
      'SourceFile' => $imgPath // use this if you want to upload a file from a local location
    ]);

    // We can poll the object until it is accessible
    $s3->waitUntil('ObjectExists', array(
        'Bucket' => 'bloghub-bucket',
        'Key'    => $key
    ));

    //Return the url for the uploaded img
    return $key;

  }



  public function deletePic($imgName){
    if($imgName == "" || $imgName == NULL || $imgName == "default-user.png"){
      return false;
    }
    $s3 = new Aws\S3\S3Client([
      'region'  => 'us-west-2',
      'version' => 'latest',
      'scheme' => 'http',
    ]);

    $bucket = 'bloghub-bucket';
    $keyname = $imgName;

    // Delete an object from the bucket.
    $s3->deleteObject([
        'Bucket' => $bucket,
        'Key'    => $keyname
    ]);


  }


}

?>
