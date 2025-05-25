<?php
$host = getenv("MYSQLHOST") ?: "localhost";
$user = getenv("MYSQLUSER") ?: "root";
$pass = getenv("MYSQLPASSWORD") ?: "";
$db   = getenv("MYSQLDATABASE") ?: "lost_found_db";
$port = getenv("MYSQLPORT") ?: 3306;

// Debug output - sementara untuk lihat nilai
echo "Host: $host<br>User: $user<br>DB: $db<br>Port: $port<br>";

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
  die("❌ Connection failed: " . $conn->connect_error);
}
echo "✅ Connection successful!";
?>
