<?php
require_once(__DIR__ . "/db_config.php"); // atau "backend/db_config.php" jika perlu

// Semak sambungan
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
echo "✅ Successfully connected to the Railway Database.";
?>
