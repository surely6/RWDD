<?php 
include("connect.php");

$sql = "SELECT * FROM quiz;";
$result = $conn->query($sql); // Fetch all quizzes
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Grid</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .quiz-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            margin-top: 55px;
        }
        .quiz-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            background-color: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        .quiz-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }
        .quiz-card img {
            max-width: 100px;
            margin-bottom: 15px;
        }
        .quiz-card h3 {
            font-size: 18px;
            color: #333;
        }
        .quiz-card p {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }
        .quiz-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .edit-button {
            width: 30px;
            height: auto;
            margin-top: 10px;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
        .no-quizzes {
            text-align: center;
            padding: 50px;
            font-size: 18px;
            color: #888;
        }

        /* Add these message styles */
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 300px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .quiz-card {
                padding: 15px;
            }
            .quiz-card h3 {
                font-size: 16px;
            }
            .quiz-card p {
                font-size: 12px;
            }
        }

        /* Modal styles */
        #confirmDeleteModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        #confirmDeleteModal div {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const message = document.querySelector('.message');
            if (message) {
                setTimeout(() => {
                    message.style.transition = 'opacity 0.5s';
                    message.style.opacity = 0;
                    setTimeout(() => message.remove(), 500);
                }, 3000);
            }

            document.getElementById('cancelDelete').onclick = function() {
                document.getElementById('confirmDeleteModal').style.display = 'none'; 
            };

            document.getElementById('confirmDelete').onclick = function() {
                window.location.href = 'deletequiz.php?quizid=' + quizIdToDelete;
            };
        });

        let quizIdToDelete;

        function showConfirmDeleteModal(quizId) {
            quizIdToDelete = quizId; 
            document.getElementById('confirmDeleteModal').style.display = 'flex'; 
        }
    </script>
</head>
<body>
<?php

    if (isset($_SESSION['message'])) {
        $messageType = $_SESSION['message_type'] ?? 'info';
        echo "<div class='message {$messageType}'>" . htmlspecialchars($_SESSION['message']) . "</div>";
        
        // Clear the message
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
?>
    <div class="quiz-grid">
        <?php 
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { // Loop through each quiz row
        ?>
        <section class="quiz-card">
            <div class="quiz-actions">
                <a href="viewpage.php?quizid=<?php echo $row['QuizID']; ?>">
                    <img src="images/eye.png" alt="Edit Quiz" class="edit-button">
                </a>
                <button class="delete-button" onclick="window.location='deletequiz.php'">
                <a href="deletequiz.php?quizid=<?php echo $row['QuizID']; ?>" style="
                        color: white;
                        text-decoration: none;
                        font-style: none;
                    ">
                    Delete
                </a>
                </button>
            </div>
            <h3><?php echo htmlspecialchars($row["QuizName"]); ?></h3>
            <p>
                <strong>Quiz ID:</strong> <?php echo htmlspecialchars($row["QuizID"]); ?><br>
                <strong>Duration:</strong> <?php echo htmlspecialchars($row["Duration"]) === ""? "--": $row["Duration"]. " minutes"; ?><br>
                <strong>Type:</strong> <?php echo htmlspecialchars($row["QuizType"]); ?><br>
                <strong>Level:</strong> <?php echo htmlspecialchars($row["QuizLevel"]); ?><br>
                <strong>Chapter:</strong> <?php echo htmlspecialchars($row["Chapter"]) === ""? "--": $row["Chapter"]; ?>
            </p>
        </section>
        <?php 
            }
        } else {
            echo "<div class='no-quizzes'>No quizzes found. Add a new quiz to get started!</div>";
        }
        ?>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmDeleteModal">
        <div>
            <h3>Are you sure you want to delete this quiz?</h3>
            <button id="confirmDelete" style="background-color:#dc3545; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">Confirm Delete</button>
            <button id="cancelDelete" style="background-color:#6c757d; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">Close</button>
        </div>
    </div>

</body>
</html>