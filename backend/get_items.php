<?php
require_once("__DIR__ . "/db_config.php"");
header("Content-Type: application/json");

$sql = "SELECT id, name, description, date_lost, status FROM lost_items ORDER BY id DESC";
$result = $conn->query($sql);

$items = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $items[] = $row;
  }
}

echo json_encode($items);
?>
