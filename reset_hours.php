<?php
session_start();

/* KESELAMATAN KETAT: Hanya ADMIN sahaja boleh reset jam fasiliti */
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

/* FIX: Menggunakan nama column yang betul iaitu 'remaining_hours' */
/* Kita setkan semula baki jam ke had maksimum asal (contoh: 60 jam) */
$sql_reset = "UPDATE facility_status SET remaining_hours = 60";

if(mysqli_query($conn, $sql_reset)){
    /* Lepas berjaya reset, hantar admin balik ke admin dashboard dengan status sukses */
    header("Location: admin.php?status=reset_success");
} else {
    echo "Error resetting hours: " . mysqli_error($conn);
}
exit();
?>