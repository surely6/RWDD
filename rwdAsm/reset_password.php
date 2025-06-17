<?php
ob_start();
session_start();
include('connection.php');
if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_userid'])) {
    header("Location: forgot_password.php");
    exit();
}

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($new_password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    } else {
        $email = $_SESSION['reset_email'];
        $userid = $_SESSION['reset_userid'];

        $statement = $connection->prepare("UPDATE user SET UserPW = ? WHERE Email = ? AND UserID = ?");
        
        if ($statement) {
            $statement->bind_param("sss", $new_password, $email, $userid);
            
            if ($statement->execute()) {
                unset($_SESSION['reset_email']);
                unset($_SESSION['reset_userid']);

                $_SESSION['reset_message'] = "Password successfully reset. Please log in.";
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error updating password. Please try again.";
            }
            
            $statement->close();
        } else {
            $error_message = "Database error: " . $connection->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
        .albert-sans{
        font-family: "Albert Sans", sans-serif;
        }
            
        .lato{
        font-family: "Lato", sans-serif;
        }

        *{
        margin: 0;
        padding: 0;
        box-sizing: border-box; 
        scroll-behavior:smooth ;
        }

        :root{
        --white-color: #fff;
        --dark-color: #252525;
        --primary-color: #929572;
        --secondary-color: #b9c19a;
        --light-pink-color: #faf4f5;
        --light-yellow: #d3d4c0;
        --light-white: #ecf0f1;
        --gray-color: #cccccc;
        --dark-gray-color: #444444;
        --dark-white: #f0f0f0;
        --light-gray: #dddddd;
        --link-blue-color: #0000ee;
        --red-color: #ff0000;

        --font-size-xs: 0.75rem;
        --font-size-s: 0.9rem;
        --font-size-n: 1rem;
        --font-size-m: 1.12rem;
        --font-size-l: 1.5rem;
        --font-size-xl: 2rem;
        --font-size-xxl: 2.3rem;
        --font-size-xxxl: 3rem;

        --font-weight-normal: 400;
        --font-weight-medium: 500;
        --font-weight-semibold: 600;
        --font-weight-bold: 700;

        --border-radius-s: 8px;
        --border-radius-m: 30px;
        --border-radius-circle: 50%;

        --site-max-width: 1300px;
        }

        body {
            background-image: url('img/background.png');
            margin: 0;
            padding: 0;
            font-family: "Albert sans", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-size: cover;
            background-position: center;
        }

        /*NAVIGATION BAR*/
        header{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 5;
            background: var(--primary-color);
        }

        header .navbar{
            display: flex;
            padding: 20px;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .nav-logo{
          text-decoration: none;
        }

        .navbar .nav-menu{
            display: flex;
            gap: 10px;
            list-style-type: none;
        }

        .nav-logo .logo-image{
            height: 60px;
            width: auto;
            margin-top: -10px;
            margin-bottom: -10px;
        }

        /*RESET PASSWORD*/
        .container {
            background: var(--light-white);
            border-radius: 1px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
            padding: 40px;
            text-align: center;
        }

        .container h2 {
            font-family: "Albert Sans", sans-serif;
            margin-bottom: 30px;
            color: var(--dark-color);
        }

        .container label{
            font-family: "Lato", sans-serif;
            display: block;
            text-align: left;
            margin-left: 5%;
        }

        .container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid var(--gray-color);
            border-radius: 1px;
            font-size: var(--font-size-n);
        }

        .container button {
            background-color: var(--primary-color);
            color: var(--white-color);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-family:'Times New Roman', Times, serif;
        }

        .container button:hover {
            background-color: var(--secondary-color);
        }

        .back-login{
            font-family: "Lato", sans-serif;
            color: var(--link-blue-color);
        }

        .error-message {
            color: var(--red-color);
            margin-bottom: 10px;
        }

        @media (max-width: 320px) {
    .container {
        width: 90%; 
        padding: 10px;
        overflow-y: auto; 
    }

    .container h2 {
        font-size: var(--font-size-m); 
    }

    .container input {
        width: 100%;
        height: 40px;
        padding: 8px;
        font-size: var(--font-size-s);
    }

    .container button {
        padding: 10px;
        font-size: var(--font-size-n); 
    }

    .back-login {
        font-size: var(--font-size-xs); 
    }

    .error-message {
        font-size: var(--font-size-xs); 
    }
}
    </style>
</head>

<body>
    <!--HEADER AND NAVIGATION BAR-->
    <header>
        <nav class="navbar">
            <a href="landingPage.php" class="nav-logo" section-content>
                <img src="img/logo.png" alt="MASS SPM logo" class="logo-image">
            </a>
        </nav>
    </header>
    <div class="container">
        <h2>Reset Password</h2>
        
        <?php
        if (!empty($error_message)) {
            echo "<div class='error-message'>" . htmlspecialchars($error_message) . "</div>";
        }
        ?>

        <form method="post" action="">
            <label for="password">New Password</label>
            <input type="password" name="new_password" 
                   required minlength="8" 
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                   title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
            <label for="password">Confirm New Password</label>
            <input type="password" name="confirm_password"
                   required minlength="8"
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                   title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
            
            <button type="submit">Reset Password</button>
        </form>

        <div style="margin-top: 10px;">
            <a href="login.php" class="back-login">Back to Login</a>
        </div>
    </div>
</body>
</html>