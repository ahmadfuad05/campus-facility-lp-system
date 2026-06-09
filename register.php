<?php

include 'db.php';

if(isset($_POST['register'])){

    $username = $_POST['username'];

    $email = $_POST['email'];

    $password = $_POST['password'];

    $user_type = $_POST['user_type'];

    /*
    Insert user into database
    */

    $sql = "INSERT INTO users
    (username, email, password, user_type)

    VALUES

    ('$username',
     '$email',
     '$password',
     '$user_type')";

    if(mysqli_query($conn, $sql)){

        $success = "Registration Successful";

    }
    else{

        $error = "Registration Failed";

    }

}

?>

<!DOCTYPE html>

<html>

<head>

<title>User Registration</title>

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
User Registration
</h1>

<!-- SUCCESS MESSAGE -->

<?php

if(isset($success)){

    echo "<div class='alert alert-success'>
            $success
          </div>";

}

?>

<!-- ERROR MESSAGE -->

<?php

if(isset($error)){

    echo "<div class='alert alert-danger'>
            $error
          </div>";

}

?>

<!-- REGISTRATION FORM -->

<form method="POST">

<!-- USERNAME -->

<div class="mb-3">

<label class="form-label">
Username
</label>

<input type="text"
       name="username"
       class="form-control"
       required>

</div>

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

<!-- USER TYPE -->

<div class="mb-3">

<label class="form-label">
User Type
</label>

<select name="user_type"
        class="form-control"
        required>

<option value="">
Select User Type
</option>

<option value="Cadet">
Cadet
</option>

<option value="Public">
Public User
</option>

</select>

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

<!-- REGISTER BUTTON -->

<button type="submit"
        name="register"
        class="btn btn-primary w-100">

Register

</button>

</form>

<br>

<!-- LOGIN BUTTON -->

<a href="user_login.php"
   class="btn btn-dark w-100">

Go to Login

</a>

</div>

</div>

</body>

</html>