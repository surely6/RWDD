<?php
include("connection.php");

if (isset($_POST["UserID"])) {
    $UserID = $_POST["UserID"];
    $UserName = $_POST["UserName"];
    $UserPW = $_POST["UserPW"];
    $Email = $_POST["Email"];
    $DOB = $_POST["DOB"];
    $ConfirmPassword = $_POST["ConfirmPassword"];

    $error_message = "";

    if ($UserPW !== $ConfirmPassword) {
        echo "<script>alert('Passwords do not match!')</script>";
    } else {
        $stmt = $connection->prepare("INSERT INTO user (UserID, UserName, UserPW, Email, DOB) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $UserID, $UserName, $UserPW, $Email, $DOB);
        
        if ($stmt->execute()) {
            echo "<script>alert('Successful Sign Up')</script>";
        } else {
            echo "<script>alert('Unsuccessful Sign Up: " . $stmt->error . "')</script>";
        }
        echo "<script>window.location='login.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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

        /*SIGN UP*/
        .container {
            background: var(--light-white);
            border-radius:1px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 400px;
            min-height: 380px;
            max-height: 70vh;
            padding: 20px;
            text-align: center;
            margin-top: 50px;
            overflow-y: auto;
        }
        
        .container h1{
            font-family: 'Albert Sans';
            margin-bottom: 20px;
            color: var(--dark-color);
        }

        .container input[type = "text"],
        .container input[type = "email"],
        .container input[type = "password"],
        .container input[type = "date"]{
            width: 360px;
            height: 44px;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid var(--gray-color);
            border-radius: 1px;
            font-size: var(--font-size-n);
        }

        .container label{
            font-family: "Lato", sans-serif;
            display: block;
            text-align: left;
            margin-left: 5%;
            margin-bottom: 5px;
        }

        .container button{
            background-color: var(--primary-color);
            color: var(--white-color);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            font-family:'Times New Roman', Times, serif;
        }

        .container button:hover{
            background-color: var(--secondary-color);
        }

        .error {
            color: var(--red-color);
            margin-bottom: 10px;
        }

        .container a.login{
            color: var(--link-blue-color);
            font-size: 16px;
            text-decoration: underline;
            
        }

        @media (max-width: 768px){
            .container{
                padding: 15px;
            }
        }

        @media (max-width: 480px){
            .container{
                padding: 10px;
            }
        }

        @media (max-width: 320px) {
    .container {
        width: 90%; 
        padding: 10px; 
        overflow-y: auto; 
    }

    .container h1 {
        font-size: var(--font-size-m); 
    }

    .container input[type="text"],
    .container input[type="email"],
    .container input[type="password"],
    .container input[type="date"] {
        width: 100%;
        height: 40px; 
        padding: 8px; 
        font-size: var(--font-size-s); 
    }

    .container button {
        padding: 10px; 
        font-size: var(--font-size-n); 
    }

    .container a.login {
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

<section class="abc">
    <div class="container">
        <form id="signup-form" action="signup.php" method="post">
            <h1>Sign Up</h1>
            <div>
                <label for="UserID">User  ID</label>
                <input type="text" id="UserID" name="UserID" required placeholder="U001">
            </div>
            <div>
                <label for="UserName">Username</label>
                <input type="text" id="UserName" name="UserName" required>
            </div>
            <div>
                <label for="Email">Email</label>
                <input type="email" id="Email" name="Email" required placeholder="example@gmail.com">
            </div>
            <div>
                <label for="UserPW">Password</label>
                <input type="password" id="UserPW" name="UserPW" required>
            </div>
            <div>
                <label for="ConfirmPassword">Confirm Password</label>
                <input type="password" id="ConfirmPassword" name="ConfirmPassword" required>
            </div>
            <div>
                <label for="DOB">Date of Birth</label>
                <input type="date" id="DOB" name="DOB" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <div class="asu"></div>
            <p>Already have an account? <a class="login" href="login.php">Login</a></p>
        </div>
            <p id="error-message"></p>
    </div>
</section>

<script>
    document.getElementById('signup-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const password = document.getElementById('UserPW').value;
        const confirmPassword = document.getElementById('ConfirmPassword').value;
        const errorMessage = document.getElementById('error-message');

        if (password !== confirmPassword) {
            errorMessage.textContent = "Passwords do not match!";
        } else {
            errorMessage.textContent = "";
            this.submit();
        }
    });
</script>
</body>
</html>