?php
include '../includes/db.php';

$result = $conn->query("
  SELECT 
    s.*, 
    p.name AS missing_name, 
    p.gender AS missing_gender,
    p.area AS missing_area,
    p.missing_date,
    p.image_path AS missing_image
  FROM sightings s
  LEFT JOIN persons p ON s.person_id = p.id
  ORDER BY s.submitted_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - Sightings</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    .sighting-box {
      background: #fff;
      padding: 20px;
      margin: 20px auto;
      border-radius: 10px;
      max-width: 700px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .sighting-box img {
      max-width: 100%;
      border-radius: 8px;
      margin: 10px 0;
    }
    h2 {
      text-align: center;
    }
  </style>
</head>
<body>
  <h2>👁️ Sightings Reported</h2>

  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="sighting-box">

      <?php if ($row['missing_name']): ?>
        <h3>🧑‍🤝‍🧑 Missing Person Details</h3>
        <p><strong>👤 Name:</strong> <?= htmlspecialchars($row['missing_name']) ?></p>
        <p><strong>🧭 Area:</strong> <?= htmlspecialchars($row['missing_area']) ?></p>
        <p><strong>⚧️ Gender:</strong> <?= htmlspecialchars($row['missing_gender']) ?></p>
        <p><strong>📅 Missing Date:</strong> <?= htmlspecialchars($row['missing_date']) ?></p>
        <?php if ($row['missing_image']): ?>
          <img src="../<?= htmlspecialchars($row['missing_image']) ?>" alt="Missing Person Image">
        <?php endif; ?>
        <hr>
      <?php else: ?>
        <h3>👤 Unlinked Sighting (No matching person_id)</h3>
      <?php endif; ?>

      <h3>👁️ Sighting Details</h3>
      <p><strong>📍 Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
      <p><strong>📝 Message:</strong> <?= htmlspecialchars($row['message']) ?></p>
      <p><strong>📞 Contact:</strong> <?= htmlspecialchars($row['contact_info']) ?: "Not provided" ?></p>
      <p><strong>📅 Reported:</strong> <?= htmlspecialchars($row['submitted_at']) ?></p>

      <?php if (!empty($row['image_path'])): ?>
        <p><strong>📸 Witness Photo:</strong></p>
        <img src="../<?= htmlspecialchars($row['image_path']) ?>" alt="Sighting Photo">
      <?php endif; ?>
    </div>
  <?php endwhile; ?>

</body>
</html>
