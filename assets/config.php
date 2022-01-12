<?php

$google_api_key = "";
$mysql_host = "";
$mysql_port = "";
$mysql_user = "";
$mysql_pass = "";
$mysql_db   = "";
$mysql_ssl  = false;

// =
$mysql = null;
// -
try {
    $mysql = new PDO("mysql:host=$mysql_host:$mysql_port;dbname=$mysql_db;charset=utf8", $mysql_user, $mysql_pass, ['MultipleActiveResultSets' => false]);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo ("Failed to get DB handle: " . $e->getMessage() . "<br>");
    echo ("<strong>StackTrace</strong>:<pre>");
    echo ($e->getTraceAsString());
    echo ("</pre>");
}
