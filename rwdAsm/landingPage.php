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
    <title>Landing Page</title>
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

        /*WHOLE SITE STYLE*/
        ul{
            list-style: none;
        }

        a{
            text-decoration: none;
        }

        button{
            cursor: pointer;
            border: none;
            background: none;
        }

        body{
            max-width: 100%;
            overflow-x: hidden;
        }

        img{
            width: 100%;
            object-fit: cover;
        }

        .section-content{
            margin: 0 auto;
            padding: 0 20px;
            max-width: var(--site-max-width);
        }

        .section-title{
            text-align: center;
            padding: 60px 0 100px;
            text-transform: uppercase;
            font-size: var(--font-size-xl);
        }

        .section-title::after{
            content: "";
            width: 80px;
            height: 5px;
            display: block;
            margin: 10px auto 0;
            border-radius: var(--border-radius-s);
            background: var(--secondary-color);
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

        /*HERO SECTION*/
        .hero-section{
            min-height: 100vh;
            background: var(--primary-color);
        }

        .hero-section .section-content{
            display: flex;
            align-items: center;
            min-height: 100vh;
            color: var(--white-color);
            justify-content: space-between;
        }

        .hero-section .hero-details .title{
            font-size: var(--font-size-xxxl);
            color: var(--secondary-color);
            font-family: "Albert Sans", sans-serif;
        }

        .hero-section .hero-details .landing_description{
            color: var(--white-color);
            text-align: justify;
            text-justify: inter-word;
            margin-right: 50px;
            font-size: var(--font-size-m);
            font-family: "Lato", sans-serif;
        }

        .hero-section .hero-details .subtitle{
            margin-top: 8px;
            max-width: 70%;
            font-size: var(--font-size-xl);
            font-weight: var(--font-weight-semibold);
        }

        .hero-section .hero-details .description{
            max-width: 70%;
            margin: 24px 0 40px;
            font-size: var(--font-size-m);
        }

        .hero-section .hero-landing-image{
            max-width: 700px;
            margin-right: 30px;
            height: auto;
        }

        /*ABOUT US*/
        .aboutUs-section{
            padding: 120px 0;
            background: var(--light-pink-color);
        }

        .aboutUs-section .section-content{
            display: flex;
            gap: 50px;
            align-items: center;
            justify-content: center;
        }

        .aboutUs-section .aboutUs-image .about-image{
            width: 400px;
            height: 400px;
            object-fit: cover;
            border-radius: var(--border-radius-circle);
        }

        .aboutUs-section .about-details .section-title{
            padding: 0;
            margin-top: 0%;
            margin-right: auto;
            font-family: "Albert Sans", sans-serif;
        }

        .aboutUs-section .about-details{
            max-width: 50%;
            text-align: left;
        }

        .aboutUs-section .about-details .text{
            line-height: 30px;
            text-align: justify;
            max-width: 800px;
            font-size: var(--font-size-m);
            font-family: "Lato", sans-serif;
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
            font-size: 2.5rem;
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

            /*HERO SECTION*/
            .hero-section .hero-details {
                max-width: 70%;
            }

            .hero-section .hero-landing-image {
                max-width: 50%;
            }

            .section-title {
                font-size: var(--font-size-xl);

            .hero-section .hero-details .title {
                font-size: var(--font-size-xxl);
            }

            .hero-section .hero-details .subtitle {
                font-size: var(--font-size-l);
            }

            .hero-section .hero-details .landing_description {
                font-size: var(--font-size-n);
                margin-right: 0;
            }

            .aboutUs-section .about-details .text {
                font-size: var(--font-size-s);
            }
            }

            /*ABOUT US SECTION*/
            .aboutUs-section .section-content {
                gap: 30px;
            }

            .aboutUs-section .aboutUs-image .about-image {
                width: 100%;
                height: auto;
            }

            .aboutUs-section .about-details {
                max-width: 100%;
                text-align: left;
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

        .wrapper h1{
            margin-top: 50px;
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

    /* Hero Section */
    .hero-section .section-content {
        flex-direction: column;
        align-items: center; 
        padding: 50px; 
    }

    .hero-section .hero-details {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    max-width: 100%;
}

.hero-section .hero-details .landing_description {
    width: 300px;
    color: var(--white-color);
    text-align: justify;
    text-justify: inter-word;
    margin: 0 auto; 
    font-size: var(--font-size-m);
    font-family: "Lato", sans-serif;
}

    .hero-section .title{
        text-align: center;
        padding: 40px;
    }

    .hero-section .hero-landing-image {
        max-width: 100%;
        margin: 0; 
    }

    /* About Us Section */
    .aboutUs-section .section-content {
        flex-direction: column;
        align-items: center;
        gap: 20px; 
    }

    .aboutUs-section .aboutUs-image .about-image {
        width: 100%;
        height: auto; 
    }

    .aboutUs-section .about-details {
        max-width: 100%; 
        text-align: center; 
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
}

        /*RESPONSIVE PHONE (320px)*/
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

    /*HERO SECTION*/
    .hero-section .section-content {
        flex-direction: column;
        text-align: center;
        padding: 0 15px;
    }

    .hero-section .hero-details,
    .hero-section .hero-landing-image {
        max-width: 100%;
        margin-right: 0;
        margin-top: 100px;
    }

    .hero-section .hero-details .title {
        font-size: var(--font-size-l);
        margin-bottom: 15px;
        margin-top: 30px;
    }

    .hero-section .hero-details .landing_description {
        font-size: var(--font-size-s);
        margin-right: 0;
        line-height: 1.5;
    }

    .hero-section .hero-landing-image {
        margin-top: 20px;
    }

    /*ABOUT US SECTION*/
    .aboutUs-section {
        padding: 60px 0;
    }

    .aboutUs-section .section-content {
        flex-direction: column;
        gap: 20px;
        padding: 0 15px;
    }

    .aboutUs-section .aboutUs-image .about-image {
        width: 250px;
        height: 250px;
    }

    .aboutUs-section .about-details {
        max-width: 100%;
        text-align: center;
    }

    .aboutUs-section .about-details .section-title {
        padding: 0 0 20px 0;
    }

    .aboutUs-section .about-details .text {
        font-size: var(--font-size-s);
        line-height: 24px;
        max-width: 100%;
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
</head>

<body>
    <!--HEADER AND NAVIGATION BAR-->
    <header>
        <nav class="navbar">
            <a href="landingPage.php" class="nav-logo" section-content>
                <img src="img/logo.png" alt="MASS SPM logo" class="logo-image">
            </a>
            <ul class="nav-menu">
                <button id="menu-close-button">
                    <img src="icon/close.png"  class="close-menu" alt="Close Menu" />
                </button>
                <li class="nav-item">
                    <a href="#hero" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#aboutUs" class="nav-link">About Us</a> 
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

    <main>
        <!--HERO SECTION-->
        <section class="hero-section" id="hero">
            <div class="section-content">
                <div class="hero-details">
                    <h2 class="title">
                        Master Your SPM with Fun and Focus!
                    </h2>
                    <p class="landing_description">
                    Welcome to MASS SPM – your ultimate online platform for mastering the SPM exams! Designed for Form 4 and 5 students, MASS SPM offers fun and effective quizzes, practice questions, and resources across all subjects. Study at your own pace, track your progress, and ace your SPM with ease. Start your journey to success today with MASS SPM!
                    </p>
                </div>
                <div class="hero-landing-image">
                    <img src="img/Landing_page.jpg" alt="Hero" class="hero-image">
                </div>
            </div>
        </section>

        <!--ABOUT US SECTION-->
        <section class="aboutUs-section" id="aboutUs">
            <div class="section-content">
                <div class="aboutUs-image">
                    <img src="img/About_us.jpg" alt="About" class="about-image">
                </div>
                <div class="about-details">
                    <h2 class="section-title">
                        About Us
                    </h2>
                    <p class="text">
                        Welcome to MASS SPM, the ultimate platform for Form 4 and 5 students to ace their SPM exams! We offer interactive quizzes and revision materials covering all major subjects in the SPM syllabus. Our engaging approach helps you strengthen key concepts, track progress, and study at your own pace. With MASS SPM, learning becomes both fun and effective, preparing you to face the exams with confidence. Join us and make your SPM journey more enjoyable and rewarding!
                    </p>        
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
                                //can only view, cannot click
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
                            <a href="#aboutUs">About Us</a>
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