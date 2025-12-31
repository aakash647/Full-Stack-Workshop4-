<?php
$host = "localhost";
$username = "root";
$password = "";

try {
    // 1. Initial connection to the MySQL server
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Create the school_db database [cite: 5]
    $conn->exec("CREATE DATABASE IF NOT EXISTS school_db");
    echo "Database 'school_db' created successfully.<br>";

    // 3. Select the database
    $conn->exec("USE school_db");

    // 4. Create the students table with required fields [cite: 5]
    $sql_table = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        course VARCHAR(100) NOT NULL
    )";
    $conn->exec($sql_table);
    echo "Table 'students' created successfully.<br>";

    // 5. Check if the table is empty before inserting sample records [cite: 6]
    $check = $conn->query("SELECT COUNT(*) FROM students")->fetchColumn();
    if ($check == 0) {
        // Use prepared statements for secure insertion [cite: 17]
        $stmt = $conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
        
        $sample_data = [
            ['Alice Johnson', 'alice@example.com', 'Computer Science'],
            ['Bob Smith', 'bob@example.com', 'Information Technology'],
            ['Charlie Brown', 'charlie@example.com', 'Software Engineering'],
            ['Diana Prince', 'diana@example.com', 'Data Science'],
            ['Edward Norton', 'edward@example.com', 'Cyber Security']
        ];

        foreach ($sample_data as $student) {
            $stmt->execute($student);
        }
        echo "5 sample student records inserted successfully.<br>"; [cite: 6]
    } else {
        echo "Records already exist, skipping insertion.";
    }

} catch (PDOException $e) {
    echo "Setup failed: " . $e->getMessage(); [cite: 10]
}
?>