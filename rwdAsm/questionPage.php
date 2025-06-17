<?php
session_start();
if (!isset($_SESSION["userID"])) {
    echo '<script>alert("Please Log In"); window.location="landingPage.php";</script>';
    exit();
}

include("connection.php");

$questionLs = [];

if (isset($_POST["QuizID"])) {
    $QuizID = $connection->real_escape_string($_POST["QuizID"]);

    $questResult = $connection->query("SELECT q.QuestionID, q.QuestionPrompt, q.QuestionType, q.QuestionMark, q.ExplanationPrompt, a.AnswerPrompt, a.IsCorrect FROM question q INNER JOIN answer_option a ON q.QuestionID = a.QuestionID WHERE q.QuizID = '$QuizID'");

    while ($question = $questResult->fetch_assoc()) {
        $questionId = $question["QuestionID"];

        if (!isset($questionLs[$questionId])) {
            $questionLs[$questionId] = [
                "QuestionPrompt" => $question["QuestionPrompt"],
                "QuestionType" => $question["QuestionType"],
                "QuestionMark" => $question["QuestionMark"],
                "ExplanationPrompt" => $question["ExplanationPrompt"],
                "optionLs" => []
            ];
        }
        $questionLs[$questionId]["optionLs"][] = [
            "AnswerPrompt" => $question["AnswerPrompt"],
            "IsCorrect" => $question["IsCorrect"] 
        ]; 
    }
} else {
    die("No quiz found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Question</title>
    <link rel="stylesheet" href="navBar.css">
    <link rel="stylesheet" href="questionPage.css">
    
</head>
<body>
<div id="result"></div>
<main>

<div class="questionContainer">
    <div class="timer" id="timer">Time: 00:00</div>
<?php
$count = 1; 
foreach ($questionLs as $question) {
    echo "<div class='questionBlock' id='question$count' data-mark='" . $question["QuestionMark"] . "'>";
    
    echo "<h3>Question " . $count . "</h3>";
    
    echo "<div class='questionPrompt'>";
    echo $question["QuestionPrompt"];
    echo "<span class='questionMark'>" . $question["QuestionMark"] . " Mark</span>";
    echo "</div>";

    echo "<div class='answerOption'><ul>";

    if ($question["QuestionType"] == "MCQ") {
        foreach ($question["optionLs"] as $option) {
            $isCorrect = $option['IsCorrect'] ? 'true' : 'false'; 
            echo "<li>";
            echo "<input type='radio' name='question$count' value='" . $option['AnswerPrompt'] . "' data-correct='$isCorrect' data-explanation='" . $question["ExplanationPrompt"] . "'class='option'>";
            echo $option['AnswerPrompt'];
            echo "</li>";
        }
    } elseif ($question["QuestionType"] == "TRUE/FALSE") {
        foreach ($question["optionLs"] as $option) {
            $isCorrect = $option['IsCorrect'] ? 'true' : 'false';
            echo "<li>";
            echo "<input type='radio' name='question$count' value='" . $option['AnswerPrompt'] . "' data-correct='$isCorrect' data-explanation='" . $question["ExplanationPrompt"] . "'class='option'>";
            echo $option['AnswerPrompt'];
            echo "</li>";
        }
    } elseif ($question["QuestionType"] == "CHECKBOX") {
        foreach ($question["optionLs"] as $option) {
            $isCorrect = $option['IsCorrect'] ? 'true' : 'false';
            echo "<li>";
            echo "<input type='checkbox' name='question" . $count . "[]' value='" . $option['AnswerPrompt'] . "' data-correct='$isCorrect' data-explanation='" . $question["ExplanationPrompt"] . "'class='option'>";
            echo $option['AnswerPrompt'];
            echo "</li>"; 
        }echo "<button type ='button'  class= 'cboxBtn' id='confirmBtn$count'> Confirm </button>";
    }
    echo "</ul></div>"; 

    echo "<div id='explanation$count' class='explanation' style='display:none;'>";
    echo "</div>";
    echo "</div>"; 
    $count++;
}echo "<button type = 'button' class='doneBtn' id='resultBtn'>Done </button>";
?>



<script>
var totalMark = 0;
var correctQuestionCount = 0;
var questionCount = <?php echo COUNT($questionLs);?>;
var startTime = Date.now();
const timerContainer = document.getElementById("timer");



function updateTimer(){
    durationTaken = (Date.now() - startTime)  
    const minutes = Math.floor(durationTaken / 60000);
    const seconds = Math.floor((durationTaken % 60000) / 1000);
    timerContainer.textContent = `Time: ${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
}

const timer = setInterval(updateTimer,1000);

document.getElementById("resultBtn").addEventListener("click", function(){
    clearInterval(timer);
    const resultContainer = document.getElementById("result");
    resultContainer.innerHTML = `
            <div class="quizDetails">
                <span class= complete>Completed!</span>
                <ul>
                    <li><span>Total Marks:</span> ${totalMark}</li>
                    <li>Total Correct Questions: ${correctQuestionCount}</li>
                    <li>${timerContainer.textContent}</li>
                </ul>
                <button type = "submit" id="backBtn"> Back </button>
            </div>
        `;
        //get element for later submit purpose
        document.getElementById("backBtn").addEventListener("click", function() {
        
        document.getElementById("totalMark").value = totalMark;
        document.getElementById("timeTaken").value = durationTaken;

        document.getElementById("submitForm").submit();
    });
});




document.querySelectorAll('.option').forEach(input => {
    input.addEventListener('click', function(event) {
        const clickedInput = event.target;
        const isCorrect = clickedInput.getAttribute('data-correct') === "true";
        const explanation = clickedInput.getAttribute('data-explanation');
        const parentQuestion = clickedInput.closest('.questionBlock');
        const questionMark = parentQuestion.getAttribute('data-mark');
        const parentLi = clickedInput.closest("li");

        console.log(questionMark);

        // MCQ & T/F
        if (clickedInput.type === "radio") {
            const name = clickedInput.name;
            document.querySelectorAll(`input[name='${name}']`).forEach(radio => {
                if (radio !== clickedInput) {
                    radio.disabled = true;
                }
            });
            const questionId = parentQuestion.id;
            const explanationBox = document.getElementById(`explanation${questionId.replace('question', '')}`);
            if (isCorrect) {
                totalMark += parseInt(questionMark);
                correctQuestionCount += 1;
                parentLi.style.backgroundColor = "#3d933d";
                explanationBox.innerHTML = "<span class= 'correctHint' style='color:#298c15'>Correct! </span>";
            } else {
                parentLi.style.backgroundColor = "#ee2e2e";
                const options = parentQuestion.querySelectorAll('.option');
                options.forEach(option => {
                    const isCorrectAnswer = option.getAttribute('data-correct') === "true";
                    const optionParentLi = option.closest('li');
                    if (isCorrectAnswer) {
                        optionParentLi.style.backgroundColor = "#3d933d";
                    }
                });
                explanationBox.innerHTML = "<span  class='correctHint' style='color:#ff0000'>Wrong.. </span>";
            }
            explanationBox.style.display = "flex";
            explanationBox.innerHTML += `<br>${explanation}`;

        } else if (clickedInput.type === 'checkbox') { // Checkbox Question
    const questionId = parentQuestion.id.replace('question', '');
    const confirmBtn = document.getElementById(`confirmBtn${questionId}`);
    confirmBtn.addEventListener("click", afterConfirm);

    function afterConfirm() {
        const name = clickedInput.name;
        let allCorrect = true; 
        let hasAnsweredCorrectly = parentQuestion.getAttribute('data-answered') === "true"; 

        if (hasAnsweredCorrectly) {
            return; 
        }

        const explanationBox = document.getElementById(`explanation${questionId}`);
        document.querySelectorAll(`input[name='${name}']`).forEach(checkbox => {
            if (checkbox !== clickedInput) {
                checkbox.disabled = true; 
            }
            if (checkbox.getAttribute("data-correct") === 'true') {
                if (!checkbox.checked) {
                    allCorrect = false; 
                }
            } else if (checkbox.checked) {
                allCorrect = false; 
            }
        });

        document.querySelectorAll(`input[name='${name}']`).forEach(checkbox => {
            const optionParentLi = checkbox.closest('li');
            if (checkbox.getAttribute("data-correct") === 'true') {
                optionParentLi.style.backgroundColor = "#3d933d"; 
            } else if (checkbox.checked) {
                optionParentLi.style.backgroundColor = "#ee2e2e"; 
            }
        });

        if (allCorrect) {
            totalMark += parseInt(questionMark);
            correctQuestionCount += 1;
            parentQuestion.setAttribute('data-answered', "true");
            explanationBox.innerHTML = "<span style='color:#32d232'>Correct! </span>";
        } else {
            explanationBox.innerHTML = "<span style='color:#ff0000' class='correctHint'>Wrong.. </span>";
        }
        explanationBox.style.display = "flex";
        explanationBox.innerHTML += `<br>${explanation}`;
    }
}

    });
});


</script>
</div>

</main>
<!-- pass quiz result to php -->
<form id="submitForm" action="submit.php" method="POST" style="display:none;">
    <input type="hidden" name="totalMark" id="totalMark">
    <input type="hidden" name="timeTaken" id="timeTaken">
    <input type="hidden" name="QuizID" id="QuizID" value="<?php echo $QuizID; ?>"> 
    <input type="hidden" name="userID" id="userID" value="<?php echo $_SESSION['userID']; ?>"> 
</form>

<?php
$connection->close();
?>

</body>
</html>