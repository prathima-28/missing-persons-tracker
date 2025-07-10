<?php
include '../includes/db.php';

$sql = "SELECT * FROM tips ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Anonymous Tips - Admin Panel</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .tip {
            background: white;
            border-left: 6px solid #8e44ad;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        .tip h3 {
            margin-top: 0;
            color: #8e44ad;
        }

        .tip p {
            margin: 6px 0;
        }

        .tip small {
            color: #555;
        }
    </style>
</head>
<body>

<h2>📬 Anonymous Tips</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='tip'>";
        echo "<h3>🗣️ Anonymous Tip</h3>";
        echo "<p><strong>📝 Message:</strong> " . nl2br(htmlspecialchars($row['message'])) . "</p>";
        echo "<small>📅 Submitted on: " . htmlspecialchars($row['created_at']) . "</small>";
        echo "</div>";
    }
} else {
    echo "<p>No anonymous tips yet.</p>";
}
$conn->close();
?>

</body>
</html>
