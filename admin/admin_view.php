<?php
include '../includes/db.php';

$sql = "SELECT * FROM persons ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Missing Persons - Admin Panel</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f9fa;
            padding: 40px;
        }

        h2 {
            text-align: center;
            color: #34495e;
            margin-bottom: 30px;
        }

        .person-card {
            background: white;
            border-left: 6px solid #3498db;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .person-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #ddd;
        }

        .person-details {
            flex-grow: 1;
        }

        .person-details p {
            margin: 5px 0;
        }

        .highlight {
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>

<h2>📋 All Reported Missing Persons</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='person-card'>";
        echo "<img src='../" . htmlspecialchars($row['image_path']) . "' alt='Photo'>";
        echo "<div class='person-details'>";
        echo "<p class='highlight'>👤 " . htmlspecialchars($row['name']) . "</p>";
        echo "<p>📍 Area: " . htmlspecialchars($row['area']) . "</p>";
        echo "<p>🗓️ Missing Date: " . htmlspecialchars($row['missing_date']) . "</p>";
        echo "<p>⚥ Gender: " . htmlspecialchars($row['gender']) . "</p>";
        echo "<p>🎨 Color: " . htmlspecialchars($row['color']) . "</p>";
        echo "<p>📏 Height: " . htmlspecialchars($row['height']) . "</p>";
        echo "<p>⚖️ Weight: " . htmlspecialchars($row['weight']) . "</p>";
        echo "</div></div>";
    }
} else {
    echo "<p>No missing persons found.</p>";
}
$conn->close();
?>

</body>
</html>
