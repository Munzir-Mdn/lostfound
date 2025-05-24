<?php
$host = getenv("crossover.proxy.rlwy.net");
$username = getenv("MYSQLUSER");
$password = getenv("UIZmbWXwMOeoOSoatLBVhMHLoswvOYbS");
$database = getenv("railway");
$port = getenv("3306");

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
