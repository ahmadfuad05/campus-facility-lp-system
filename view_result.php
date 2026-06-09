<?php
session_start();

/* KESELAMATAN KETAT: Hanya ADMIN sahaja boleh akses halaman sejarah keputusan LP ini */
if(!isset($_SESSION['admin'])){
    header("Location: index.php");
    exit();
}

include 'db.php';

/* Dapatkan semua data results analisis optimization */
$sql = "SELECT * FROM optimization_results ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Optimization Results (Admin Only)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid"><a class="navbar-brand" href="index.php">Campus LP System - Admin Portal</a></div>
</nav>

<div class="container mt-5">
    <div class="card shadow p-5">
        <h1 class="text-center mb-4 text-danger">Optimization Results Analysis (Master History)</h1>
        <div class="alert alert-warning text-center fw-bold">⚠️ CONFIDENTIAL: Internal Management & Optimization Logs Only</div>
        <br>

        <!-- NOTIFIKASI JIKA SEJARAH BERJAYA DIPADAM -->
        <?php if(isset($_GET['status']) && $_GET['status'] == 'cleared'){ ?>
            <div class="alert alert-success text-center fw-bold">🗑️ Sejarah log pengiraan telah berjaya dikosongkan dengan bersih!</div>
        <?php } ?>

        <table class="table table-bordered table-striped text-center shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Facility</th>
                    <th>User Type</th>
                    <th>Allocated Hours (x)</th>
                    <th>Remaining Hours (y)</th>
                    <th>Optimum Value (Z)</th>
                    <th>Date Processed</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) == 0){ ?>
                    <tr>
                        <td colspan="8" class="text-muted py-4">No history records found. The log is currently empty.</td>
                    </tr>
                <?php } else { ?>
                    <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td class="fw-bold text-primary"><?php echo htmlspecialchars($row['username'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['facility_name']); ?></td>
                        <td><?php echo $row['user_type']; ?></td>
                        <td><?php echo $row['cadet_hours']; ?> hrs</td>
                        <td><?php echo $row['public_hours']; ?> hrs</td>
                        <td class="fw-bold text-success"><?php echo $row['optimum_value']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <br>

        <!-- NAVIGASI ACTION BUTTONS -->
        <div class="d-grid gap-3">
            <!-- BUTANG RESET BARU: Hanya keluar kalau jadual ada isi data sahaja -->
            <?php if(mysqli_num_rows($result) > 0){ ?>
                <a href="clear_history.php" class="btn btn-danger fw-bold shadow-sm py-2" onclick="return confirm('Adakah anda pasti mahu memadam SEMUA rekod sejarah pengiraan LP ini? Tindakan ini tidak boleh dikembalikan.');">
                    🗑️ Clear & Reset All History Logs
                </a>
            <?php } ?>

            <a href="admin.php" class="btn btn-secondary">Back To Admin Dashboard</a>
            <a href="admin_view.php" class="btn btn-dark">View Raw Requests</a>
        </div>
    </div>
</div>
</body>
</html>