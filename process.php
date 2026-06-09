<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin']) && !isset($_SESSION['user'])){ header("Location: index.php"); exit(); }

$sql_input = "SELECT * FROM optimization_input ORDER BY id DESC LIMIT 1";
$result_input = mysqli_query($conn, $sql_input);
$data = mysqli_fetch_assoc($result_input);

if(!$data){ die("<div class='container mt-5 alert alert-warning text-center'>No request found to optimize.</div>"); }

$username_input = $data['username'];
$facility_name = $data['facility_name'];
$user_type = $data['user_type'];

/* TENTUKAN HAD MODEL MATEMATIK BERDASARKAN REPORT KORANG */
$max_hours = ($facility_name == "Gym" || $facility_name == "Gym Room") ? 40 : 60; 
$min_cadet_hours = 10; 
$priority_x = 5; 
$priority_y = 3; 

$best_x = 0; $best_y = 0; $max_z = 0;  

/* ENGINE BRUTE FORCE LP CONSTRAINTS */
for($x = 0; $x <= $max_hours; $x++){
    for($y = 0; $y <= $max_hours; $y++){
        $c1 = ($x + $y <= 40);   
        $c2 = ((2 * $x) + $y <= 60); 
        $c3 = ($x >= $min_cadet_hours); 
        
        if($c1 && $c2 && $c3){
            $z = ($priority_x * $x) + ($priority_y * $y);
            if($z > $max_z){ $max_z = $z; $best_x = $x; $best_y = $y; }
        }
    }
}

$sql_result = "INSERT INTO optimization_results (username, facility_name, user_type, cadet_hours, public_hours, optimum_value) 
               VALUES ('$username_input', '$facility_name', '$user_type', '$best_x', '$best_y', '$max_z')";
mysqli_query($conn, $sql_result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Optimization Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 750px;">
    <div class="card shadow p-5 bg-white text-center rounded-3">
        <h1 class="text-primary fw-bold mb-4">Linear Programming Engine</h1>
        <div class="alert alert-success text-start small">
            <h6><strong>Applied Model:</strong> Maximize Z = 5x + 3y</h6>
            <h6><strong>Constraints:</strong> x + y <= 40 | 2x + y <= 60 | x >= 10</h6>
            <hr>
            <h6>Target: <?php echo htmlspecialchars($facility_name); ?> | By: <?php echo htmlspecialchars($username_input); ?></h6>
        </div>
        <h4 class="mt-4 text-secondary">Optimal Allocation Output</h4>
        <table class="table table-bordered shadow-sm mt-3">
            <thead class="table-secondary"><tr><th>Variable</th><th>Description</th><th>Optimal Allocation</th></tr></thead>
            <tbody>
                <tr><td><strong>x</strong></td><td>Cadets Time Allocation</td><td class="text-success fw-bold"><?php echo $best_x; ?> Hours</td></tr>
                <tr><td><strong>y</strong></td><td>Public Users Time Allocation</td><td class="text-success fw-bold"><?php echo $best_y; ?> Hours</td></tr>
                <tr class="table-warning"><td><strong>Z</strong></td><td class="fw-bold">Max Total Utilization Value</td><td class="text-danger fw-bold fs-5"><?php echo $max_z; ?></td></tr>
            </tbody>
        </table>
        <div class="d-grid gap-2 mt-4">
            <?php if(isset($_SESSION['admin'])): ?><a href="view_result.php" class="btn btn-success fw-bold">View Master Results History</a><a href="admin.php" class="btn btn-secondary">Back to Dashboard</a>
            <?php else: ?><a href="my_booking.php" class="btn btn-info text-white fw-bold">📋 View My Booking Status</a><a href="index.php" class="btn btn-secondary">Back Home</a><?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>