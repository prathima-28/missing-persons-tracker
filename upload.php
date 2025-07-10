<?php
include 'includes/db.php';

// Collect data from form
$name = $_POST['name'];
$missing_date = $_POST['missing_date'];
$area = $_POST['area'];
$gender = $_POST['gender'];
$color = $_POST['color'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$contact = $_POST['contact'];
$status = "Reported";

// Handle image upload
$image_name = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];
$image_folder = "uploads/" . uniqid() . "_" . basename($image_name);
move_uploaded_file($image_tmp, $image_folder);

// Insert into DB
$sql = "INSERT INTO persons (name, missing_date, area, gender, color, height, weight, contact, status, image_path)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $name, $missing_date, $area, $gender, $color, $height, $weight, $contact, $status, $image_folder);

if ($stmt->execute()) {
    echo "<h2>Thank you! The missing person report has been submitted.</h2>";
    echo "<a href='index.html'>🔙 Go Back to Homepage</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
