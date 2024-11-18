<?php
require_once "config.php";

if (isset($_POST['login'])) {
    $userid = mysqli_real_escape_string($conn, $_POST['user']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $stmt_admin = $conn->prepare("SELECT id FROM admin_login WHERE status='1' AND BINARY id = ? AND BINARY password = ?") or die(mysqli_error($conn));
    $stmt_admin->bind_param("ss", $userid, $password);
    $stmt_admin->execute();
    $stmt_admin->store_result();
    $admin_count = $stmt_admin->num_rows;
    $stmt_admin->close();

    $stmt_user = $conn->prepare("SELECT id FROM user_login WHERE status='1' AND BINARY  id = ? AND BINARY password = ?") or die(mysqli_error($conn));
    $stmt_user->bind_param("ss", $userid, $password);
    $stmt_user->execute();
    $stmt_user->store_result();
    $user_count = $stmt_user->num_rows;
    $stmt_user->close();

    if ($admin_count > 0) {
        $stmt_admin_pin = $conn->prepare("SELECT id FROM admin_login WHERE status='1' AND BINARY  id = ? AND BINARY password = ?") or die(mysqli_error($conn));
        $stmt_admin_pin->bind_param("ss", $userid, $password);
        $stmt_admin_pin->execute();
        $stmt_admin_pin->store_result();
        $pin_count = $stmt_admin_pin->num_rows;
        $stmt_admin_pin->close();

        if ($pin_count > 0) {
            session_start();
            $_SESSION['id'] = $userid;
            $userid = $_SESSION['id'];
            header("location: admin_page.php");
            exit();
        }
    } elseif ($user_count > 0) {
        $stmt_user_pin = $conn->prepare("SELECT id FROM user_login WHERE status='1' AND BINARY  id = ? AND BINARY password = ?") or die(mysqli_error($conn));
        $stmt_user_pin->bind_param("ss", $userid, $password);
        $stmt_user_pin->execute();
        $stmt_user_pin->store_result();
        $pin_count = $stmt_user_pin->num_rows;
        $stmt_user_pin->close();

        if ($pin_count > 0) {
            session_start();
            $_SESSION['id'] = $userid;
            $userid = $_SESSION['id'];
            header("location: user_page.php");
            exit();
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login error',
                text: 'Invalid ID or PIN. Please try again.',
            }).then(function() {
                window.location.href = 'login.php';
            });
        </script>
    </body>

    </html>
<?php
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DREAM 11 PROJECT</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            width: 100%;
            background: rgb(0, 0, 87);
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 430px;
            width: 100%;
            background: #fff;
            border-radius: 7px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        }
        .container .form {
            padding: 2rem;
        }

        .form header {
            font-size: 2rem;
            font-weight: 500;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form input {
            height: 60px;
            width: 100%;
            padding: 0 15px;
            font-size: 17px;
            margin-bottom: 1.3rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
        }

        .form input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
        }

        .form a {
            font-size: 16px;
            color: navy;
            text-decoration: none;
        }

        .form a:hover {
            text-decoration: underline;
            color: navy;
        }

        .form input.button {
            color: #fff;
            background: navy;
            font-size: 1.2rem;
            font-weight: 500;
            letter-spacing: 1px;
            margin-top: 1.7rem;
            cursor: pointer;
            transition: 0.4s;
        }

        .form input.button:hover {
            background: #1d5c7c;
        }

        .signup {
            font-size: 17px;
            text-align: center;
        }

        .signup label {
            color: navy;
            cursor: pointer;
        }

        .signup label:hover {
            text-decoration: underline;
            color: #1d5c7c;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="Sign-in form">
            <header>Sign in</header>
            <form method="post">
                <input type="text" name="user" placeholder="Enter id">
                <input type="password" name="password" placeholder="Enter password">
                <input type="submit" name="login" class="button" value="Login">
            </form>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</body>

</html>