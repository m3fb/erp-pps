<?php
/*return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=192.168.1.111;dbname=FAUSER_DEV_V6',
    'username' => 'Fauser',
    'password' => 'yvM335',
    'charset' => 'utf8',
];*/
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:server=localhost\sqlexpress;database=Qualitainer1;ConnectionPooling=0',
    'username' => 'sa',
    'password' => 'yvM335#',
    'charset' => 'utf-8',
    #'init' => ['SET LANGUAGE us_english']
];
