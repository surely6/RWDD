/*document.addEventListener("DOMContentLoaded", function () {
    let totalMarks = 0; // Variable to keep track of total marks

    // Get all options (radio buttons and checkboxes)
    const options = document.querySelectorAll('.option');

    // Function to update the total marks display
    function updateTotalMarks() {
        document.querySelector('#totalMarks').textContent = `Total Marks: ${totalMarks}`;
    }

    // Handle individual selections for MCQ and TRUE/FALSE types
    options.forEach(option => {
        if (option.type === 'radio') {
            option.addEventListener('change', function () {
                const questionBlock = this.closest('.questionBlock');
                const explanationDiv = questionBlock.querySelector('.explanation');
                const isCorrect = this.getAttribute('data-correct') === 'true';
                const explanation = this.getAttribute('data-explanation');
                const questionMark = parseInt(questionBlock.getAttribute('data-mark')) || 0;

                // If the selected option is correct, add marks to the total
                if (isCorrect) {
                    totalMarks += questionMark;
                    explanationDiv.innerHTML = "<p class='correct'>Correct! " + explanation + "</p>";
                } else {
                    explanationDiv.innerHTML = "<p class='incorrect'>Incorrect. " + explanation + "</p>";
                }

                explanationDiv.style.display = 'block';

                const allOptions = questionBlock.querySelectorAll('input');
                allOptions.forEach(opt => opt.disabled = true);

                // Update the total marks after each answer
                updateTotalMarks();
            });
        }
    });

    // Handle multiple selections for CHECKBOX type
    document.querySelectorAll('.questionBlock').forEach(block => {
        const checkboxes = block.querySelectorAll('input[type="checkbox"]');

        if (checkboxes.length > 0) {
            const submitButton = document.createElement('button');
            submitButton.textContent = "Submit Answer";
            block.appendChild(submitButton);

            submitButton.addEventListener('click', function () {
                const explanationDiv = block.querySelector('.explanation');
                let allCorrect = true;
                let selectedAnswers = 0;
                let correctAnswers = [];
                let questionMark = parseInt(block.getAttribute('data-mark')) || 0;

                checkboxes.forEach(checkbox => {
                    if (checkbox.getAttribute('data-correct') === 'true') {
                        correctAnswers.push(checkbox.value);
                    }

                    if (checkbox.checked) {
                        selectedAnswers++;
                        if (checkbox.getAttribute('data-correct') === 'false') {
                            allCorrect = false;
                        }
                    } else if (checkbox.getAttribute('data-correct') === 'true') {
                        allCorrect = false;
                    }
                });

                if (selectedAnswers === 0) {
                    explanationDiv.innerHTML = "<p class='incorrect'>Please select at least one option.</p>";
                    explanationDiv.style.display = 'block';
                    return;
                }

                if (allCorrect) {
                    totalMarks += questionMark; // Add the question mark to total if correct
                    explanationDiv.innerHTML = "<p class='correct'>Correct! " + checkboxes[0].getAttribute('data-explanation') + "</p>";
                } else {
                    explanationDiv.innerHTML = "<p class='incorrect'>Some of your selections were incorrect. The correct answers are: " + correctAnswers.join(' & ') + ". " + checkboxes[0].getAttribute('data-explanation') + "</p>";
                }

                explanationDiv.style.display = 'block';

                checkboxes.forEach(checkbox => checkbox.disabled = true);
                submitButton.disabled = true;

                // Update the total marks after each answer
                updateTotalMarks();
            });
        }
    });

    // Additional handling for the 'data-mark' attribute on question blocks
    document.querySelectorAll('.questionBlock').forEach(questionBlock => {
        const questionMark = questionBlock.getAttribute('data-mark');
        if (questionMark) {
            console.log(`Question Mark: ${questionMark}`);  // Debugging the mark value
        }
    });
    // Initially display the total marks (should be 0 at start)
    updateTotalMarks();

});*/



