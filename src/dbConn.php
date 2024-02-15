<?php

function getDbConnection()
{
    // checking for possible environment variables
    $dsn = isset($_ENV['dsn']) ? $_ENV['dsn'] : "mysql:host=w0463683.c5becqsczizr.us-east-1.rds.amazonaws.com;dbname=employees";
    $username = !empty($_ENV['username']) ? $_ENV['username'] : "root";
    $password = !empty($_ENV['password']) ? $_ENV['password'] : "inet2005";

    error_log($dsn);
    error_log($username);
    error_log($password);

    $options = [
        PDO::ATTR_ERRMODE                   => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE        => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES          => false,
    ];
    return new PDO($dsn, $username, $password, $options);
}
?>