<?php
include("connect.php");


if (isset($_GET['search_query'])) {
    $search_query = trim($_GET['search_query']);
    $search_keywords = explode(" ", $search_query); 

    $sql = "SELECT * FROM quiz WHERE ";
    $conditions = [];
    $params = [];
    $types = '';

    foreach ($search_keywords as $keyword) {
        $conditions[] = "QuizName LIKE ?";
        $params[] = "%" . $keyword . "%";
        $types .= 's';
    }

    $sql .= implode(" OR ", $conditions);

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params); 
    $stmt->execute();
    $result = $stmt->get_result();

  
    $quizzes = [];
    while ($row = $result->fetch_assoc()) {
        $quizzes[] = $row;
    }
} else {
    echo "No search query provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Search Results</title>
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
        .edit-delete-container {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 10px;
        }
        #edit-button {
            width: 25px;
            height: 25px;
        }
        .no-quizzes {
            text-align: center;
            padding: 50px;
            font-size: 18px;
            color: #888;
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
    </style>
</head>
<body>
    <nav class="topnav">
        <a href="adminIndex.php" id="logo"><img src="img/logo.png" alt="Mass SPM Logo" class="logo"></a>
        <a href="adminIndex.php"><img src="images/home.png" alt="Go to Home Page" class="icon"></a>
    </nav><br>

    <h1>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h1>

    <?php if (!empty($quizzes)) { ?>
        <div class="quiz-grid">
            <?php foreach ($quizzes as $quiz) { ?>
                <div class="quiz-card">
                    <div class="edit-delete-container">
                        <a href="viewpage.php?quizid=<?php echo $quiz['QuizID']; ?>">
                            <img src="images/eye.png" alt="Edit Quiz" id="edit-button">
                        </a>
                        
                        <button class="delete-button" onclick="window.location='deletequiz.php'">
                        <a href="deletequiz.php?quizid=<?php echo $quiz['QuizID']; ?>" style="
                                color: white;
                                text-decoration: none;
                                font-style: none;
                            ">
                            Delete
                        </a>
                     </button>
                    </div>
                    <h3><?php echo htmlspecialchars($quiz['QuizName']); ?></h3>
                    <p>
                        <strong>Duration:</strong> <?php echo htmlspecialchars($quiz['Duration'])=== ""? "--": $quiz["Duration"]. " minutes"; ?><br>
                        <strong>Level:</strong> <?php echo htmlspecialchars($quiz['QuizLevel']); ?><br>
                        <strong>Chapter:</strong> <?php echo htmlspecialchars($quiz['Chapter']) === ""? "--": $quiz["Chapter"]; ?>
                    </p>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="no-quizzes">No quizzes found matching your search.</p>
    <?php } ?>
</body>
</html>
