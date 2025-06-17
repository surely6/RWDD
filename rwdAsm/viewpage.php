<?php
include("connect.php");


$sQuizName = $sSubjectName = $sQuizType = $nChapter = $tDuration = $nTotalQuestion = $nTotalMark = "";

if (isset($_GET["quizid"])) {
    $QuizID = $conn->real_escape_string($_GET["quizid"]);

    $sql = "SELECT quiz.QuizName, quiz.Duration, quiz.QuizType, quiz.Chapter, quiz.QuizLevel, COUNT(question.QuestionID) AS TotalQuestion, SUM(question.QuestionMark) AS TotalMark, subject.SubjectName FROM quiz INNER JOIN question ON quiz.QuizID = question.QuizID INNER JOIN subject ON quiz.SubjectID = subject.SubjectID WHERE quiz.QuizID = '$QuizID' GROUP BY quiz.QuizID, quiz.QuizName, quiz.Duration, quiz.QuizType, quiz.Chapter, subject.SubjectName";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {  
        echo "<div class = 'quizInfo'><h2> Quiz Not Available for Now. Stay Tune!</h2></div>"; //in case subject is created but question hvnt added, so they can't go to start quiz page.
        exit;  
    }

    if ($row = $result->fetch_assoc()) {
        $sQuizName = $row["QuizName"];
        $sQuizLevel = $row["QuizLevel"];
        $tDuration = $row["Duration"];
        $sQuizType = $row["QuizType"];
        $nChapter = $row["Chapter"];
        $nTotalQuestion = $row["TotalQuestion"];
        $nTotalMark = $row["TotalMark"];
        $sSubjectName = $row["SubjectName"];
    }
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="quizPage.css">
    <script src="quizPage.js"></script>
    <style>
        body{
            background: url('img/background.png') no-repeat;
            min-height: 100vh;
            height: auto;
            background-size: cover;
        }

        .backBtn{
            width: 10%;
            margin-top: 20px;
            margin-bottom: 20px;
            background-color: #a0a56b;
            border: none;
            border-radius: 10px;
            padding: 10px;
            margin-left: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .backBtn:hover{
            background-color: #d2d4aa;
            cursor:pointer;
        }
    </style>
</head>
<body>
<button type="button" class="backBtn" onclick="window.location.href='adminIndex.php';">Back</button>
    <!-- Quiz Section -->
<div class="quizInfo">
    <?php
    echo "<h2>". $sQuizName . "</h2>";
    echo "<h4>". $sSubjectName .  " Paper " . ucfirst(strtoLower($sQuizType)) . " " . $nChapter ." (" . ucfirst(strtoLower($sQuizLevel)). ")". "</h4>";
    ?>
    <div class="quizDetail">
        <ul>
            <li><svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 7V12L9.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg><?php echo $tDuration === NULL ? '--' : $tDuration; ?></li>
            <li><svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.18 8.03933L18.6435 7.57589C19.4113 6.80804 20.6563 6.80804 21.4241 7.57589C22.192 8.34374 22.192 9.58868 21.4241 10.3565L20.9607 10.82M18.18 8.03933C18.18 8.03933 18.238 9.02414 19.1069 9.89309C19.9759 10.762 20.9607 10.82 20.9607 10.82M18.18 8.03933L13.9194 12.2999C13.6308 12.5885 13.4865 12.7328 13.3624 12.8919C13.2161 13.0796 13.0906 13.2827 12.9882 13.4975C12.9014 13.6797 12.8368 13.8732 12.7078 14.2604L12.2946 15.5L12.1609 15.901M20.9607 10.82L16.7001 15.0806C16.4115 15.3692 16.2672 15.5135 16.1081 15.6376C15.9204 15.7839 15.7173 15.9094 15.5025 16.0118C15.3203 16.0986 15.1268 16.1632 14.7396 16.2922L13.5 16.7054L13.099 16.8391M13.099 16.8391L12.6979 16.9728C12.5074 17.0363 12.2973 16.9867 12.1553 16.8447C12.0133 16.7027 11.9637 16.4926 12.0272 16.3021L12.1609 15.901M13.099 16.8391L12.1609 15.901" stroke="#1C274C" stroke-width="1.5" />
                    <path d="M8 13H10.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M8 9H14.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M8 17H9.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M3 14V10C3 6.22876 3 4.34315 4.17157 3.17157C5.34315 2 7.22876 2 11 2H13C16.7712 2 18.6569 2 19.8284 3.17157M21 14C21 17.7712 21 19.6569 19.8284 20.8284M4.17157 20.8284C5.34315 22 7.22876 22 11 22H13C16.7712 22 18.6569 22 19.8284 20.8284M19.8284 20.8284C20.7715 19.8853 20.9554 18.4796 20.9913 16" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                </svg><?php echo $nTotalQuestion . " Questions" ?></li>
            <li><svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.4 21.75C9.81413 21.75 7.33418 20.7228 5.5057 18.8943C3.67722 17.0658 2.64999 14.5859 2.64999 12C2.64999 9.41414 3.67722 6.93419 5.5057 5.10571C7.33418 3.27723 9.81413 2.25 12.4 2.25C12.5989 2.25 12.7897 2.32902 12.9303 2.46967C13.071 2.61032 13.15 2.80109 13.15 3C13.15 3.19891 13.071 3.38968 12.9303 3.53033C12.7897 3.67098 12.5989 3.75 12.4 3.75C10.212 3.75 8.11354 4.61919 6.56636 6.16637C5.01919 7.71354 4.14999 9.81196 4.14999 12C4.14999 14.188 5.01919 16.2865 6.56636 17.8336C8.11354 19.3808 10.212 20.25 12.4 20.25C13.4932 20.2536 14.5761 20.0377 15.5844 19.6151C16.5927 19.1926 17.5059 18.5719 18.27 17.79C18.4106 17.6481 18.6017 17.5679 18.8015 17.5669C19.0012 17.566 19.1931 17.6444 19.335 17.785C19.4769 17.9256 19.5571 18.1167 19.5581 18.3165C19.559 18.5162 19.4806 18.7081 19.34 18.85C18.4349 19.7715 17.3547 20.5028 16.1629 21.0008C14.971 21.4989 13.6917 21.7536 12.4 21.75Z" fill="#000000" />
                    <path d="M12.1 15.45C12.0015 15.4505 11.9038 15.4312 11.8128 15.3935C11.7218 15.3557 11.6392 15.3001 11.57 15.23L7.56999 11.23C7.43751 11.0878 7.36539 10.8998 7.36881 10.7055C7.37224 10.5112 7.45096 10.3258 7.58837 10.1884C7.72578 10.051 7.91117 9.97225 8.10547 9.96882C8.29977 9.9654 8.48782 10.0375 8.62999 10.17L12.1 13.64L20.1 5.64C20.1687 5.56631 20.2515 5.50721 20.3435 5.46622C20.4355 5.42523 20.5348 5.40318 20.6355 5.40141C20.7362 5.39963 20.8362 5.41816 20.9296 5.45588C21.023 5.4936 21.1078 5.54974 21.179 5.62096C21.2502 5.69218 21.3064 5.77701 21.3441 5.8704C21.3818 5.96379 21.4004 6.06382 21.3986 6.16452C21.3968 6.26522 21.3748 6.36454 21.3338 6.45654C21.2928 6.54854 21.2337 6.63134 21.16 6.7L12.66 15.2C12.5904 15.2798 12.5042 15.3435 12.4075 15.3867C12.3108 15.4298 12.2059 15.4514 12.1 15.45Z" fill="#000000" />
                </svg><?php echo $nTotalMark . " Marks" ?>
            <li>
        </ul>
    </div>
    
</div>

<!-- Overview Quiz Question -->
<div class="quizOverview">
    <?php
        if(isset($_GET["quizid"])){
            $QuizID = $conn->real_escape_string($_GET["quizid"]);

            $sqlOverview = "SELECT question.QuestionID, question.QuestionPrompt, question.QuestionType, question.QuestionMark, answer_option.AnswerPrompt FROM question INNER JOIN answer_option ON question.QuestionID = answer_option.QuestionID WHERE question.QuizID = '$QuizID'";
            $overviewResult = mysqli_query($conn,$sqlOverview);

        $questionLs = [];

        while ($question = $overviewResult->fetch_assoc()) {
            $questionId = $question["QuestionID"];
            
            if(!isset($questionLs[$questionId])){
            $questionLs[$questionId] = [
            "QuestionPrompt" => $question["QuestionPrompt"],
            "QuestionType" => $question["QuestionType"],
            "QuestionMark" => $question["QuestionMark"],
            "optionLs" => []
            ];
            }
            $questionLs[$questionId]["optionLs"][] = $question["AnswerPrompt"];
        }            
    }else{
        die("No quiz found");
    }
    ?>

    <h2>Overview of Question</h2>
    <div class="questionOverview">
            <?php
                $count = 1; //Question Number count
                if(count($questionLs)>0){
                
                foreach($questionLs as $question){
                    if($count <=2){
                    echo "<div class='questionContainer'>";
                    echo "<h3>". "Question " . $count. "</h3>";
                    echo "<div class = 'questionDetail'>";
                    echo "<span class='questionType'>" . $question["QuestionType"].  "</span>";
                    echo "<span class = 'questionMark'>" . $question["QuestionMark"]. " Mark" . "</span>";
                    echo "</div>";

                    echo "<div class ='questionPrompt'>";
                    echo $question["QuestionPrompt"];
                    echo "</div>";

                    echo "<div class = 'answerOption'>";
                    echo "Options: ";
                    echo "<ul>";
                    foreach($question["optionLs"] as $option){
                        echo "<li>".$option."</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                    $count ++;
                    }else{
                        echo "<div class='hiddenQuestionContainer'>";
                    echo "<h3>". "Question " . $count. "</h3>";
                    echo "<div class = 'questionDetail'>";
                    echo "<span class='questionType'>" . $question["QuestionType"].  "</span>";
                    echo "<span class = 'questionMark'>" . $question["QuestionMark"]. " Mark" . "</span>";
                    echo "</div>";

                    echo "<div class ='questionPrompt'>";
                    echo $question["QuestionPrompt"];
                    echo "</div>";

                    echo "<div class = 'answerOption'>";
                    echo "Options: ";
                    echo "<ul>";
                    foreach($question["optionLs"] as $option){
                        echo "<li>".$option."</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                    $count ++;
                    } 
                }
            }else{
                echo "No answer option found.";
            }
            ?>
        </div>
        <div class="shade" id="shade"></div>
        <button id="showMoreBtn" onclick=expandCollapse()>Show More <svg width="10pt" height="10pt" version="1.1" viewBox="0 0 1200 1200" xmlns="http://www.w3.org/2000/svg">
                <path transform="scale(50)" d="m21 8.5-9 9-9-9" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="2" />
            </svg></button>
        
    </div>
</body>
</html>


