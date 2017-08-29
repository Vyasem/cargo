<?php
$dsn = 'mysql:dbname=logistic;host=127.0.0.1';
$login = 'root';
$password = 'admin';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {
    $dbObject = new PDO($dsn, $login, $password, $options);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}