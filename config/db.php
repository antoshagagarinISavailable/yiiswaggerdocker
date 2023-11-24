<?php

return [

    // для docker
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',

    // для mamp
    // 'class' => 'yii\db\Connection',
    // 'dsn' => 'mysql:host=localhost:8889;dbname=test_calc',
    // 'username' => 'me',
    // 'password' => 'mwwbohp1',
    // 'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
