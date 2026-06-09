<?php
session_start();

/* 
===================================================================
1. ADMIN AUTHENTICATION
===================================================================
Menyekat pengguna biasa daripada menceroboh masuk ke dashboard admin
*/
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

/* 
===================================================================
2. DATABASE QUERIES (SUMMARY STATS)
===================================================================
*/
/* Dapatkan status baki jam setiap fasiliti */
$facility_sql = "SELECT * FROM facility_status";
$facility_result = mysqli_query($conn, $facility_sql);

/* Kira jumlah akaun user dalam sistem */
$user_count_sql = "SELECT COUNT(*) AS total_users FROM users";
$user_count_result = mysqli_query($conn, $user_count_sql);
$user_count = mysqli_fetch_assoc($user_count_result);

/* Kira jumlah borang permohonan yang dihantar oleh user */
$request_count_sql = "SELECT COUNT(*) AS total_requests FROM optimization_input";
$request_count_result = mysqli_query($conn, $request_count_sql);
$request_count = mysqli_fetch_assoc($request_count_result);

/* Kira jumlah sejarah pengiraan optimization yang tersimpan */
$result_count_sql = "SELECT COUNT(*) AS total_results FROM optimization_results";
$result_count_result = mysqli_query($conn, $result_count_sql);
$result_count = mysqli_fetch_assoc($result_count_result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin.php">Campus LP System - Admin Portal</a>
        <a href="logout.php" class="btn btn-danger font-weight-bold">Logout</a>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container mt-4">

    <!-- NOTIFIKASI SUKSES APABILA JAM BERJAYA DI-RESET -->
    <?php if(isset($_GET['status']) && $_GET['status'] == 'reset_success'){ ?>
        <div class="alert alert-success text-center fw-bold shadow-sm mb-4">
            🔄 Semua baki jam operasi fasiliti telah berjaya di-reset ke 60 Jam dengan selamat!
        </div>
    <?php } ?>

    <h1 class="text-center mb-4 fw-bold">Admin Dashboard Panel</h1>

    <!-- SUMMARY STATS CARDS -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-white rounded-3 p-3">
                <h5 class="text-muted">Registered Users</h5>
                <h2 class="display-6 fw-bold text-dark"><?php echo $user_count['total_users']; ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-white rounded-3 p-3">
                <h5 class="text-muted">Total Requests</h5>
                <h2 class="display-6 fw-bold text-primary"><?php echo $request_count['total_requests']; ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-white rounded-3 p-3">
                <h5 class="text-muted">Optimization Runs</h5>
                <h2 class="display-6 fw-bold text-success"><?php echo $result_count['total_results']; ?></h2>
            </div>
        </div>
    </div>

    <!-- SECTION: FACILITY STATUS DISPLAY -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white fw-bold">
            📊 Current Facility Operational Status
        </div>
        <div class="card-body bg-white rounded-bottom">
            <table class="table table-bordered text-center align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 15%;">ID</th>
                        <th>Facility Name</th>
                        <th style="width: 35%;">Remaining Hours Available</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($facility = mysqli_fetch_assoc($facility_result)){ ?>
                    <tr>
                        <td><?php echo $facility['id']; ?></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($facility['facility_name']); ?></td>
                        <td>
                            <span class="badge bg-info p-2 text-dark fs-6">
                                <?php echo $facility['remaining_hours']; ?> Hours
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECTION: ADMIN ACTIONS HUB -->
    <div class="card shadow-sm mb-5 border-0">
        <div class="card-header bg-success text-white fw-bold">
            ⚙️ Admin Core Control Panel
        </div>
        <div class="card-body bg-white rounded-bottom d-grid gap-3">
            <!-- Butang utama menjalankan enjin pengiraan Linear Programming -->
            <a href="process.php" class="btn btn-success btn-lg fw-bold shadow-sm py-3">
                🚀 Run Linear Programming Optimization Engine
            </a>
            
            <!-- Butang reset baki jam (Memanggil column remaining_hours dengan betul) -->
            <a href="reset_hours.php" class="btn btn-warning fw-bold py-2" onclick="return confirm('Adakah anda pasti mahu set semula semua baki jam fasiliti kepada 60 Jam?');">
                🔄 Reset All Facility Hours
            </a>
            
            <!-- Link dihalakan ke fail asing admin_view.php -->
            <a href="admin_view.php" class="btn btn-primary py-2 fw-bold">
                📂 View & Manage User Requests List
            </a>
            
            <!-- Link melihat sejarah log jawapan matematik yang sulit -->
            <a href="view_result.php" class="btn btn-dark py-2">
                📜 View Confidential Optimization Results History Log
            </a>
        </div>
    </div>
</div>

</body>
</html>