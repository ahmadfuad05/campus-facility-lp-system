<?php

include 'db.php';

$sql = "DELETE FROM optimization_results";

if(mysqli_query($conn, $sql)){

    header("Location: view_result.php");

}
else{

    echo "Error deleting data";

}

?>