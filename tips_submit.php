<?php
include 'includes/db.php';

// Create uploads folder if not exists
if (!is_dir('uploads')) {
    mkdir('uploads');
}

// Collect form data
$message = $_POST['message'];
$location = $_POST['location'] ?? '';
$image_path = "";

// Handle image upload if provided
if (!empty($_FILES['image']['name'])) {
    $image_name = uniqid() . "_" . basename($_FILES["image"]["name"]);
    $target_dir = "uploads/";
    $target_file = $target_dir . $image_name;
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;
    }
}

// Insert into database
$sql = "INSERT INTO tips (message, location, image_path, submitted_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $message, $location, $image_path);

if ($stmt->execute()) {
    echo "<h2>✅ Thank you for your tip!</h2>";
    echo "<p>Your information has been received.</p>";
    echo "<a href='index.html'>Return to Homepage</a>";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
