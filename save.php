<?php
session_start();
if(!isset($_SESSION['user']) || isset($_SESSION['admin'])){ header("Location: index.php"); exit(); }
include 'db.php';

$current_user = $_SESSION['user'];
$sql_latest = "SELECT * FROM optimization_input WHERE username = '$current_user' ORDER BY id DESC LIMIT 1";
$result_latest = mysqli_query($conn, $sql_latest);
$data = mysqli_fetch_assoc($result_latest);

if(!$data){ header("Location: input.php"); exit(); }

$facility_name = $data['facility_name'];
$facility_sql = "SELECT remaining_hours FROM facility_status WHERE facility_name = '$facility_name' LIMIT 1";
$facility_res = mysqli_query($conn, $facility_sql);
$facility_data = mysqli_fetch_assoc($facility_res);
$remaining_hours = $facility_data['remaining_hours'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Saved Successfully</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 650px;">
    <div class="card shadow p-5 bg-white rounded-3">
        <h1 class="text-center text-success fw-bold mb-4">Data Saved Successfully</h1>
        <table class="table table-bordered align-middle">
            <tbody>
                <tr><td class="fw-bold bg-light" style="width: 40%;">User Submitting</td><td class="fw-bold text-primary"><?php echo htmlspecialchars($data['username']); ?></td></tr>
                <tr><td class="fw-bold bg-light">Facility Name</td><td><?php echo htmlspecialchars($data['facility_name']); ?></td></tr>
                <tr><td class="fw-bold bg-light">User Type</td><td><?php echo htmlspecialchars($data['user_type']); ?></td></tr>
                <tr><td class="fw-bold bg-light">Hours Requested</td><td><?php echo $data['total_hours']; ?> Hours</td></tr>
                <tr><td class="fw-bold bg-light">New Remaining Balance</td><td class="fw-bold text-danger"><?php echo $remaining_hours; ?> Hours</td></tr>
            </tbody>
        </table>
        <div class="alert alert-info text-center mt-4">ℹ️ Permohonan anda sedang diproses untuk penjadualan Linear Programming oleh Admin.</div>
        <div class="d-grid gap-3 mt-4">
            <a href="input.php" class="btn btn-primary fw-bold btn-lg">Back to Input Form</a>
            <a href="my_booking.php" class="btn btn-info text-white fw-bold btn-lg">📋 Check My Booking Status</a>
            <a href="index.php" class="btn btn-dark">Return to Homepage</a>
        </div>
    </div>
</div>
</body>
</html>