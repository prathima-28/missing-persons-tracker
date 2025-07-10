<?php
include 'includes/db.php';

$type = $_POST['search_type'];
$query = "SELECT * FROM persons WHERE ";
$params = [];
$types = "";

if ($type == 'area') {
    $query .= "area LIKE ?";
    $params[] = "%" . $_POST['area'] . "%";
    $types .= "s";
} elseif ($type == 'gender') {
    $query .= "gender = ?";
    $params[] = $_POST['gender'];
    $types .= "s";
} elseif ($type == 'date') {
    $query .= "missing_date = ?";
    $params[] = $_POST['missing_date'];
    $types .= "s";
} else {
    die("Invalid search type.");
}

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

echo "<link rel='stylesheet' href='style.css'>";
echo "<h2>Search Results</h2>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='person'>";
        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
        echo "<p><strong>Area:</strong> " . htmlspecialchars($row['area']) . "</p>";
        echo "<p><strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "</p>";
        echo "<p><strong>Missing Date:</strong> " . htmlspecialchars($row['missing_date']) . "</p>";
        echo "<img src='uploads/" . htmlspecialchars($row['image_path']) . "' width='200'><br><br>";
        
        // Pass person_id and name in URL
        $link = "sighting_form.html?person_id=" . urlencode($row['id']) . "&person_name=" . urlencode($row['name']);
        echo "<a href='$link' class='btn-sighting'>👁️ I Saw This Person</a>";
        
        echo "</div><hr>";
    }
} else {
    echo "<p>No matches found.</p>";
}

$conn->close();
?>
