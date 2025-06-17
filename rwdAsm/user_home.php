<?php
ob_start();
session_start();
if(!isset($_SESSION["userID"])){
    echo '<script>alert("Please Log In"); window.location="landingPage.php";</script>';
    exit();
}
include('connection.php');

$subjects = mysqli_query($connection, "SELECT DISTINCT SubjectID FROM quiz");
$quizzes = mysqli_query($connection, "SELECT * FROM quiz");
$quizTypes = mysqli_query($connection, "SELECT DISTINCT QuizType FROM quiz");

$quizTypesArray = [];
$tempQuizTypes = mysqli_query($connection, "SELECT DISTINCT QuizType FROM quiz");
while ($type = mysqli_fetch_assoc($tempQuizTypes)) {
    $quizTypesArray[] = $type['QuizType'];
}
?>

<?php
$selectedSubject = isset($_GET['subject']) ? $_GET['subject'] : 'All';
$selectedType = isset($_GET['type']) ? $_GET['type'] : 'All';

$baseQuery = "SELECT q.*, s.Description, s.SubjectName 
              FROM quiz q
              JOIN subject s ON q.SubjectID = s.SubjectID
              WHERE 1=1";


if ($selectedType !== 'All') {
    $baseQuery .= " AND q.QuizType = '" . mysqli_real_escape_string($connection, $selectedType) . "'";
}
if ($selectedSubject !== 'All') {
    $baseQuery .= " AND s.SubjectName = '" . mysqli_real_escape_string($connection, $selectedSubject) . "'";
}

$countQuery = str_replace("q.*, s.Description, s.SubjectName", "COUNT(*) as total", $baseQuery);
$countResult = mysqli_query($connection, $countQuery);
$totalQuizzes = mysqli_fetch_assoc($countResult)['total'];

$itemsPerPage = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$needPagination = $totalQuizzes > $itemsPerPage;

$totalPages = ceil($totalQuizzes / $itemsPerPage);

$finalQuery = $baseQuery . " LIMIT $offset, $itemsPerPage";
$quizzes = mysqli_query($connection, $finalQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Homepage</title> 
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
        .albert-sans{
            font-family: "Albert Sans", sans-serif;
        }
        
        .lato{
            font-family: "Lato", sans-serif;
        }

        *{
            margin: 0;
            box-sizing: border-box; 
            scroll-behavior:smooth ;
        }

        :root{
        --white-color: #fff;
        --dark-color: #252525;
        --primary-color: #929572;
        --secondary-color: #b9c19a;
        --light-pink-color: #faf4f5;
        --light-yellow: #d3d4c0;
        --light-white: #ecf0f1;
        --gray-color: #cccccc;
        --dark-gray-color: #444444;
        --dark-white: #f0f0f0;
        --light-gray: #dddddd;
        --link-blue-color: #0000ee;
        --red-color: #ff0000;

        --font-size-xs: 0.75rem;
        --font-size-s: 0.9rem;
        --font-size-n: 1rem;
        --font-size-m: 1.12rem;
        --font-size-l: 1.5rem;
        --font-size-xl: 2rem;
        --font-size-xxl: 2.3rem;
        --font-size-xxxl: 3rem;

        --font-weight-normal: 400;
        --font-weight-medium: 500;
        --font-weight-semibold: 600;
        --font-weight-bold: 700;

        --border-radius-s: 8px;
        --border-radius-m: 30px;
        --border-radius-circle: 50%;

        --site-max-width: 1300px;
        }

        body {
            background-image: url('img/background.png'); 
            min-height: 100vh;
            background-size: cover;
            background-position: center;
            margin-top: 80px;
            max-width: 100%;
            overflow-x: hidden;
        }

/* Navigation Bar */
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
                
.navbar .logo {
    width: 120px;
    max-width: 150px;
    height: auto;
}

.searchContent {
    display: flex;
    flex-direction: row;
    flex-basis: 60%;
    padding-left: 20px;
    padding-right: 20px;
    justify-content: center;
}

.searchContent form {
    display: flex;
    flex-grow: 1;
}

/* Dropdown */
.navbar .dropdown {
    position: relative;
    display: flex;
    background-color: #b9c19a93;
    border-radius: 25px 0px 0px 25px;
    width:max-content;
    padding-right: 10px;
    padding-left: 10px;
    max-width: 160px;
    height: 40px;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.navbar .dropdown svg {
    padding-left: 5px;
}

.navbar .dropContent {
    display: none;
    overflow: auto;
    z-index: 2;
    background-color: #b9c19a;
    flex-direction: column;
    position: absolute;
    top: 100%;
    width: 100%;
    box-sizing: border-box;
    border-radius: 10px;
    max-height: 200px;
}

::-webkit-scrollbar{
    width: 8px;
}

::-webkit-scrollbar-thumb{
    background-color: #929572;
    border-radius: 10px;
}
::-webkit-scrollbar-track{
    border-radius: 10px;
}

.dropContent a {
    color: black;
    display: block;
    padding: 10px;
    text-decoration: none;
}

/* hover effect */
.dropdown:hover .dropContent, .profileDropdown:hover .profileDropContent {
    display: flex;
}

.dropdown:hover, .dropElement:hover, .profileDropElement:hover, .searchResult li:hover {
    background-color: #cacb8d;
}

/* Search */
.searchContainer {
    display: flex;
    position: relative;
    flex-direction: row;
    height: 40px;
    max-height: 40px;
    background: #f1f1f1;
    border: 1px solid grey;
    border-radius: 0px 20px 20px 0px;
    flex-grow: 1;
}

.searchBar {
    padding-left: 10px;
    font-size: 17px;
    flex-grow: 3;
    background: none;
    border: none;
}

.searchButton {
    background: none;
    border: none;
    border-radius: 0px 20px 20px 0px;
    cursor: pointer;
}

.searchButton svg {
    max-width: 40px;
    max-height: 25px;
    padding: 5px 5px 5px 5px;
}

.searchButton:hover {
    background-color: #cacb8d;
}

.searchResult {
    position: absolute;
    top: 100%;
    width: 100%;
    max-height: 450px;
    background-color: #f1f1f1;
    border-radius: 0 25px 25px 25px;
    z-index: 2;
}

.searchResult .quizLink{
    background:none;
    border: none;
    margin: 10px;
}

.searchResult .quizLink:hover{
    cursor: pointer;
    background-color: #b9c19a;
}

.searchResult p{
    margin-left: 10px;
    font-style: italic;
}

/* Profile & LogOut */
.profileDropdown button {
    background: none;
    cursor: pointer;
    border: none;
    margin-right: 30px;
    position: relative;
    border-radius: 10px;
}

.profileDropContent {
    display: none;
    flex-direction: column;
    position: absolute;
    background-color: #b9c19a;
    width: fit-content;
    border-radius: 10px;
    z-index: 2;
}

.profileDropContent a {
    padding: 5px;
    color: black;    
    text-decoration: none;
    border-radius: 10px;
}

/* Filter Container */
.filter-container {
    position: absolute;
    top: 80px;
    left: 20px;
    display: flex;
    align-items: center;
    padding: 0.5em;
    cursor: pointer;
}

.filter-container:hover .filter-options {
    display: block;
}

.filter-icon {
    width: 30px;
    height: 30px;
    margin-right: 10px;
}

.filter-options {
    position: fixed;
    top: 84px;
    left: 20;
    width: 250px;
    background-color: var(--white-color);
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
    padding: 20px;
    display: none;
    height: auto;
    z-index: 10;
}

.filter-options ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.filter-options li {
    margin-bottom: 1em;
}

.filter-options li a {
    color: var(--dark-color);
    text-decoration: none;
    display: block;
    padding: 10px;
    transition: background-color 0.3s ease;
}

.filter-options li a:hover {
    background-color: var(--light-gray);
}

.filter-options a {
    color: var(--white-color);
    text-decoration: none;
}

.filter-options a:hover {
    color: var(--gray-color);
}

.filter-container:hover .filter-options {
    display: block;
}

        /*QUIZ CONTAINER*/
        .quiz-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 5em;
            max-width: 1400px;
            margin: 0 auto;
        }

        .quiz-container .quiz {
            display: flex;
            flex-direction: column;
            background-color: var(--dark-white);
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 1.5em;
            height: 250px;
            width: 100%;
        }

        .quiz-container .quiz h2 {
            font-size: var(--font-size-m);
            font-weight: bold;
            margin-bottom: 1em;
        }

        .quiz-container .quiz p {
            font-size: var(--font-size-s);
            margin-bottom: 1em;
        }

        .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination a {
    display: inline-block;
    padding: 10px 20px;
    text-decoration: none;
    margin: 5px;
    background-color: var(--light-gray);
    border-radius: 5px;
    color: var(--dark-color);
}

.pagination a.active {
    background-color: var(--primary-color);
    color: var(--white-color);
}

.start-quiz-btn {
    background-color: var(--primary-color);
            color: var(--white-color);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            font-family:'Times New Roman', Times, serif;
            margin-top: auto;
}

.start-quiz-btn:hover {
    background-color: var(--secondary-color);
}

.subject-header{
    text-align: center;
    margin: 20px 0;
    padding: 10px;
    border-radius: var(--border-radius-s);
    max-width: 1400px;
    margin: 20px auto;
}

.subject-header h1 {
    color: var(--dark-color);
    font-family: "Albert Sans", sans-serif;
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-bold);
}

        /*FOOTER SECTION*/
        .footer{
            width: 100vw;
            margin: 0;
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(5px);
        }

        .footer .box-container{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            justify-content: center;
            max-width: none;
            width: 100%;
            margin: 0 auto;
            padding: 0 5%;
            background: transparent;
        }

        .footer .box-container .box{
            text-align: center;
            background: transparent;
        }

        .footer .box-container .box h3{
            padding: .5rem 0;
            font-size: var(--font-size-l);
            color: var(--dark-color);
            text-align: center;
            font-family: "Albert Sans", sans-serif;
            gap: 2rem;
        }

        .footer .box-container .box a{
            display: block;
            padding: .5rem 0;
            font-size: var(--font-size-m);
            color: var(--primary-color);
            text-align: center;
            text-decoration: none;
            font-family: "Lato", sans-serif;
            gap: 2rem;
        }

        .footer .box-container .box li{
            margin-bottom: 16px;
            display: block;
            transition: all .40s ease;
        }

        .footer .box-container .box a:hover{
            background: none;
            text-decoration: underline;
        }

        .footer .box-container .box li:hover{
            transform: translateY(-3px) translateX(-5px);
            background: none;
        }

        .footer .credit{
            text-align: center;
            border-top: .1rem solid rgba(0,0,0,0.1);
            font-size: 1rem;
            color: var(--dark-color);
            padding: .5rem;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }

        .footer .box-container .box p{
            display: block;
            padding: .5rem 0;
            font-size: var(--font-size-m);
            color: var(--primary-color);
            text-align: center;
            font-family: "Lato", sans-serif;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
    .quiz-container {
        max-width: 600px;
        padding: 2em; 
    }

    .quiz-container .quiz {
        height: auto; 
    }

    .quiz-container .quiz h2 {
        font-size: var(--font-size-l);
    }

    .quiz-container .quiz p {
        font-size: var(--font-size-xs); 
    }
}


@media (max-width: 480px) {
    .quiz-container {
        padding: 1em; 
        grid-template-columns: 1fr; 
    }

    .quiz-container .quiz {
        padding: 1em;
    }

    .quiz-container .quiz h2 {
        font-size: var(--font-size-m);
    }

    .quiz-container .quiz p {
        font-size: var(--font-size-xs); 
    }

    .start-quiz-btn {
        font-size: var(--font-size-s); 
    }

    .filter-container {
        position: absolute;
        top: 60px;
        left: 20px; 
    }
}


@media (max-width: 320px) {
    .quiz-container {
        padding: 0.5em; 
    }

    .quiz-container .quiz {
        padding: 0.5em; 
    }

    .quiz-container .quiz h2 {
        font-size: var(--font-size-s); 
    }

    .quiz-container .quiz p {
        font-size: var(--font-size-xs); 
    }

    .start-quiz-btn {
        font-size: var(--font-size-xs); 
    }

    .filter-container {
        position: absolute;
        top: 60px;
        left: 20px; 
    }
}
    .toggleSearch {
    display: none;
    }

    @media screen and (max-width:720px){
   
   .navBar{
    flex-direction: column;
   }
    .searchContainer{
    display:none;
   }
   
    .searchContent{
        flex-basis: 0;
    }

    .navbar .logo {
        width:80px
    }

    .profileDropdown{
        display:flex;
    }

    .toggleSearch{
        display: block;
        border: none;
        background: none;
    }

    .toggleSearch:hover{
        cursor: pointer;
    }

    .navbar .dropdown{
        border-radius: 25px;
    }

    .searchContainer.active{
        display: flex;
        z-index: 8;
        position: absolute;
        top: 100%;
        border-radius: 20px;
        width: 40%;
        align-items: center;
    }

    .searchContainer .searchButton{
        display:none;
    }

    #search{
        width: inherit;
    }
}

</style>

<body>
<header>
    <nav class="navbar">
        <a href="user_home.php"><img src="img/logo.png" class="logo" alt="Logo of Mass SPM"></a>
        <div class="searchContent">
            <div class="dropdown">
                Subjects 
                <svg width="10pt" height="10pt" version="1.1" viewBox="0 0 1200 1200" xmlns="http://www.w3.org/2000/svg" style="display: inline;">
                    <path transform="scale(50)" d="m21 8.5-9 9-9-9" fill="none" stroke="#000" stroke-miterlimit="10" stroke-width="2"/>
                </svg>
                
                <div class="dropContent">
                        <?php
                        $sql = "SELECT SubjectName FROM subject";
                        $result = mysqli_query($connection,$sql);
                        while ($row = $result->fetch_assoc()) {
                            echo ("<a href='user_home.php?subject=" . urlencode($row["SubjectName"]) . "' class='dropElement'>" . $row["SubjectName"] . "</a>");
                        }
                        ?>
                </div>
            </div>

            <form action="quizPage.php" method="POST" >
                    <div class="searchContainer">
                        <input type="search" class="searchBar" name="searchQuery" id="search" placeholder="Search..."> 
                        <button type = "submit" class="searchButton">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px"><path d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z"/></svg>
                        </button> 
                
                        <!-- Search function PHP code -->
                        <?php
                        $searchDisplay = "";
                        $searchInput = isset($_POST['searchQuery']) ? $_POST['searchQuery'] : '';

                        if (!empty($searchInput)) {
                            $sqlQuery = "SELECT * FROM quiz WHERE QuizName LIKE '%$searchInput%'"; 

                            $searchResult = mysqli_query($connection,$sqlQuery);

                            if ($searchResult->num_rows > 0) {
                                while ($row = $searchResult->fetch_assoc()) {
                                    $searchDisplay .= "<form action='quizPage.php' method = 'POST' style ='display:inline;'>
                                    <input type = 'hidden' name = 'QuizID' value = '". $row['QuizID'] . "'>
                                    <button type = 'submit' class='quizLink'>" . $row["QuizName"] . '</button>
                                    </form><br>';

                                }
                            } else {
                                $searchDisplay = "<p>" . "No search results match" . "</p>";
                            }

                        }
                        ?>
                        <div class="searchResult" id="searchResultContainer">
                            <?php
                            echo $searchDisplay;
                            ?>
                        </div>
                    </div>
                </form>
            </div>

            <button type="button" class="toggleSearch"> <!-- small screen search button -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="25px" height="25px">
                    <path d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z" />
                </svg>
            </button>

            <script> //when screen size is small, toggle function to dropdown searchbar
                const toggleButton = document.querySelector('.toggleSearch');
                const searchContainer = document.querySelector('.searchContainer');


                if (localStorage.getItem('searchToggled') === 'true') { //refresh to another page the search result won't disappear
                    searchContainer.classList.add('active');
                } else {
                    searchContainer.classList.remove('active');
                }

                toggleButton.addEventListener('click', function() {
                    searchContainer.classList.toggle('active');

                    if (searchContainer.classList.contains('active')) {
                        localStorage.setItem('searchToggled', 'true');
                    } else {
                        localStorage.setItem('searchToggled', 'false');
                    }
                });

                document.addEventListener('click', function(event) {//if user click outside the bar will hide
                if (!searchContainer.contains(event.target) && !toggleButton.contains(event.target)) {
                    searchContainer.classList.remove('active');
                    localStorage.setItem('searchToggled', 'false');
                }
            });

            </script>
        
        <div class="profileDropdown">
            <button><svg class="feather feather-user" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
                </svg>
            </button>
            <div class="profileDropContent"> 
                <a href="profile.php" class="profileDropElement">Profile</a>
                <a href="#" class="profileDropElement" onclick="window.location='landingPage.php'">Log Out</a>
            </div>
        </div>
    </nav> 
</header>

<main>
    <?php
    $selectedType = isset($_GET['type']) ? $_GET['type'] : 'All';
    $selectedSubject = isset($_GET['subject']) ? $_GET['subject'] : 'All';

    $baseQuery = "SELECT q.*, s.Description, s.SubjectName 
                FROM quiz q
                JOIN subject s ON q.SubjectID = s.SubjectID
                WHERE 1=1";

    if ($selectedType !== 'All') {
        $baseQuery .= " AND q.QuizType = '" . mysqli_real_escape_string($connection, $selectedType) . "'";
    }
    if ($selectedSubject !== 'All') {
        $baseQuery .= " AND s.SubjectName = '" . mysqli_real_escape_string($connection, $selectedSubject) . "'";
    }
    $countQuery = str_replace("q.*, s.Description, s.SubjectName", "COUNT(*) as total", $baseQuery);
    $countResult = mysqli_query($connection, $countQuery);
    $totalQuizzes = mysqli_fetch_assoc($countResult)['total'];

    $itemsPerPage = 8;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $itemsPerPage;

    $needPagination = $totalQuizzes > $itemsPerPage;

    $totalPages = ceil($totalQuizzes / $itemsPerPage);

    $finalQuery = $baseQuery . " LIMIT $offset, $itemsPerPage";
    $quizzes = mysqli_query($connection, $finalQuery);
    ?>

    <!-- FILTER -->
    <div class="filter-container">
        <label for="quizType">Select Quiz Type:</label>
        <select id="quizType" onchange="filterQuizzes()">
            <option value="All" <?php echo ($selectedType === 'All') ? 'selected' : ''; ?>>All</option>
            <?php 
            mysqli_data_seek($quizTypes, 0);
            while ($type = mysqli_fetch_assoc($quizTypes)) { ?>
                <option value="<?php echo $type['QuizType']; ?>" 
                    <?php echo ($selectedType === $type['QuizType']) ? 'selected' : ''; ?>>
                    <?php echo $type['QuizType']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <?php
        $selectedType = isset($_GET['type']) ? $_GET['type'] : 'All';
        $selectedSubject = isset($_GET['subject']) ? $_GET['subject'] : 'All';

        $baseQuery = "SELECT q.*, s.Description, s.SubjectName 
                    FROM quiz q
                    JOIN subject s ON q.SubjectID = s.SubjectID
                    WHERE 1=1";

        if ($selectedType !== 'All') {
            $baseQuery .= " AND q.QuizType = '" . mysqli_real_escape_string($connection, $selectedType) . "'";
        }

        if ($selectedSubject !== 'All') {
            $baseQuery .= " AND s.SubjectName = '" . mysqli_real_escape_string($connection, $selectedSubject) . "'";
        }

        $quizzes = mysqli_query($connection, $baseQuery);

        $countQuery = str_replace("q.*, s.Description, s.SubjectName", "COUNT(*) as total", $baseQuery);
        $countResult = mysqli_query($connection, $countQuery);
        $totalQuizzes = mysqli_fetch_assoc($countResult)['total'];

        $itemsPerPage = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $itemsPerPage;

        $needPagination = $totalQuizzes > $itemsPerPage;

        $totalPages = ceil($totalQuizzes / $itemsPerPage);

        $finalQuery = $baseQuery . " LIMIT $offset, $itemsPerPage";
        $quizzes = mysqli_query($connection, $finalQuery);
    ?>

    <?php if ($selectedSubject !== 'All'): ?>
        <div class="subject-header">
            <h1><?php echo htmlspecialchars($selectedSubject); ?> Quizzes</h1>
        </div>
    <?php endif; ?>

    <div class="quiz-container">
        <?php while ($quiz = mysqli_fetch_assoc($quizzes)) { ?>
            <?php $QuizID = $quiz["QuizID"]?>
            <form action="quizPage.php" method="POST" style="display:none;" id="passForm-<?php echo $QuizID;?>">
                <input type="hidden" name="QuizID" value="<?php echo $QuizID?>">
            </form>
            <div class="quiz" data-subject="<?php echo htmlspecialchars($quiz['SubjectName']); ?>" 
                data-type="<?php echo htmlspecialchars($quiz['QuizType']); ?>">
                <h2><?php echo htmlspecialchars($quiz['QuizName']); ?></h2>
                <p><strong>Type: </strong><?php echo htmlspecialchars($quiz['QuizType']); ?></p>
                <p><strong>Level: </strong>
                <?php 
                    echo $quiz['QuizLevel'] === NULL ? '--' : htmlspecialchars($quiz['QuizLevel']);
                ?>
                </p>
                <button class="start-quiz-btn" data-QuizID="<?php echo $QuizID;?>">Start Quiz</button>
            </div>
        <?php } ?>
    </div>
    <script>
        document.querySelectorAll(".start-quiz-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const QuizID = this.getAttribute("data-QuizID");
                const passForm = document.getElementById("passForm-" + QuizID);
                
                passForm.submit();
            });
        });
    </script>

    <!--Pagination-->
    <?php if ($needPagination): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?type=<?php echo $selectedType; ?>&subject=<?php echo $selectedSubject; ?>&page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?type=<?php echo $selectedType; ?>&subject=<?php echo $selectedSubject; ?>&page=<?php echo $i; ?>" 
                class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?type=<?php echo $selectedType; ?>&subject=<?php echo $selectedSubject; ?>&page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!--FOOTER SECTION-->
    <section class="footer">
    <div class="box-container">
        <div class="box">
            <h3>Subjects</h3>
            <?php if ($connection) {
                $sql = "SELECT DISTINCT s.SubjectName 
                        FROM subject s
                        INNER JOIN quiz q ON s.SubjectID = q.SubjectID";
                $statement = $connection->prepare($sql);                
                if ($statement) {
                    $statement->execute();
                    $result = $statement->get_result();                        
                    while ($row = $result->fetch_assoc()) {
                        echo ("<a href='user_home.php?subject=" . urlencode($row["SubjectName"]) . "' class='dropElement'>" . $row["SubjectName"] . "</a>");
                    }                       
                    $statement->close();
                } else {
                    echo "Error preparing statement: " . $connection->error;
                }
            } else {
                echo "Database connection failed";
            }
            ?>
        </div>

        <div class="box">
            <h3>Support</h3>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="window.location='faqs.php'">FAQs</a>
                </li>
                <li>
                    <a href="#" class="nav-link" onclick="window.location='privacy_policy.php'">Privacy Policy</a>
                </li>
        </div>

        <div class="box">
            <h3>About</h3>
                <li>
                    <a href="landingPage.php#aboutUs">About Us</a>
                </li>
                <Li>
                    <a href="#" class="nav-link" onclick="window.location='career.php'">Career</a>
                </Li>
                <li>
                    <a href="#" class="nav-link"  onclick="window.location='contact_us.php'">Contact Us</a>
                </li>
                <li>
                    <a href="#" class="nav-link"  onclick="window.location='our_team.php'">Our team</a>
                </li>
        </div>
    </div>
    <div class="credit"> Copyright @ 2024 MassSPM</div>
    </section>
</main>

<script>
    function filterQuizzes() {
    const selectedType = document.getElementById('quizType').value;
    window.location.href = `user_home.php?type=${encodeURIComponent(selectedType)}`;
}

function filterSubjects(selectedSubject) {
    window.location.href = `user_home.php?subject=${encodeURIComponent(selectedSubject)}`;
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const currentType = urlParams.get('type') || 'All';
    const currentSubject = urlParams.get('subject') || 'All';
    const typeDropdown = document.getElementById('quizType');
    for (let i = 0; i < typeDropdown.options.length; i++) {
        if (typeDropdown.options[i].value === currentType) {
            typeDropdown.selectedIndex = i;
            break;
        }
    }
});
</script>
</body>
</html>