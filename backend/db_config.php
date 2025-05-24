<?php
$host = "mysql.railway.internal";   // contoh host dari Railway
$user = "root";                                  // user dari Railway
$pass = "UIZmbWXwMOeoOSoatLBVhMHLoswvOYbS";             // password dari Railway
$db   = "railway";                               // nama database dari Railway
$port = 3306;                                     // port dari Railway

$conn = new mysqli($host, $user, $pass, $db, $port);

// Semak sambungan
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
