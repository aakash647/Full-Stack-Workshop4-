<?php
// Include the database connection
include 'db.php';

// Check if an ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// 1. Fetch current student data to pre-fill the form
// Use a prepared statement to securely fetch the record 
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

// If student doesn't exist, go back to list
if (!$student) {
    header("Location: index.php");
    exit();
}

// 2. Handle the Update request when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    try {
        // Part 4: Secure UPDATE query using prepared statements 
        $sql = "UPDATE students SET name = :name, email = :email, course = :course WHERE id = :id";
        $updateStmt = $conn->prepare($sql);
        
        $updateStmt->execute([
            ':name'   => $name,
            ':email'  => $email,
            ':course' => $course,
            ':id'     => $id
        ]);

        // Redirect to main list after successful update
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error updating record: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 300px; padding: 8px; }
        .btn-update { background-color: #ffc107; color: black; padding: 10px 20px; border: none; cursor: pointer; font-weight: bold; }
        .btn-back { color: #666; text-decoration: none; margin-left: 10px; }
    </style>
</head>
<body>

    <h2>Edit Student Details</h2>

    <form method="POST">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
        </div>

        <div class="form-group">
            <label>Course:</label>
            <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>" required>
        </div>

        <button type="submit" class="btn-update">Update Student</button>
        <a href="index.php" class="btn-back">Cancel</a>
    </form>

</body>
</html>