
<?php
session_start();
require_once(__DIR__ . "/db_config.php");

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

$loggedIn = isset($_SESSION["admin"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="header">
  <div class="container">
    <img src="utm-logo.png" alt="UTM Logo" class="logo">
    <h1>Lost & Found Admin</h1>
    <nav>
      <a href="index.html">Home</a>
      <a href="report.html">Report Lost</a>
      <a href="listing.html">View Items</a>
      <?php if ($loggedIn): ?>
        <a href="?logout=true" style="color:#ffcc00;">Logout</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<?php if ($loggedIn): ?>
<main>
  <div class="container">
    <h3 style="margin-top: 30px;">All Reported Items</h3>
    <form method="get" action="admin.php">
      <input type="text" id="searchInput" name="search" placeholder="Search items..." value="<?php echo htmlspecialchars($search); ?>" />
      <button type="submit">Search</button>
    </form>

    <table class="admin-table">
      <thead><tr><th>ID</th><th>Name</th><th>Date Lost</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $statusClass = $row['status'] === 'pending' ? 'status pending' : 'status claimed';
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['name']}</td>
              <td>{$row['date_lost']}</td>
              <td><span class='$statusClass'>{$row['status']}</span></td>
              <td>
                <a href='?claim={$row['id']}' class='btn btn-success btn-sm' onclick=\"return confirm('Mark item as claimed?')\">Claim</a>
                <a href='?delete={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this item?')\">Delete</a>
              </td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan='5'>No data found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</main>
<?php else: ?>
<div class="container" style="margin-top: 50px;">
  <h3>Admin Login</h3>
  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form action="admin.php" method="post">
    <label>Username:</label><br>
    <input type="text" name="username" required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
  </form>
</div>
<?php endif; ?>

<footer>
  <p>&copy; 2025 WP TEAM | UTMKL Space</p>
</footer>
</body>
</html>
