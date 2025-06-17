<?php
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['status'] !== 'user') {
    header("Location: login.php");
    exit();
}

include('connection.php');

$userID = $_SESSION['userID'];
$sql = "SELECT UserID, UserName, ProfilePicURL, Email, DOB FROM user WHERE UserID = '$userID'";
$result = mysqli_query($connection, $sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

$historyQuery = "
    SELECT 
        ua.AttemptID, 
        q.QuizName, 
        s.SubjectName, 
        ua.Score, 
        ua.AttemptDate,
        q.QuizLevel,
        q.Chapter
    FROM 
        user_attempt ua
    JOIN 
        quiz q ON ua.QuizID = q.QuizID
    JOIN 
        subject s ON q.SubjectID = s.SubjectID
    WHERE 
        ua.UserID = '$userID'
    ORDER BY 
        ua.AttemptDate DESC
";

$historyResult = mysqli_query($connection, $historyQuery);

// Calculate overall progress
$progressQuery = "
    SELECT 
        COUNT(DISTINCT q.SubjectID) AS SubjectsAttempted,
        COUNT(DISTINCT ua.QuizID) AS QuizzesTaken,
        ROUND(AVG(ua.Score), 2) AS AverageScore
    FROM 
        user_attempt ua
    JOIN 
        quiz q ON ua.QuizID = q.QuizID
    WHERE 
        ua.UserID = '$userID'
";
$progressResult = mysqli_query($connection, $progressQuery);
$progress = $progressResult->fetch_assoc();


$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href='https://fonts.googleapis.com/css?family=Albert Sans' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>

</head>
<style>
        body {
            background-image: url('img/background.png');
            font-family: 'Lato', sans-serif;
            margin: 0;
            padding: 80px;
        }

        .container {
            background-color: rgb(171, 190, 118);
            margin: 50px;
            display: flex;
            gap: 20px;
            padding: 20px;
            border-radius: 10px;
        }

        .profile-info {
            flex-grow: 1;
        }

        .edit-link {
            align-self: flex-start;
        }

        .history-container {
            background-color: white;
            margin: 0 50px;
            padding: 20px;
            border-radius: 10px;
        }

        .progress-summary {
            display: flex;
            justify-content: space-around;
            background-color: rgb(230, 240, 200);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
        }

        .history-table th, .history-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .history-table th {
            background-color: rgb(171, 190, 118);
        }

        h1, h2 {
            color: black;
            font-family: 'Albert Sans', sans-serif;
            margin-left: 50px;
        }

        .navbar {
            display: flex;
            background-color: #929572;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            width: 100%;
            height: 60px;
            z-index: 5;
            top: 0;
            left: 0;
            right: 0;
            margin: 0;
            padding: 20px 0px 20px 0px;
        }
                        
        .logo-image {
            width: 120px;
            max-width: 150px;
            height: auto;
        }

        @media screen and (max-width: 768px) {
            body {
            padding: 80px;
        }

        .container {
            margin: 20px;
            padding: 10px;
            flex-direction: column;
            align-items: center;
        }

        .profile-info {
            margin-top: 10px;
        }

        .history-container {
            margin: 20px;
            padding: 10px;
        }

        .progress-summary {
            flex-direction: column;
            align-items: center;
        }

        .history-table th, .history-table td {
            padding: 6px;
        }

        .navbar {
            padding: 10px 0;
        }
        }

        @media screen and (max-width: 480px) {
        body {
            padding: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        .container {
            margin: 0px;
            padding: 10px;
            flex-direction: column;
            align-items: center;
            width: 90%;
        }

        .profile-info {
            margin-top: 10px;
            font-size: 14px;
        }

        .history-container {
            margin: 10px;
            padding: 5px;
        }

        .progress-summary {
            flex-direction: column;
            align-items: center;
            font-size: 14px;
        }

        .history-table th, .history-table td {
            padding: 4px;
        }

        .navbar {
            padding: 5px 0;
        }
        }

        @media screen and (max-width: 320px) {
        body {
            padding: 60px;
            font-size: 12px;
        }

        .container {
            width: 90%; 
            height: auto;
            margin: 5px;
            padding: 5px;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .profile-info {
            margin-top: 10px;
            font-size: 10px;
        }

        .history-container {
            margin: 5px;
            padding: 5px;
            overflow-x: auto; 
        }

        .progress-summary {
            flex-direction: column; 
            align-items: center;
            font-size: 10px; 
            margin-bottom: 10px;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 300px; 
        }

        .history-table th, .history-table td {
            padding: 3px; 
            font-size: 10px;
            text-align: left;
        }
        }

</style>
<body>
<header>
    <nav class="navbar">
        <a href="user_home.php" class="nav-logo" section-content>
            <img src="img/logo.png" alt="MASS SPM logo" class="logo-image">
        </a>
    </nav>
</header>

    <div class="container">
        <!-- Profile Picture -->
        <img src="<?= htmlspecialchars($user['ProfilePicURL'] ?: 'img/default-profile.png') ?>" alt="Profile Picture" width="100" height="100">

        <!-- User Information -->
        <div class="profile-info">
            <p>
                User ID: <?= htmlspecialchars($user['UserID']) ?><br>
                Username: <?= htmlspecialchars($user['UserName']) ?><br>
                Email: <?= htmlspecialchars($user['Email']) ?><br>
                Date of Birth: <?= htmlspecialchars($user['DOB']) ?>
            </p>
        </div>

        <!-- Edit Profile Link -->
        <div class="edit-link">
            <a href="edit.php" style="color: blue;">Edit Profile</a>
        </div>
    </div>

    <h1>History & Progress</h1>

    <div class="history-container">
        <!-- Progress Summary -->
        <div class="progress-summary">
            <div>
                <strong>Subjects Attempted:</strong> 
                <?= htmlspecialchars($progress['SubjectsAttempted'] ?? 0) ?>
            </div>
            <div>
                <strong>Quizzes Taken:</strong> 
                <?= htmlspecialchars($progress['QuizzesTaken'] ?? 0) ?>
            </div>
            <div>
                <strong>Average Score:</strong> 
                <?= htmlspecialchars($progress['AverageScore'] ?? '0.00') ?>%
            </div>
        </div>

        <!-- Quiz History Table -->
        <table class="history-table">
            <thead>
                <tr>
                    <th>Quiz Name</th>
                    <th>Subject</th>
                    <th>Level</th>
                    <th>Chapter</th>
                    <th>Score</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($historyResult->num_rows > 0): ?>
                    <?php while ($attempt = $historyResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($attempt['QuizName']) ?></td>
                            <td><?= htmlspecialchars($attempt['SubjectName']) ?></td>
                            <td><?= htmlspecialchars($attempt['QuizLevel']) ?></td>
                            <td><?= htmlspecialchars($attempt['Chapter']) ?></td>
                            <td><?= htmlspecialchars($attempt['Score']) ?>%</td>
                            <td><?= htmlspecialchars($attempt['AttemptDate']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No quiz history found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>