<?php
session_start();
if (!isset($_SESSION["userID"])) {
    echo '<script>alert("Please Log In"); window.location="landing_page.php";</script>';
    exit();
}

include("connect.php");

// Fetch subjects for the dropdown
$subjects_sql = "SELECT * FROM subject";
$subjects_result = $conn->query($subjects_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add Quiz</title>
    <style>
        .quiz-form, .question-form {
            display: flex;
            flex-direction: column;
            max-width: 50%;
            margin: 0 auto;
        }

        .quiz-form input, .quiz-form select, .question-form input, .question-form select {
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            max-width: -webkit-fill-available;

        }

        .quiz-form button, .question-form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .quiz-form button:hover, .question-form button:hover {
            background-color: #0056b3;
        }

        .add-question-btn {
            padding: 8px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-question-btn:hover {
            background-color: #218838;
        }

        .question-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            background-color: #c5d4a1;
            margin-bottom: 35px;
        }

        .options-container {
            margin-top: 10px;
        }

        .option-input {
            margin-bottom: 5px;
        }

        .option .dltOptionBtn, .question-card .dltQuesBtn{
            background-color:#f04e4e ;
        }

        .backBtn{
            position: absolute;
            left: 1%;
            background-color: #b9c19a;
            border: none;
            border-radius: 10px;
            padding: 10px;
            width: 10%;
            min-width: fit-content;
        }

        .backBtn:hover{
            cursor: pointer;
            background-color: #cbcb8d;
        }

    </style>
</head>
<body>

    <h1>Add a New Quiz</h1>
    <button type ="button" class="backBtn" onclick="window.location='adminIndex.php'">Back</button> <br><br>

    <form class="quiz-form" action="addSubmission.php" method="POST">
        <label for="quizname">Quiz Name:</label>
        <input type="text" name="quizname" id="quizname" placeholder="Enter quiz name" required>

        <label for="duration">Duration (in minutes):</label>
        <input type="number" name="duration" id="duration" placeholder="Enter duration" required>

        <label for="quiztype">Quiz Type:</label>
        <select name="quiztype" id="quiztype" required>
            <option value="CHAPTER">CHAPTER</option>
            <option value="PAST YEAR">PAST YEAR</option>
        </select>

        <label for="quizlevel">Quiz Level:</label>
        <select name="quizlevel" id="quizlevel" required>
            <option value="FORM4">FORM4</option>
            <option value="FORM5">FORM5</option>
        </select>

        <label for="chapter">Chapter:</label>
        <input type="number" name="chapter"  id="chapter" placeholder="Enter chapter number">

        <label for="subjectid">Subject:</label>
        <select name="subjectid"  id="subjectid" required>
            <?php while ($subject = $subjects_result->fetch_assoc()) { ?>
                <option value="<?php echo $subject['SubjectID']; ?>"><?php echo htmlspecialchars($subject['SubjectName']); ?></option>
            <?php } ?>
        </select>

        <h3>Add Questions for the Quiz</h3>
        <div id="question-container">
            <div class="question-card" id = "question[0]">
                <h3> Question 1 </h3>
                Question Text: <br>
                <textarea name="questions[0][questiontext]" placeholder="Enter question text" required></textarea><br><br>

                Question Mark: <br>
                <input type="number" name="questions[0][questionmark]" placeholder="Enter question marks" min="1" required><br><br>
                
                Explanation: <br>
                <textarea id="explanation" name="questions[0][explanation]" placeholder="Enter explanation" required></textarea><br><br>

                Question Type: <br>
                <select id="questiontype" name="questions[0][questiontype]" required>
                    <option value="MCQ">MCQ</option>
                    <option value="TRUE/FALSE">True/False</option>
                    <option value="CHECKBOX">Checkbox</option>
                </select><br>

                <div class="options-container" id="options-container-0">
                <h4>Options: </h4>

                <div class="option" id="option-0-1">
                Option Text: <br>
                    <input type="text" name="questions[0][options][0][optionPrompt]" class="option-input"  required>
                Is Correct: 
                    <input type="checkbox" name = "questions[0][options][0][isCorrect]" value="0" class="isCorrect-0"><br><br>
                </div>

                <div class="option" id="option-0-2">
                    Option Text: <br>
                    <input type="text" name="questions[0][options][1][optionPrompt]" class="option-input"  required>
                    Is Correct: 
                <input type="checkbox" name="questions[0][options][1][isCorrect]" value="0" class="isCorrect-0"><br><br> <!-- value=0 when submit even tho unchecked still have 0 submitted-->
                </div>
                 
            </div>
             <button type="button" onclick="addOption(0)">Add Another Option</button>   
               
            </div>
        </div> 
        <button type="button" class="add-question-btn" id="add-question-btn">+ Extra Question</button><br> <br> <br> <br>
        <button type="submit" style="background-color: #28a745;">Submit Quiz</button>
    </form>

    <script>
        let questionIndex = 1;

        // Function to add a new question form dynamically
        document.getElementById('add-question-btn').addEventListener('click', function() {
        const questionContainer = document.getElementById("question-container");
        
        const newQuestion = `
            <div class="question-card" id="question-${questionIndex}">
                <h3> Question ${questionIndex + 1} </h3>
                Question Text: <br>
                <textarea name="questions[${questionIndex}][questiontext]" placeholder="Enter question text" required></textarea><br><br>

                Question Mark: <br>
                <input type="number" name="questions[${questionIndex}][questionmark]" placeholder="Enter question marks" min="1" required><br><br>

                Explanation: <br>
                <textarea name="questions[${questionIndex}][explanation]" placeholder="Enter explanation" required></textarea><br><br>

                Question Type: <br>
                <select name="questions[${questionIndex}][questiontype]" required>
                    <option value="MCQ">MCQ</option>
                    <option value="TRUE/FALSE">True/False</option>
                    <option value="CHECKBOX">Checkbox</option>
                </select><br>

                <div class="options-container" id="options-container-${questionIndex}">
                    <h4>Options: </h4>

                    <div class="option" id="option-${questionIndex}-1">
                        Option Text: <br>
                        <input type="text" name="questions[${questionIndex}][options][0][optionPrompt]" class="option-input" required>
                        Is Correct: 
                        <input type="checkbox" name="questions[${questionIndex}][options][0][isCorrect]" value="0"><br><br>
                    </div>

                    <div class="option" id="option-${questionIndex}-2">
                        Option Text: <br>
                        <input type="text" name="questions[${questionIndex}][options][1][optionPrompt]" class="option-input" required>
                        Is Correct: 
                        <input type="checkbox" name="questions[${questionIndex}][options][1][isCorrect]" value="0"><br><br>
                    </div>
                    </div>
                    <button type="button" onclick="addOption(${questionIndex})">Add Another Option</button> <br>
                    <button type="button"  class = "dltQuesBtn" onclick="deleteQuestion(${questionIndex})">Delete Question</button>
                    </div>
                    `;
                    questionContainer.insertAdjacentHTML("beforeend", newQuestion);

                    questionIndex++; 
                    });

                    function addOption(questionIndex){
                        const optionContainer = document.getElementById(`options-container-${questionIndex}`);
                        const optionCount = optionContainer.getElementsByClassName("option").length + 1;

                        const optionContent= `
                            <div class="option" id="option-${questionIndex}-${optionCount}">
                                Option Text: <br>
                                <input type="text" name="questions[${questionIndex}][options][${optionCount}][optionPrompt]" class="option-input" required>
                                Is Correct: 
                                <input type="checkbox" name="questions[${questionIndex}][options][${optionCount}][isCorrect]" class="isCorrect-${questionIndex}" value="0">
                                <button type="button"  class="dltOptionBtn" onclick="deleteOption(${questionIndex}, ${optionCount})">Delete Option</button><br><br>
                            </div>
                        `;
                        optionContainer.insertAdjacentHTML("beforeend", optionContent);
                    }

                    function deleteOption(questionIndex, optionCount){
                        const optionContainer = document.getElementById(`option-${questionIndex}-${optionCount}`);
                        optionContainer.remove();
                    }

                    function deleteQuestion(questionIndex) {
                        const questionContainer = document.getElementById(`question-${questionIndex}`);
                        questionContainer.remove();
                        updateIndex();
                    }

                    //adjust the index accordingly cuz remove action happened, avoid misconfusion in submission later
                    function updateIndex() {
                        const questions = document.getElementsByClassName("question-card");
                        
                        for (let i = 0; i < questions.length; i++) {
                            const question = questions[i];
                            
                            question.querySelector('h3').innerText = `Question ${i + 1}`;
                            question.id = `question-${i}`;
                            const questionTextInput = question.querySelector('textarea[name^="questions"]');
                            questionTextInput.name = `questions[${i}][questiontext]`;

                            const questionMarkInput = question.querySelector('input[name^="questions"][placeholder="Enter question marks"]');
                            questionMarkInput.name = `questions[${i}][questionmark]`;

                            const explanationTextarea = question.querySelector('textarea[name^="questions"][placeholder="Enter explanation"]');
                            explanationTextarea.name = `questions[${i}][explanation]`;

                            const questionTypeSelect = question.querySelector('select[name^="questions"]');
                            questionTypeSelect.name = `questions[${i}][questiontype]`;

                            const optionsContainer = question.querySelector(".options-container");
                            optionsContainer.id = `options-container-${i}`;

                            const options = optionsContainer.getElementsByClassName("option");
                            for (let j = 0; j < options.length; j++) {
                                const option = options[j];
                                option.id = `option-${i}-${j + 1}`;

                                const optionTextInput = option.querySelector('input[name^="questions"][class="option-input"]');
                                optionTextInput.name = `questions[${i}][options][${j}][optionPrompt]`;

                                const isCorrectCheckbox = option.querySelector('input[type="checkbox"]');
                                isCorrectCheckbox.name = `questions[${i}][options][${j}][isCorrect]`;
                                isCorrectCheckbox.classList.remove(`isCorrect-${questionIndex}`);
                                isCorrectCheckbox.classList.add(`isCorrect-${i}`);
                            }

                            const addOptionButton = question.querySelector('button[onclick^="addOption"]');
                            if (addOptionButton) {
                                addOptionButton.setAttribute('onclick', `addOption(${i})`);
                            }

                            const deleteQuestionButton = question.querySelector('button[onclick^="deleteQuestion"]');
                            if (deleteQuestionButton) {
                                deleteQuestionButton.setAttribute('onclick', `deleteQuestion(${i})`);
                            }
                        }

                        questionIndex = questions.length;
                    }

                    //check each answer has at least one correct option, and mcq & t/f question only allow one correct answer
                    document.querySelector('form').addEventListener('submit', function(event) {
                        let isValid = true;

                        const questions = document.getElementsByClassName("question-card");
                        for (let i = 0; i < questions.length; i++) {
                            const question = questions[i];
                            
                            const questionTypeSelect = question.querySelector('select[name^="questions"][name$="[questiontype]"]');
                            const questionType = questionTypeSelect ? questionTypeSelect.value : null;
                            const optionsContainer = question.querySelector(".options-container");
                            const options = optionsContainer.getElementsByClassName("option");
                            
                            let correctAnswers = 0;

                            for (let j = 0; j < options.length; j++) {
                                const isCorrectCheckbox = options[j].querySelector('input[type="checkbox"]');
                                
                                if (isCorrectCheckbox.checked) {
                                    correctAnswers++;
                                }
                            }

                            if (correctAnswers === 0) {
                                alert("Please choose at least one correct answer :D. Question: " + (i + 1));
                                isValid = false;
                                break; 
                            }

                            if ((questionType === "MCQ" || questionType === "TRUE/FALSE") && correctAnswers > 1) {
                                alert("MCQ and TRUE/FALSE can only have one correct answer :D. Question: " + (i + 1));
                                isValid = false;
                                break; 
                            }
                        }

                        if (!isValid) {
                            event.preventDefault(); //no submit :(
                        }
                    });

    </script>

</body>
</html>
