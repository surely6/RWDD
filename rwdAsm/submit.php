<?php
session_start();
if (!isset($_SESSION["userID"])) {
    echo '<script>alert("Please Log In"); window.location="landing_page.php";</script>';
    exit();
}
$conn = new mysqli("localhost", "root", "", "mass_spm");
if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}

$totalMark = $_POST["totalMark"];
$timeTaken = $_POST["timeTaken"];
$userID = $_SESSION["userID"];
$QuizID = $_POST["QuizID"];

$minutesTaken = $timeTaken / 60;  

$sql = "SELECT AttemptID FROM user_attempt ORDER BY AttemptID DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    $lastAttemptID = $row['AttemptID'];
    $numberPart = intval(substr($lastAttemptID, 1)); 
    $newNumberPart = $numberPart + 1;  
    
    $newAttemptID = 'A' . str_pad($newNumberPart, 2, '0', STR_PAD_LEFT); 
} else {
    $newAttemptID = 'A01'; //no record saved b4
}

$query = "INSERT INTO user_attempt (AttemptID, UserID, QuizID, AttemptDate, `Timestamp`, Score) 
          VALUES ('$newAttemptID', '$userID', '$QuizID', NOW(), '$minutesTaken', $totalMark)";

if ($conn->query($query) === TRUE) {
    header("Location: user_home.php");
    exit();
} else {
    echo "Error: " . $conn->error . ". Please Try Again";
}

$conn->close();
 
?>
