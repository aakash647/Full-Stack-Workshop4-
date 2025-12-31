<?php
// Part 2: Include the database connection file [cite: 8]
require 'db.php'; 

// Part 3 & 4: Secure Delete Operation [cite: 15]
// Uses a prepared statement to prevent SQL injection [cite: 17]
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
    
    // Redirect to the same page to refresh the list
    header("Location: index.php");
    exit();
}

// Read Operation with Search Functionality [cite: 13]
$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search != '') {
    // Part 4: Secure search using prepared statements 
    $stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE ? OR course LIKE ?");
    $searchTerm = "%$search%";
    $stmt->execute([$searchTerm, $searchTerm]);
} else {
    // Default: Fetch all student records [cite: 13]
    $stmt = $conn->query("SELECT * FROM students");
}

$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student List Application</title>
    <style>
        body { font-family: sans-serif; margin: 30px; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; }
        .search-bar { margin-bottom: 20px; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .btn-add { background-color: #7c1882ff; color: white; padding: 10px 15px; }
        .btn-edit { background-color: #ff9307ff; color: black; }
        .btn-delete { background-color: #35dc9fff; color: white; }
    </style>
</head>
<body>

    <h2>Student List</h2>

    <div class="search-bar">
        <form method="GET" action="index.php">
            <input type="text" name="search" placeholder="Search by name or course..." value="<?= htmlspecialchars($search) ?>" style="padding: 8px; width: 250px;">
            <button type="submit" style="padding: 8px 15px;">Search</button>
            <?php if ($search): ?>
                <a href="index.php">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <a href="add.php" class="btn btn-add">Add New Student</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($students) > 0): ?>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['id']) ?></td>
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                    <td><?= htmlspecialchars($student['course']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-edit">Edit</a>
                        
                        <a href="index.php?delete=<?= $student['id'] ?>" 
                           class="btn btn-delete" 
                           onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No students found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>