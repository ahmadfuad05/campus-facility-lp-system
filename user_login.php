<?php

session_start();

include 'db.php';

/*
Check login
*/

if(isset($_POST['login'])){

    $email = $_POST['email'];

    $password = $_POST['password'];

    /*
    Check user in database
    */

    $sql = "SELECT * FROM users

            WHERE email='$email'

            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    /*
    Login success
    */

    if(mysqli_num_rows($result) > 0){

        $data = mysqli_fetch_assoc($result);

        /*
        Store session
        */

        $_SESSION['user'] = $data['username'];

        $_SESSION['user_type'] = $data['user_type'];

        $_SESSION['email'] = $data['email'];

        /*
        Redirect to input page
        */

        header("Location: input.php");

    }

    /*
    Login failed
    */

    else{

        $error = "Invalid Email or Password";

    }

}

?>

<!DOCTYPE html>

<html>

<head>

<title>User Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="style.css">

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-dark bg-dark">

<div class="container-fluid">

<a class="navbar-brand"
   href="index.php">

Campus LP System

</a>

</div>

</nav>

<!-- MAIN CONTENT -->

<div class="container mt-5">

<div class="card shadow p-5">

<h1 class="text-center mb-4">
User Login
</h1>

<!-- ERROR MESSAGE -->

<?php

if(isset($error)){

    echo "<div class='alert alert-danger'>
            $error
          </div>";

}

?>

<!-- LOGIN FORM -->

<form method="POST">

<!-- EMAIL -->

<div class="mb-3">

<label class="form-label">
Email
</label>

<input type="email"
       name="email"
       class="form-control"
       required>

</div>

<!-- PASSWORD -->

<div class="mb-3">

<label class="form-label">
Password
</label>

<input type="password"
       name="password"
       class="form-control"
       required>

</div>

<!-- LOGIN BUTTON -->

<button type="submit"
        name="login"
        class="btn btn-primary w-100">

Login

</button>

</form>

<br>

<!-- REGISTER BUTTON -->

<a href="register.php"
   class="btn btn-dark w-100">

Create New Account

</a>

</div>

</div>

</body>

</html>