<?php
session_start();
require_once(__DIR__ . "/db_config.php"); // Betulkan path ke fail konfigurasi DB

$valid_user = "admin";
$valid_pass = "admin123";

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM lost_items WHERE id = $id");
    header("Location: admin.php");
    exit();
}

// Handle Claim Request
if (isset($_GET['claim'])) {
    $id = intval($_GET['claim']);
    $conn->query("UPDATE lost_items SET status = 'claimed' WHERE id = $id");
    header("Location: admin.php");
    exit();
}

// Search
$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $query = "SELECT * FROM lost_items WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
} else {
    $query = "SELECT * FROM lost_items ORDER BY id DESC";
}
$result = $conn->query($query);

// Handle logout
if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: admin.php");
  exit();
}

// Handle login POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION["admin"])) {
  if ($_POST["username"] === $valid_user && $_POST["password"] === $valid_pass) {
    $_SESSION["admin"] = true;
  } else {
    $error = "Invalid login.";
  }
}

// Check login status
$loggedIn = isset($_SESSION["admin"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <style>
    body { font-family: Arial; background: #f3f6f9; margin: 0; padding: 0; }
    header { background: #004990; color: white; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
    nav a { color: white; margin-left: 15px; text-decoration: none; font-weight: bold; }
    form { margin: 50px; }
    input { padding: 8px; margin: 5px; }
    button { padding: 8px 16px; }
    table { margin: 30px; border-collapse: collapse; width: 90%; }
    th, td { border: 1px solid #ccc; padding: 10px; }
    .pending { background: orange; color: white; padding: 4px 10px; border-radius: 4px; }
    .claimed { background: green; color: white; padding: 4px 10px; border-radius: 4px; }
    .btn { padding: 5px 10px; text-decoration: none; border-radius: 4px; color: white; }
    .btn-sm { font-size: 0.9em; }
    .btn-success { background-color: green; }
    .btn-danger { background-color: red; }
  </style>
</head>
<body>
<header>
  <h2>Lost & Found Admin</h2>
  <nav>
    <a href="index.html">Home</a>
    <a href="report.html">Report Lost</a>
    <a href="listing.html">View Items</a>
    <?php if ($loggedIn): ?>
      <a href="?logout=true" style="color:yellow;">Logout</a>
    <?php endif; ?>
  </nav>
</header>

<?php if ($loggedIn): ?>
<main>
  <h3 style="margin: 30px;">All Reported Items</h3>
  <form method="get" action="admin.php" style="margin: 30px;">
    <input type="text" name="search" placeholder="Search items..." value="<?php echo htmlspecialchars($search); ?>" />
    <button type="submit">Search</button>
  </form>
  <table>
    <thead><tr><th>ID</th><th>Name</th><th>Date Lost</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $statusClass = $row['status'] === 'pending' ? 'pending' : 'claimed';
          echo "<tr>
                  <td>{$row['id']}</td>
                  <td>{$row['name']}</td>
                  <td>{$row['date_lost']}</td>
                  <td><span class='$statusClass'>{$row['status']}</span></td>
                  <td>
                    <a href='?claim={$row['id']}' onclick=\"return confirm('Mark item as claimed?')\" class='btn btn-success btn-sm'>Claim</a>
                    <a href='?delete={$row['id']}' onclick=\"return confirm('Delete this item?')\" class='btn btn-danger btn-sm'>Delete</a>
                  </td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No data found</td></tr>";
      }
    ?>
    </tbody>
  </table>
</main>

<?php else: ?>
<form action="admin.php" method="post">
  <h3 style="margin: 30px;">Admin Login</h3>
  <?php if (!empty($error)) echo "<p style='color:red; margin-left:30px;'>$error</p>"; ?>
  <label style="margin-left: 30px;">Username:</label>
  <input type="text" name="username" required>
  <label>Password:</label>
  <input type="password" name="password" required>
  <button type="submit">Login</button>
</form>
<?php endif; ?>

<footer>
    <p>&copy; 2025 WP TEAM | UTMKL Space</p>
</footer>

</body>
</html>