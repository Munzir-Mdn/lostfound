<?php
require_once 'db_config.php';
require_once 'send_email.php';
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
  $id = intval($_POST["id"]);
  $sql = "UPDATE lost_items SET status = 'claimed' WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
    // OPTIONAL: Get user email from DB or set static
    $email = "user@example.com";  // Gantikan dengan email pengguna sebenar
    sendNotification($email, "Item Claimed", "<strong>Item ID $id has been claimed.</strong>");
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "error" => $conn->error]);
  }
} else {
  echo json_encode(["success" => false, "error" => "Invalid request"]);
}
?>
