<?php
$conn = new mysqli("localhost", "root", "", "missing_persons", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
