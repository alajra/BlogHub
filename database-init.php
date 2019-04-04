<?php
require 'vendor/autoload.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
    'region' => 'us-west-2',
    'version' => 'latest',
    'scheme' => 'http'
]);

$tableName = 'bloghub-profiles';
$dynamodb = $sdk->createDynamoDb();

$params = [
    'TableName' => $tableName,
    'KeySchema' => [
        [
            'AttributeName' => 'username',
            'KeyType' => 'HASH'  //Partition key
        ]
    ],
    'AttributeDefinitions' => [
        [
            'AttributeName' => 'username',
            'AttributeType' => 'S'
        ]

    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 10,
        'WriteCapacityUnits' => 10
    ]
];

try {
    $result = $dynamodb->createTable($params);
    echo 'Created table.  Status: ' .
        $result['TableDescription']['TableStatus'] ."\n";

} catch (DynamoDbException $e) {
    echo "Unable to create table:\n";
    echo $e->getMessage() . "\n";
}

$marshaler = new Marshaler();

$item = $marshaler->marshalJson('
    {
        "username": "fatih",
        "school": "UWB",
        "color": "Blue",
        "location": "Seattle"
    }
');

$params = [
    'TableName' => $tableName,
    'Item' => $item
];


try {
    $result = $dynamodb->putItem($params);
    echo "Added item.\n";

} catch (DynamoDbException $e) {
    echo "Unable to add item:\n";
    echo $e->getMessage() . "\n";
}


$item = $marshaler->marshalJson('
    {
        "username": "fatih",
        "info": {
            "plot": "Nothing happens at all.",
            "rating": 0
        }
    }
');

$params = [
    'TableName' => $tableName,
    'Item' => $item
];


try {
    $result = $dynamodb->putItem($params);
    echo "Added item.\n";

} catch (DynamoDbException $e) {
    echo "Unable to add item:\n";
    echo $e->getMessage() . "\n";
}


?>
