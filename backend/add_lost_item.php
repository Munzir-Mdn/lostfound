<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['name'] ?? '';
  $desc = $_POST['description'] ?? '';
  $date = $_POST['date_lost'] ?? '';
  $status = 'pending';
  $image = '';

  // Validasi asas
  if (empty($name) || empty($desc) || empty($date)) {
    echo json_encode(["success" => false, "error" => "Missing required fields."]);
    exit;
  }

  // Jika ada gambar dimuat naik
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $targetDir = "../uploads/";
    if (!file_exists($targetDir)) {
      mkdir($targetDir, 0777, true);
    }
    $image = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $image;
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
      echo json_encode(["success" => false, "error" => "Failed to upload image."]);
      exit;
    }
  }

  $stmt = $conn->prepare("INSERT INTO lost_items (name, description, date_lost, image, status) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $name, $desc, $date, $image, $status);

  if ($stmt->execute()) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
  }
} else {
  echo json_encode(["success" => false, "error" => "Invalid request method"]);
}
?>
