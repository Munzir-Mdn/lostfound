<?php
require_once(__DIR__ . "/db_config.php");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
  $id = intval($_POST["id"]);
  $sql = "DELETE FROM lost_items WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "error" => $conn->error]);
  }
} else {
  echo json_encode(["success" => false, "error" => "Invalid request"]);
}
?>
