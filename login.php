<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .login_heading{
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .login_reg_btn_container{
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body class="container-fluid p-3 mt-4">

    <form action="index.php" method="post">

        <div class="container">
            <div class="login_heading">
                <div>
                    <h1 class="mb-3">Log In</h1>
                </div>
                <div class="login_reg_btn_container">
                    <a href="registration.php"><button type="button" class="btn btn-dark">Register</button></a>
                </div>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="user_name" placeholder="name@example.com" required>
                <label for="floatingInput">User Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingInput" name="password" placeholder="name@example.com" required>
                <label for="floatingInput">Password</label>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary" type="submit" name="login_form_submit">Log In</button>
            </div>
        </div>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>