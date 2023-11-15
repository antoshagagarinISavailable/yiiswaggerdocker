<?php

return [
    // 'class' => 'yii\db\Connection',
    // 'dsn' => 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
    // 'username' => $_ENV['DB_USER'],
    // 'password' => $_ENV['DB_PASSWORD'],
    // 'charset' => 'utf8',
    // ---- либо первый, либо второй работают для dockera
    // 'class' => 'yii\db\Connection',
    // 'dsn' => 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
    // 'username' => getenv('DB_USER'),
    // 'password' => getenv('DB_PASSWORD'),
    // 'charset' => 'utf8',
    // для mamp
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost:8889;dbname=calc_db',
    'username' => 'me',
    'password' => 'mwwbohp1',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
