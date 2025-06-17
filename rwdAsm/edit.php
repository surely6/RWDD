<?php
session_start();
include('connection.php');

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    die("You must be logged in to edit your profile.");
}

// Fetch current user's details before processing the form
$userID = $_SESSION['userID'];
$currentUserQuery = "SELECT UserName, Email, DOB, ProfilePicURL FROM user WHERE UserID = '$userID'";
$result = mysqli_query($connection, $currentUserQuery);

if($result->num_rows >0){
    $currentUser = $result -> fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://fonts.googleapis.com/css?family=Albert+Sans|Lato" rel="stylesheet">
    <style>
        body {
            font-family: "Lato", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('img/background.png') no-repeat;
            min-height: 100vh;
            height: auto;
            background-size: cover;
        }
        

        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            font-family: "Albert Sans", sans-serif;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="file"] {
            width: inherit;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5c9b45;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4e8b39;
        }

        .message {
            margin-top: 10px;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
        }

        .error { color: red; }
        .success { color: green; }

        .profileBack{
            position: absolute;
            top: 10%;
            width: 15%;
        }
        
    </style>
</head>

<body>
    <button type="button" onclick="window.location='profile.php'" class="profileBack">Back</button>
    <div class="container">
        <h1>Edit Profile</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="UserName" 
                   value="<?php echo htmlspecialchars($currentUser['UserName']); ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="Email" 
                   value="<?php echo htmlspecialchars($currentUser['Email']); ?>">

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="DOB" 
                   value="<?php echo htmlspecialchars($currentUser['DOB']); ?>">

            <label for="profilePic">Profile Picture:</label>
            <input type="file" id="profilePic" name="ProfilePic" accept="image/*">

            <button type="submit" name="submit">Update Profile</button>
        </form>
    </div>
</body>

<?php
if (isset($_POST["submit"])) {
    $userName = $_POST["UserName"];
    $email = $_POST["Email"];
    $dob = $_POST["DOB"];
    $profilePicURL = NULL;

    if (isset($_FILES["ProfilePic"]) && $_FILES["ProfilePic"]["error"] === 0) {
        $targetDir = "uploads/";
        $fileName = uniqid() . "_" . basename($_FILES["ProfilePic"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["ProfilePic"]["tmp_name"], $targetFilePath)) {
                $profilePicURL = $targetFilePath;  
            } else {
                $error_message = "Sorry, there was an error uploading your file. Check permissions for the 'uploads/' directory.";
            }
        } else {
            $error_message = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    $updateQuery = "UPDATE user SET UserName = '$userName', Email = '$email', DOB = '$dob', ProfilePicURL = '$profilePicURL' WHERE UserID = '$userID'";

    if (mysqli_query($connection, $updateQuery)) {
        echo "<script>alert('Profile successfully updated');
            window.location.href = 'profile.php'; 
            </script>";
    } else {
        echo "<script>alert('ERROR: " . mysqli_error($connection) . "');</script>";
    }
}

?>

</html>