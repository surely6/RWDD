<!-- registered admin gmail 
 Admin1
 email: alexa@gmail.com
 pw: alexa123

 Admin2
 email: SaswinBM@gmail.com
 pw: saswinisbatman2

 Assumption: Admin cannot register through normal sign up portal
-->

<?php
ob_start();
session_start();
include('connection.php');
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $userid = $_POST['email'];
    $password = $_POST['password'];
    $found = FALSE;
    if ($found == FALSE)
    {
        $sql = "SELECT * FROM user WHERE Email = '$userid' AND UserPW = '$password'";
        $result = mysqli_query($connection, $sql);
        if(!$result){
            die("Query failed: " . mysqli_error($connection));
        }
        while($user = mysqli_fetch_array($result))
        {
            var_dump($user);
            if($user['Email'] == $userid && $user["UserPW"] == $password)
            {
                $found = TRUE;
                $_SESSION['userID'] = $user['UserID'];
                $_SESSION['name'] = $user['UserName'];
                $_SESSION['status'] = 'user';
                break;
            }
        }
    }
    if($found == FALSE)
    {
        $sql = "SELECT * FROM admin WHERE Email = '$userid' AND AdminPW = '$password'";
        $result = mysqli_query($connection, $sql);
        if(!$result){
            die("Query failed: " . mysqli_error($connection));
        }
        while($admin = mysqli_fetch_array($result))
        {
            var_dump($admin);
            if($admin['Email'] == $userid && $admin['AdminPW'] == $password)
            {
                $found = TRUE;
                $_SESSION['userID'] = $admin['AdminID'];
                $_SESSION['name'] = $admin['AdminUserName'];
                $_SESSION['email'] = $admin['Email'];
                $_SESSION['status'] = 'admin';
                break;
            }
        }
    }

    if($found == TRUE)
    {
        if ($_SESSION['status'] == 'user'){
            header("Location: user_home.php");
            exit();
        } else if ($_SESSION['status'] == 'admin'){
            header("Location: adminIndex.php");
            exit();
        }
    } else {
        $error_message = "Incorrect email or password. Please try again.";
    }

    if(isset($_SESSION['reset_message'])){
        echo "<div class='success'>" . htmlspecialchars($_SESSION['reset_message']) . "</div>";
        unset($SESSION['reset_message']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        /*LOGIN*/
        .container {
            background: var(--light-white);
            border-radius: 1px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
            padding: 40px;
            text-align: center;
        }
        .container h1 { 
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

        .container input[type="email"],
        .container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid var(--gray-color);
            border-radius: 1px;
            font-size: var(--font-size-n);
        }

        .container a.forgot-password {
            display: block;
            margin: 10px 0;
            text-decoration: none;
            font-size: var(--font-size-xs);
            text-align: left;
            margin-left: 0;
        }

        .container a{
            font-family: "Lato", sans-serif;
            color: var(--link-blue-color);
        }

        .container a.forgot-password:hover {
            text-decoration: underline;
        }

        .container a.sign-up {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            margin-left: 5px;
            color: var(--link-blue-color);
            text-decoration: underline;
            font-size: var(--font-size-n);
            font-family: "Lato", sans-serif;
        }

        .container a.sign-up:hover {
            text-decoration: underline;

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

        .error {
            color: var(--red-color);
            margin-bottom: 10px;
        }

        @media (max-width: 768px){
            .container{
                padding: 20px;
            }
            .container h1{
                font-size: var(--font-size-l);
            }
            .container input[type = "email"],
            .container input[type = "password"]{
                padding: 12px;
            }
            .container button{
                padding: 8px;
            }
        }

        @media (max-width: 480px){
            .container{
                padding: 15px;
            }
            .container h1{
                font-size: var(--font-size-m);
            }
            .container input[type = "email"],
            .container input[type = "password"]{
                padding: 10px;
            }
            .container button{
                padding: 10px;
            }
        }

        @media (max-width: 320px) {
    .container {
        width: 90%; 
        padding: 15px; 
    }

    .container h1 {
        font-size: var(--font-size-m); 
    }

    .container input[type="email"],
    .container input[type="password"] {
        padding: 8px; 
        font-size: var(--font-size-s);
    }

    .container button {
        padding: 10px;
        font-size: var(--font-size-n);
    }

    .container a.forgot-password,
    .container a.sign-up {
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
        <h1>Log In</h1>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form method="POST" action="" autocomplete="on">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" autocomplete="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="current-password" required>
            <a href="forgot_password.php" onclick="window.location='forgot_password.php'">Forgot password?</a>
            <button type="submit">Log In</button>
        </form>
        <div class="asu"></div>
        <p>Don't have an account?<a class="sign-up" href="signup.php">Sign up</a></p>
    </div>
</body>
</html>