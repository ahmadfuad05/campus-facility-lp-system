<?php
session_start();

/* KESELAMATAN KETAT: Hanya ADMIN sahaja boleh padam sejarah log ini */
/* Jika bukan admin, tendang dia pergi ke page LOGIN ADMIN terus! */
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

/* Padam semua rekod dalam jadual sejarah optimization */
$sql = "TRUNCATE TABLE optimization_results";

if(mysqli_query($conn, $sql)){
    /* Lepas berjaya padam, hantar admin balik ke view_result.php dengan status sukses */
    header("Location: view_result.php?status=cleared");
} else {
    echo "Error clearing logs: " . mysqli_error($conn);
}
exit();
?>