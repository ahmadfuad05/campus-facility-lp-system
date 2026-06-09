<?php
session_start();

/* Sekat jika belum login sebagai user */
if(!isset($_SESSION['user'])){
    header("Location: user_login.php");
    exit();
}

include 'db.php';
$current_logged_user = $_SESSION['user'];

/* Tarik rekod permohonan yang dibeli/ditempah oleh user yang sedang aktif sahaja */
$sql = "SELECT * FROM optimization_results WHERE username = '$current_logged_user' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Facility Booking Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid"><a class="navbar-brand" href="index.php">Campus LP System</a></div>
</nav>

<div class="container mt-5" style="max-width: 800px;">
    <div class="card shadow p-5">
        <h1 class="text-center mb-4 text-primary">My Facility Bookings Status</h1>
        <p class="text-muted text-center">Logged in as: <strong><?php echo htmlspecialchars($current_logged_user); ?></strong></p>
        <br>

        <?php if(mysqli_num_rows($result) == 0){ ?>
            <div class="alert alert-secondary text-center">You haven't submitted any facility bookings yet.</div>
        <?php } else { ?>
            <?php while($row = mysqli_fetch_assoc($result)){ 
                /* Logic Penentu Kelulusan: Jika jam peruntukan cadet (x) berjaya mendapat slot lebih dari 0, maknanya BERJAYA */
                $is_approved = ($row['cadet_hours'] > 0);
            ?>
                <div class="card mb-3 border-<?php echo $is_approved ? 'success' : 'danger'; ?> shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1 fw-bold"><?php echo htmlspecialchars($row['facility_name']); ?></h5>
                            <p class="card-text text-muted mb-0">Date Processed: <?php echo $row['created_at']; ?></p>
                        </div>
                        <div class="text-end">
                            <?php if($is_approved){ ?>
                                <span class="badge bg-success fs-6 p-2">✅ Booking Approved</span>
                                <div class="small text-success mt-1">Allocated: <?php echo $row['cadet_hours']; ?> Wk Hours</div>
                            <?php } else { ?>
                                <span class="badge bg-danger fs-6 p-2">❌ Booking Rejected</span>
                                <div class="small text-danger mt-1">Reason: Facility Full / Low Priority</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <br>
        <div class="d-grid gap-2">
            <a href="input.php" class="btn btn-primary">Make Another Request</a>
            <a href="index.php" class="btn btn-dark">Return to Homepage</a>
        </div>
    </div>
</div>
</body>
</html>