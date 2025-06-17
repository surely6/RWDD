<?php
ob_start();
session_start();
include('connection.php');
$error_message = "";
$success_message = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
            padding: 0;
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
            padding-top: 80px;
        }

        /*NAVIGATION BAR*/
        header{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 5;
            background: var(--primary-color);
        }

        header .navbar{
            display: flex;
            padding: 20px;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .nav-logo{
            text-decoration: none;
        }


        .navbar .nav-menu{
            display: flex;
            gap: 10px;
            list-style-type: none;
        }

        .navbar .nav-menu .nav-link{
            padding: 10px 18px;
            color: var(--white-color);
            font-size: var(--font-size-m);
            background: var(--secondary-color);
            border-radius: var(--border-radius-m);
            transition: 0.3s ease;
            text-decoration: none;
        }

        .navbar .nav-menu .nav-link:hover{
            color: var(--primary-color);
            background: var(--secondary-color);
        }

        .navbar :where(#menu-close-button, #menu-open-button){
            display: none;
        }

        .navbar #menu-open-button,
        .navbar #menu-close-button{
            display: none;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
                
        body.show-mobile-menu #menu-close-button {
            display: block; 
        }

        body.show-mobile-menu .nav-menu {
            display: flex;
        }

        .nav-logo .logo-image{
            height: 60px;
            width: auto;
            margin-top: -10px;
            margin-bottom: -10px;
        }

        /*FOOTER SECTION*/
        .footer{
          background-color: var(--white-color);
          width: 100%;
          padding: 2rem 0;
          margin: 0;
        }

        .footer .box-container{
            display: flex;
            justify-content: space-around;
            padding: 0 20px;

        }

        .footer .box{
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }

        .footer .box-container .box h3{
            padding: .5rem 0;
            font-size: var(--font-size-l);
            color: var(--dark-color);
            font-family: "Albert Sans", sans-serif;
        }

        .footer .box a{
            display: block;
            padding: .5rem 0;
            font-size: var(--font-size-m);
            color: var(--primary-color);
            text-decoration: none;
            font-family: "Lato", sans-serif;
        }

        .footer .box li{
            margin-bottom: 16px;
            display: block;
            transition: all .40s ease;
        }

        .footer .box a:hover{
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .footer .box li:hover{
            transform: translateY(-3px) translateX(-5px);
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
        }

        /*CONTACT US*/
        .contact-box{
            position: relative;
            height: 80vh;
            color: var(--white-color);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .contact-box::before {
            content: ""; 
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('img/Contact_us.jpg'); 
            background-position: center; 
            background-repeat: no-repeat;
            background-size: cover;
            filter: blur(8px);
            object-fit: cover;
        }
        
        .contact-box h2{
            position: relative;
            z-index: 2;
            font-size: var(--font-size-xxxl);
            font-family: "Albert Sans", sans-serif;
            color: var(--dark-color);
        }

        .contact-info{
            display: flex;
            flex-direction: row;
            justify-content: space-around;
        }

        .contact-column{
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }

        .contact-column img{
            width: 24px;
            height: 24px;
            margin-bottom: 10px;
        }

        .contact-column span{
            margin-bottom: 10px;
            font-family: "Lato", sans-serif;
            font-size: var(--font-size-m);
            text-align: center;
        }

        /*RESPONSIVE TABLET(768px)*/
        @media screen and (max-width: 768px) {
        /*NAVIGATION BAR*/
        .nav-menu {
            display: none;
            flex-direction: column;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100%;
            background: var(--light-yellow);
            padding-top: 100px;
            z-index: 1000;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            justify-content: center;
        }

        body.show-mobile-menu .nav-menu {
            transform: translateX(0);
        }

        .navbar #menu-open-button,
        .navbar #menu-open-button{
            width: 25px;
            height: 25px;
            cursor: pointer;
        }

        .navbar #menu-open-button img,
        .navbar #menu-close-button img {
            width: 25px;
            height: 25px;
        }

        #menu-close-button {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 30px;
            height: 30px;
            z-index: 1001;
            display: none;
        }

        .navbar #menu-open-button {
            display: block;
        }

        body.show-mobile-menu #menu-close-button {
            display: block;
            background: none;
            border: none;
        }

        .navbar .nav-menu .nav-item {
            margin-bottom: 20px;
        }

        .navbar .nav-menu .nav-link {
            padding: 12px 20px;
            color: var(--white-color);
            font-size: var(--font-size-m);
            background: var(--secondary-color);
            border-radius: var(--border-radius-m);
            transition: background 0.3s ease;
        }

        .navbar .nav-menu .nav-link:hover {
            background: var(--primary-color);
        }

        .navbar {
            flex-direction: column;
            align-items: flex-start;
        }

        .nav-logo .logo-image {
            height: 50px;
        }

        /*FOOTER SECTION*/
        .footer .box-container {
            grid-template-columns: 1fr 1fr;
        }

        .footer .box-container .box p {
            font-size: var(--font-size-m);
        }

        .footer .box-container .box a{
            font-size: var(--font-size-m);
        }
        }

        /*RESPONSIVE PHONE (480px)*/
        @media screen and (max-width: 480px) {
        /*NAVIGATION BAR*/
        .nav-menu {
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            height: 100%;
            justify-content: center;
        }

        .navbar .nav-menu .nav-item {
            margin-bottom: 15px;
        }

        .navbar .nav-menu .nav-link {
            padding: 8px 16px;
            font-size: var(--font-size-s);
            background: var(--secondary-color);
            border-radius: var(--border-radius-m);
            transition: background 0.3s ease;
        }

        .navbar .nav-menu .nav-link:hover {
            background: var(--primary-color);
        }

        .navbar #menu-open-button img {
            width: 25px;
            height: 25px;
            background: none;
        }

        #menu-close-button img {
            width: 25px;
            height: 25px;
        }

        /*FOOTER SECTION*/
        .footer .box-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 20px;
        }

        .footer .box{
            width: 100%;
            margin-bottom: 20px;
            text-align: center;
        }

        .footer .box-container .box h3 {
            font-size: var(--font-size-l);
            margin-bottom: 10px;
        }

        .footer .box-container .box p,
        .footer .box-container .box a,
        .footer .box-container .box li {
            font-size: var(--font-size-m);
            margin-bottom: 8px;
            text-align: center;
        }

        .footer .credit {
            font-size: 0.9rem;
            padding: 10px;
        }

        .footer .box-container .box li {
            font-size: var(--font-size-s);
        }

        /*CONTACT US*/
        .contact-column span{
            font-size: var(--font-size-s);
        }
        }

        @media screen and (max-width: 320px) {
            /*NAVIGATION BAR*/
            .navbar {
        padding: 10px;
        justify-content: space-between;
        align-items: center;
    }

    .nav-logo .logo-image {
        width: 80px;
        height: auto;
    }

    .nav-menu {
        position: fixed;
        top: 0;
        left: -200px;
        width: 200px;
        height: 100vh;
        background: var(--light-yellow);
        padding-top: 80px;
        z-index: 1000;
        transition: left 0.3s ease-in-out;
        justify-content: center;
    }

    body.show-mobile-menu .nav-menu {
        left: 0;
    }

    .navbar #menu-open-button,
    .navbar #menu-close-button {
        width: 20px;
        height: 20px;
        display: block;
    }

    #menu-close-button {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 1001;
    }

    .navbar .nav-menu .nav-item {
        margin-bottom: 15px;
        width: 100%;
        text-align: center;
    }

    .navbar .nav-menu .nav-link {
        padding: 8px 16px;
        font-size: var(--font-size-s);
        background: var(--secondary-color);
        border-radius: var(--border-radius-m);
        display: inline-block;
    }

    /* Contact Section */
    .contact-box {
        height: auto; 
        padding: 20px; 
        text-align: center;
    }

    .contact-box h2 {
        font-size: var(--font-size-xl); 
    }

    .contact-info {
        flex-direction: column; 
        align-items: center;
    }

    .contact-column {
        margin: 10px 0; 
    }

    .contact-column img {
        width: 20px;
        height: 20px; 
    }

            /*FOOTER SECTION*/
            .footer .box-container {
            grid-template-columns: 1fr 1fr;
        }

        .footer .box-container .box p {
            font-size: var(--font-size-m);
        }

        .footer .box-container .box a{
            font-size: var(--font-size-m);
        }

    .footer .box-container .box a,
    .footer .box-container .box p,
    .footer .box-container .box li {
        font-size: var(--font-size-s);
        margin-bottom: 8px;
    }

    .footer .credit {
        font-size: 0.8rem;
        padding: 10px;
    }

    /*GENERAL ADJUSTMENTS*/
    .section-title {
        font-size: var(--font-size-l);
        padding: 40px 0 60px;
    }

    .section-content {
        padding: 0 10px;
    }
}
</style>

<body>
    <!--HEADER AND NAVIGATION BAR-->
    <header>
        <nav class="navbar">
            <a href="user_home.php" class="nav-logo" section-content>
                <img src="img/logo.png" alt="MASS SPM logo" class="logo-image">
            </a>
            <ul class="nav-menu">
                <button id="menu-close-button">
                    <img src="icon/close.png"  class="close-menu" alt="Close Menu" />
                </button>
                <li class="nav-item">
                    <a href="landingPage.php#hero" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="landingPage.php#aboutUs" class="nav-link">About Us</a> 
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="window.location='signup.php'">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="window.location='login.php'">Log In</a>
                </li>
            </ul>
            <button id="menu-open-button" style="background: none; border: none; cursor: pointer;">
                <img src="icon/hamburgermenu.png" alt="Open Side Menu" />
            </button>
        </nav>
    </header>

    <!--CONTACT US-->
    <section class="contact-section">
        <div class="contact-box">
            <h2>Contact Us</h2>
            <div class="line">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <p class="text">We're always happy to hear from you. Whether you have a question, a comment, or just want to say hello, we're here to listen.</p>
        </div>
        <div class="contact-body">
            <div class="contact-info">
                <div class="contact-column">
                    <img src="icon/phone.png" alt="PhoneIcon">
                    <span>Contact Number: </span>
                    <span class="text">05-123456</span>
                </div>
                <div class="contact-column">
                <img src="icon/email.png" alt="EmailIcon">
                    <span>Email: </span>
                    <span class="text">mass_spm@gmail.com</span>
                </div>
                <div class="contact-column">
                    <img src="icon/address.png" alt="AddressIcon">
                    <span>Address: </span>
                    <span class="text">Bukit Jalil, Kuala Lumpur</span>
                </div>
            </div>
        </div>
    </section>

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
                            echo ("<p class='subject-name'>" . $row["SubjectName"] . "</p>");
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
                        <a href="#" class="nav-link">Contact Us</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link"  onclick="window.location='our_team.php'">Our team</a>
                    </li>
            </div>
        </div>
        <div class="credit"> Copyright @ 2024 MassSPM</div>
    </section>
    
    <script>
        const menuOpenButton = document.querySelector("#menu-open-button");
        const menuCloseButton = document.querySelector("#menu-close-button");
        const navMenu = document.querySelector(".nav-menu");

        menuOpenButton.addEventListener("click", () => {
            document.body.classList.add("show-mobile-menu");
        });

        menuCloseButton.addEventListener("click", () => {
            document.body.classList.remove("show-mobile-menu");
        });

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                document.body.classList.remove("show-mobile-menu");
            });
        });
    </script>
</body>
</html>