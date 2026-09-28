<?php

// Database connection
$conn = new mysqli("localhost", "root", "", "ajax_crud");

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

?>