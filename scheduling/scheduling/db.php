<?php
// PDO

$servername = "localhost";
$username = "root";
$password="";
$dbname = "timetable_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=timetable_db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "DB 연결 성공";
} catch(PDOException $e) {
    echo $e -> getMessage();
}