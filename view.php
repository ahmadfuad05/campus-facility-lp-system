<?php
session_start();

/* KESELAMATAN: Hanya USER BIASA sahaja boleh akses halaman ini */
if(!isset($_SESSION['user']) || isset($_SESSION['admin'])){
    header("Location: index.php");
    exit();
}

include 'db.php';

/* TAPISAN DATA KOSONG: Hanya ambil data yang sah (total_hours lebih besar dari 0) */
$sql = "SELECT * FROM optimization_input WHERE total_hours > 0 ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Saved Facility Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid"><a class="navbar-brand" href="index.php">UPNM Facility LP System</a></div>
</nav>

<div class="container mt-5" style="max-width: 900px;">
    <div class="card shadow p-5 bg-white rounded">
        <h1 class="text-center mb-4 fw-bold">Saved Facility Data</h1>
        
        <!-- STATUS LOGIN USER -->
        <div class="alert alert-success text-center py-2 mb-4">
            Logged in as: <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong><br>
            User Type: <strong>Cadet</strong>
        </div>

        <table class="table table-bordered table-striped text-center align-middle shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Total Hours</th>
                    <th>Priority Value</th>
                    <th>User Type</th>
                    <th>Minimum Cadet Hours</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) == 0){ ?>
                    <tr>
                        <td colspan="5" class="text-muted py-3">No valid requests found.</td>
                    </tr>
                <?php } else { ?>
                    <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['total_hours']; ?></td>
                        <td><?php echo $row['priority_value']; ?></td>
                        <td><?php echo htmlspecialchars($row['user_type'] ?? 'Cadet'); ?></td>
                        <td><?php echo $row['min_cadet_hours']; ?></td>
                    </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <br>

        <!-- NAVIGASI BUTANG USER (Butang Run Optimization DAH DIBUANG) -->
        <div class="d-grid gap-3">
            <a href="input.php" class="btn btn-primary fw-bold py-2">Add New Facility Request</a>
            <a href="my_booking.php" class="btn btn-info fw-bold text-white py-2">📋 Check My Booking Status</a>
            <a href="index.php" class="btn btn-dark py-2">Back to Homepage</a>
        </div>
    </div>
</div>
</body>
</html>