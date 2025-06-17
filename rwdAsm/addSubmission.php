<?php
session_start();

include("connect.php");

$adminId = $_SESSION["userID"];

//Quiz Info (Quiz Table)
$quizName = $_POST["quizname"];
$duration = $_POST["duration"];
$quizType = $_POST["quiztype"];
$quizLevel = $_POST ["quizlevel"];
$chapter = $_POST["chapter"];
$subjectid = $_POST["subjectid"];

//Convert duration into acceptable format
$hours = floor($duration / 60);   
$minutes = $duration % 60;        
$seconds = "00";                          
if ($hours < 10) {
    $hours = "0" . $hours;  
}
if ($minutes < 10) {
    $minutes = "0" . $minutes;  
}
if ($seconds < 10) {
    $seconds = "0" . $seconds;  
}
$convertDuration = $hours . ":" . $minutes . ":" . $seconds;

//Construct QuizID
$sql = "SELECT QuizID FROM quiz ORDER BY QuizID DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    $lastQuizID = $row['QuizID'];
    $numberPart = intval(substr($lastQuizID, 1)); 
    $newNumberPart = $numberPart + 1;  
    
    $newQuizID = 'Q' . str_pad($newNumberPart, 2, '0', STR_PAD_LEFT); 
} else {
    $newQuizID = 'Q01'; //no record saved b4
}

$query = "INSERT INTO quiz (QuizID, SubjectID, Duration, EditAdminID, QuizName, QuizType, QuizLevel, Chapter, CreatedAt, UpdatedAt) 
          VALUES ('$newQuizID', '$subjectid', '$convertDuration', '$adminId', '$quizName', '$quizType', '$quizLevel', '$chapter', NOW(), NOW())";

if ($conn->query($query) === TRUE) {
    $insertSuccess = true;  

//Question Info (Question Table)
foreach($_POST["questions"] as $questNo => $question){
    $questionText = $question["questiontext"];
    $questionMark = $question["questionmark"];
    $explanation = $question["explanation"];
    $questionType = $question["questiontype"];

    
    $sql = "SELECT QuestionID FROM question ORDER BY QuestionID DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $lastQuestionID = $row['QuestionID'];
        $numberPart = intval(substr($lastQuestionID, 2));  
        $newNumberPart = $numberPart + 1;  
        
        $newQuestionID = 'QT' . str_pad($newNumberPart, 2, '0', STR_PAD_LEFT);
    } else {
        $newQuestionID = 'QT01';
    }

    $explanation = mysqli_real_escape_string($conn, $explanation); //avoid . in the last cannot key in

    $query = "INSERT INTO question (QuestionID, QuizID, QuestionPrompt, QuestionType, QuestionMark, ExplanationPrompt, CreatedAt, UpdatedAt) 
            VALUES ('$newQuestionID', '$newQuizID', '$questionText', '$questionType', '$questionMark', '$explanation', NOW(), NOW())";
        

if(mysqli_query($conn,$query)){
    //Option Info (answer_option table)
foreach($question["options"] as $optionNo => $option){
    $optionPrompt = $option["optionPrompt"];
    $isCorrect= isset($option["isCorrect"]) ? 1:0;

    $sql = "SELECT AnswerID FROM answer_option ORDER BY AnswerID DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $lastAnswerID = $row['AnswerID'];
        $numberPart = intval(substr($lastAnswerID, 1)); 
        $newNumberPart = $numberPart + 1;  
        
        $newAnswerID = 'A' . str_pad($newNumberPart, 2, '0', STR_PAD_LEFT); 
    } else {
        $newAnswerID = 'A01'; //no record saved b4
    }

    $query = "INSERT INTO answer_option (AnswerID, QuestionID, AnswerPrompt, IsCorrect, CreatedAt, UpdatedAt) 
          VALUES ('$newAnswerID', '$newQuestionID', '$optionPrompt', '$isCorrect', NOW(), NOW())";

    if ($conn->query($query) !== TRUE) {
        $insertSuccess = false;
        break;
    } 
    }
}else{
    $insertSuccess = false;
    break;
}

}
    if($insertSuccess){
        header("Location: adminIndex.php");
        exit();
    }else{
        echo "Unsucessful quiz add. Please try again.";
        exit();
    }
}else{
    echo "Error: ". mysqli_error($conn);
    exit();
}
?>

