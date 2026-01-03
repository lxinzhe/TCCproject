<?php
$servername = "localhost";
$username = "root";
$password = "WatermelonCoffee123";
$dbname = "coffee_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
