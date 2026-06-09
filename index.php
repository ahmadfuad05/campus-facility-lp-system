<?php
session_start();
include 'db.php';

$is_admin = isset($_SESSION['admin']);
$is_user = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Campus Facility Usage Optimization System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">UPNM Facility LP System</a>
        <div>
            <?php if($is_admin): ?><span class="badge bg-danger me-2">Admin</span><a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            <?php elseif($is_user): ?><span class="badge bg-primary me-2"><?php echo htmlspecialchars($_SESSION['user']); ?></span><a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            <?php else: ?><a href="user_login.php" class="btn btn-outline-primary btn-sm me-2">User Login</a><a href="admin_login.php" class="btn btn-outline-danger btn-sm">Admin Login</a><?php endif; ?>
        </div>
    </div>
</nav>
<div class="container" style="max-width: 750px;">
    <div class="card shadow p-5 bg-white text-center rounded-3">
        <h1 class="fw-bold mb-3">Campus Facility Usage Optimization System</h1>
        <p class="text-muted mb-4">Uses Linear Programming to optimize facility usage between cadets and public users.</p>
        <hr class="mb-4">
        <div class="d-grid gap-3">
            <?php if(!$is_admin && !$is_user): ?>
                <div class="alert alert-warning py-3 fw-bold">Please Login to Access the System</div>
                <a href="user_login.php" class="btn btn-primary btn-lg fw-bold">🔐 Student / User Login</a>
                <a href="admin_login.php" class="btn btn-danger btn-lg fw-bold">⚙️ Facility Admin Login</a>
            <?php elseif($is_user): ?>
                <h5 class="text-start text-secondary fw-bold">👋 Student Menu:</h5>
                <a href="input.php" class="btn btn-primary btn-lg fw-bold py-3">📝 Request Facility Data</a>
                <a href="my_booking.php" class="btn btn-info btn-lg fw-bold text-white py-3">📋 Check My Booking Status</a>
                <a href="view.php" class="btn btn-dark py-2">📂 View Public Requests List</a>
            <?php elseif($is_admin): ?>
                <h5 class="text-start text-danger fw-bold">⚙️ Admin Menu Active:</h5>
                <a href="admin.php" class="btn btn-danger btn-lg fw-bold py-3">🎮 Go To Admin Control Dashboard</a>
                <a href="admin_view.php" class="btn btn-primary py-2 fw-bold">📂 Review User Requests</a>
                <a href="view_result.php" class="btn btn-secondary py-2">📜 View Master Optimization Logs</a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>