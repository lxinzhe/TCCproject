<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer = $_POST['customer_name'];
    $coffee = $_POST['coffee_name'];
    $qty = $_POST['quantity'];
    
    $total = 0; 

    $sql = "INSERT INTO orders (customer_name, coffee_name, quantity, total_price) VALUES ('$customer', '$coffee', '$qty', '$total')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Order Placed Successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>