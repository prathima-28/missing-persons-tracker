<?php
include 'includes/db.php';

// Collect form data
$person_id = isset($_POST['person_id']) && is_numeric($_POST['person_id']) ? (int)$_POST['person_id'] : null;
$person_name = $_POST['person_name'] ?? 'Unknown';
$location = $_POST['location'] ?? '';
$message = $_POST['message'] ?? '';
$contact_info = $_POST['contact_info'] ?? '';

// Handle image upload
$image_path = '';
if (!empty($_FILES['sighting_image']['name'])) {
    $image_name = time() . '_' . basename($_FILES['sighting_image']['name']);
    $target = 'uploads/' . $image_name;
    if (move_uploaded_file($_FILES['sighting_image']['tmp_name'], $target)) {
        $image_path = $target;
    }
}

// Prepare insert statement
$stmt = $conn->prepare("
    INSERT INTO sightings (person_id, person_name, location, message, image_path, contact_info, submitted_at)
    VALUES (?, ?, ?, ?, ?, ?, NOW())
");

$stmt->bind_param("isssss", $person_id, $person_name, $location, $message, $image_path, $contact_info);

if ($stmt->execute()) {
    echo "<h3>👁️ Thank you for submitting a sighting report!</h3>";
    echo "<p><a href='index.html'>Return to Home</a></p>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
