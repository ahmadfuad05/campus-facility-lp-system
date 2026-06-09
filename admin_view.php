<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: admin_login.php"); exit(); }
include 'db.php';

$sql = "SELECT * FROM optimization_input ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage User Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-5 bg-white rounded-3">
        <h1 class="text-center mb-4 text-primary fw-bold">Master Requests List (Admin)</h1>
        <table class="table table-bordered table-striped text-center">
            <thead class="table-primary">
                <tr><th>ID</th><th>Username</th><th>Facility Name</th><th>Requested Hours</th><th>Priority</th><th>User Type</th><th>Min Cadet Hours</th></tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td class="fw-bold"><?php echo htmlspecialchars($row['username'] ?? 'Anonymous'); ?></td>
                    <td><?php echo htmlspecialchars($row['facility_name'] ?? 'N/A'); ?></td>
                    <td><?php echo $row['total_hours']; ?> hrs</td>
                    <td><?php echo $row['priority_value']; ?></td>
                    <td><span class="badge bg-secondary"><?php echo $row['user_type']; ?></span></td>
                    <td><?php echo $row['min_cadet_hours']; ?> hrs</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="d-grid gap-3 mt-4">
            <a href="process.php" class="btn btn-success btn-lg fw-bold">🚀 Run Linear Programming Optimization</a>
            <a href="admin.php" class="btn btn-secondary">Back to Admin Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>