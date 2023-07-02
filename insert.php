<?php

$servername = "127.0.0.1";
$username = "root";
$password = "india22fade";
$dbname = "health_report";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$age = $_POST['age'];
$weight = $_POST['weight'];
$email = $_POST['email'];

// File upload
$targetDir = "uploads/";
$targetFile = $targetDir . basename($_FILES["healthReport"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if file is a PDF
if ($fileType != "pdf") {
    echo "Only PDF files are allowed.";
    $uploadOk = 0;
}

// Check if file already exists
if (file_exists($targetFile)) {
    echo "File already exists.";
    $uploadOk = 0;
}

// Check file size (max 5MB)
if ($_FILES["healthReport"]["size"] > 5 * 1024 * 1024) {
    echo "File size exceeds the maximum limit of 5MB.";
    $uploadOk = 0;
}

// Upload file if all checks pass
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["healthReport"]["tmp_name"], $targetFile)) {
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("INSERT INTO users (name, age, weight, email, health_report) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siss", $name, $age, $weight, $email, $targetFile);

        // Execute the INSERT statement
        $stmt->execute();

        // Close statement
        $stmt->close();

        echo "User details and PDF file inserted successfully!";
    } else {
        echo "Error uploading the file.";
    }
}

// Close connection
$conn->close();
?>
