<?php

include("connect.php");

$sql = "SELECT * FROM quiz;";
$result = $conn->query($sql);

$quiz = null;

if (isset($_GET["quizid"])) {
    $quizid = $_GET["quizid"];
} else {
    echo "<br><center>Quiz ID not provided.</center>";
    exit();
}

if (isset($_POST["submit"])) {
    // Delete all questions associated with the quiz
    $deleteQuestionsSql = "DELETE FROM question WHERE QuizID = '$quizid'";
    $deleteQuestionsResult = mysqli_query($conn, $deleteQuestionsSql);

    if (!$deleteQuestionsResult) {
        echo "<br><center>Error deleting related questions: " . mysqli_error($conn) . "</center>";
        exit();
    }

    // Now delete the quiz
    $deleteSql = "DELETE FROM quiz WHERE QuizID = '$quizid'";
    $deleteResult = mysqli_query($conn, $deleteSql);

    if ($deleteResult) {
        $bilrekod = mysqli_affected_rows($conn);
        if ($bilrekod > 0) {
            echo "<br><center>Quiz delete successful</center>";
            header("Location: adminIndex.php");
            exit();
        } else {
            echo "<br><center>Quiz delete unsuccessful</center>";
        }
    } else {
        echo "<br><center>Error: $deleteSql<br>" . mysqli_error($conn) . "</center>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Quiz</title>
    <style>
        .delete-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .delete-form table {
            width: 100%;
        }
        
        .delete-form input {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
        }
        
        .delete-button {
            width: 100%;
            padding: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .delete-button:hover {
            background-color: #c82333;
        }

        .back-button {
            width: 100%;
            padding: 10px;
            background-color: #6c757d;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .back-button:hover {
            background-color: #5a6268;
        }

        body{
            background: url('img/background.png') no-repeat;
            min-height: 100vh;
            height: auto;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="delete-form">
        <h3 class="delete">DELETE QUIZ</h3>
        <h5>Are you sure to delete this quiz?</h5>
        <form class="delete" action="" method="post">
            <button 
                class="delete-button" 
                type="submit" 
                name="submit"
            >
                Yes
            </button>
        </form>
        <button class="back-button" type="submit" onclick="window.location='adminIndex.php'">No</button>
    </div>
</body>
</html>