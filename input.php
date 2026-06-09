<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: user_login.php");
    exit();
}

include 'db.php';

/* Get all facilities status */
$facility_sql = "SELECT * FROM facility_status";
$facility_result = mysqli_query($conn, $facility_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Facility Usage Input Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Campus LP System</a>
    </div>
</nav>

<div class="container mt-3 p-3 d-flex justify-content-between align-items-center" style="margin-top: 20px; background: #e9ecef; border-radius: 8px;">
    <a href="index.php" class="btn btn-secondary">⬅ Back to Homepage</a>
    <div class="fw-bold text-dark">
        Maximum Facility Capacity: <span class="badge bg-danger fs-6">50 Hours Max</span>
    </div>
</div>

<div class="container mt-4">
    <div class="card shadow p-5 text-start">
        <h2 class="text-center mb-4">Facility Usage Input Form</h2>

        <div class="alert alert-success">
            <h5>Username: <?php echo htmlspecialchars($_SESSION['user']); ?></h5>
            <h5>User Type: <?php echo htmlspecialchars($_SESSION['user_type']); ?></h5>
        </div>

        <form action="save.php" method="POST">

            <div class="mb-3">
                <label class="form-label fw-bold">Select Facility</label>
                <select name="facility_name" class="form-control" required>
                    <option value="">Choose Facility</option>
                    <?php 
                    mysqli_data_seek($facility_result, 0);
                    while($facility = mysqli_fetch_assoc($facility_result)){ 
                    ?>
                        <option value="<?php echo $facility['facility_name']; ?>">
                            <?php echo $facility['facility_name']; ?> 
                            (Remaining Time: <?php echo $facility['remaining_hours']; ?>/50 Hours Available)
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Hours Requested</label>
                <select name="requested_hours" class="form-control" required>
                    <option value="">-- Select Hours --</option>
                    <option value="5">5 Hours</option>
                    <option value="10">10 Hours</option>
                    <option value="15">15 Hours</option>
                    <option value="20">20 Hours</option>
                    <option value="25">25 Hours</option>
                    <option value="30">30 Hours</option>
                    <option value="35">35 Hours</option>
                    <option value="40">40 Hours</option>
                    <option value="45">45 Hours</option>
                    <option value="50">50 Hours</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold">Save Facility Request</button>
        </form>

        <br>
        <div class="d-grid gap-2">
            <a href="view.php" class="btn btn-dark">View Saved Requests</a>
            <a href="view_result.php" class="btn btn-success">View Optimization Results</a>
            <a href="user_logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

</body>
</html>