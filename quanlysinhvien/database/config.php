<?php
$dbhost = "localhost";
$dbuser = "root";
$dbname = "qldsv_db";
$dbpass = "";


try {
    $pdo = new PDO("mysql: host=$dbhost; dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>