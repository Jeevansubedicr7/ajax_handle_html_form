<?php

include "db.php";

// Get the action sent by AJAX
$action = $_POST["action"] ?? "";


// ==================== CREATE ====================

if ($action == "create") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Insert data using prepared statement
    $stmt = $conn->prepare(
        "INSERT INTO students (name, email, phone) VALUES (?, ?, ?)"
    );

    $stmt->bind_param("sss", $name, $email, $phone);

    if ($stmt->execute()) {
        echo "Student added successfully!";
    } else {
        echo "Error adding student.";
    }
}


// ==================== READ ====================

elseif ($action == "read") {

    $result = $conn->query("SELECT * FROM students");

    $students = [];

    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    // Send data as JSON
    echo json_encode($students);
}


// ==================== UPDATE ====================

elseif ($action == "update") {

    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Update student record
    $stmt = $conn->prepare(
        "UPDATE students
         SET name = ?, email = ?, phone = ?
         WHERE id = ?"
    );

    $stmt->bind_param("sssi", $name, $email, $phone, $id);

    if ($stmt->execute()) {
        echo "Student updated successfully!";
    } else {
        echo "Error updating student.";
    }
}


// ==================== DELETE ====================

elseif ($action == "delete") {

    $id = $_POST["id"];

    // Delete student record
    $stmt = $conn->prepare(
        "DELETE FROM students WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Student deleted successfully!";
    } else {
        echo "Error deleting student.";
    }
}

?>