<?php

session_start();

/*
Check login
*/

if(isset($_POST['login'])){

    $username = $_POST['username'];

    $password = $_POST['password'];

    /*
    Simple admin login
    */

    if($username == "admin" && $password == "admin123"){

        $_SESSION['admin'] = $username;

        header("Location: admin.php");

    }
    else{

        $error = "Invalid Username or Password";

    }

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card shadow p-5">

<h1 class="text-center mb-4">
Admin Login
</h1>

<?php

if(isset($error)){

    echo "<div class='alert alert-danger'>$error</div>";

}

?>

<form method="POST">

<div class="mb-3">

<label>
Username
</label>

<input type="text"
       name="username"
       class="form-control"
       required>

</div>

<div class="mb-3">

<label>
Password
</label>

<input type="password"
       name="password"
       class="form-control"
       required>

</div>

<button type="submit"
        name="login"
        class="btn btn-primary w-100">

Login

</button>

</form>

<br>

<a href="index.php"
   class="btn btn-dark w-100">

Back to Homepage

</a>

</div>

</div>

</body>

</html>