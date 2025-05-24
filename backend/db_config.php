<?php
// Ambil maklumat dari Railway Environment Variables
$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT");

// Sambung ke pangkalan data
$conn = new mysqli($host, $user, $password, $database, $port);

// Semak sambungan
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
