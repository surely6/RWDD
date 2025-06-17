<?php
    session_start();

    // Check if the session variables are set for admin
    $adminID = isset($_SESSION['userID']) ? $_SESSION['userID'] : 'N/A';
    $adminUserName = isset($_SESSION['name']) ? $_SESSION['name'] : 'N/A';
    $adminEmail = isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A';  // You need to set the admin's email in the session after login


    if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'admin') {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Home</title>

    <style>
        .add-quiz-button{
            position: absolute;
            width: 50%;
            margin-left: 25%;
            margin-right: 25%;
            padding: 5px;
            border-radius: 10px;
            background-color: #dc923f;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .add-quiz-button:hover{
            cursor: pointer;
            background-color: #dfb877;
        }

        .logoutBtn{
            margin-top: 5px;
            background-color: #cbcb8d;
            border-radius: 10px;
        }

        .logOutBtn:hover{
            cursor: pointer;
        }
        
    </style>
</head>

<body class="box">
    <nav class="topnav">
        <a href="adminIndex.php" id="logo"><img src="img/logo.png" alt="Mass SPM Logo" class="logo"></a>
    
    <form action="search_results.php" method="GET" class="search-form">
        <input type="text" name="search_query" class="search-bar" placeholder="Search Quiz" required>
        <button type="submit" class="search-button">🔍</button>
    </form>

    <button type="button" class="logoutBtn" onclick="window.location='logout.php'">Log Out</button>
        
        <a href="adminIndex.php"><img src="images/home.png" alt="Go to Home Page" class="icon"></a>
    </nav><br>

    <!-- Admin Profile Section -->
    <div class="admin-info-container">
        <h4>Admin Info</h4>
        <p><strong>Admin ID: </strong><?php echo $adminID; ?></p>
        <p><strong>Email: </strong><?php echo $adminEmail; ?></p>
        <p><strong>Admin Name: </strong><?php echo $adminUserName; ?></p>
    </div> 
    
    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="addquiz.php" class="add-quiz-link">
            <button class="add-quiz-button">+ Add Quiz</button>
        </a>
    </div>

    <!-- Quiz Cards -->
    <?php include("quizcard.php"); ?>
   
</body>
</html>