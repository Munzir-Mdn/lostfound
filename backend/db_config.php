<?php
$host = getenv("MYSQLHOST");
$username = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT");

// Optional: fallback hardcoded untuk development
// $host = 'crossover.proxy.rlwy.net';
// $username = 'root';
// $password = 'password_di_sini';
// $database = 'railway';
// $port = 42850;

$conn = new mysqli($host, $username, $password, $database, $port);

// Semak sambungan
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
