<?php
// Include the database connection
include 'db.php';

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect user input from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    try {
        // Part 4: Use a prepared statement for the INSERT query 
        // This ensures user input is never written directly into the SQL query 
        $sql = "INSERT INTO students (name, email, course) VALUES (:name, :email, :course)";
        $stmt = $conn->prepare($sql);
        
        // Bind and execute the data safely
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':course' => $course
        ]);

        // Redirect back to the main list after success
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error adding student: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Student</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"] { width: 300px; padding: 8px; }
        .btn-submit { background-color: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .btn-back { color: #666; text-decoration: none; margin-left: 10px; }
    </style>
</head>
<body>

    <h2>Add New Student</h2>

    <form method="POST" action="add.php">
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" required placeholder="Enter full name">
        </div>

        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" required placeholder="Enter email address">
        </div>

        <div class="form-group">
            <label for="course">Course:</label>
            <input type="text" name="course" id="course" required placeholder="e.g., Computer Science">
        </div>

        <button type="submit" class="btn-submit">Save Student</button>
        <a href="index.php" class="btn-back">Cancel and Go Back</a>
    </form>

</body>
</html>