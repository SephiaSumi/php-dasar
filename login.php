<?php
    session_start();

    if (isset($_COOKIE['remember'])) {
        if($_COOKIE['remember'] == 'true') {
            $_SESSION['login'] = true;
        }
    }

    if (isset($_SESSION['login'])) {
        if ($_SESSION['login'] == true) {
            header("Location: session.php");
            exit;
        }
    }

    $email = 'sephiasumi25@gmail.com';
    $password = 'sephia';

    if (isset($_POST['email']) && isset($_POST['password'])) {
        if ($_POST['email'] != $email) {
            echo "email tidak terdaftar";
            exit;
        }
        if ($_POST['password'] != $password) {
            echo "password salah";
            exit;
        }
        if ($_POST['email'] == $email && $_POST['password'] == $password) {
            if (isset($_POST['remember'])) {
                setcookie('remember', 'true', time() + 20);
            }

            $_SESSION['login'] = true;
            header("Location: session.php");
            exit;    
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="position-absolute top-50 start-50 translate-middle w-75">
        <div class="card p-5 bg-light">
            <h1 class="text-center"> Login </h1>
            <form method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                    <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>