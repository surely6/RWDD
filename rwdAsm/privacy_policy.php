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
    <title>Privacy Policy</title>
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

        /*PRIVACY POLICY*/
        .main{
            max-width: var(--site-max-width);
            margin: 0 auto;
            padding: 20px;
        }

        .privacy-policy {
            background: var(--light-pink-color);
            padding: 20px;
            border-radius: var(--border-radius-m);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
            padding-left: .5rem;
            padding-right: .5rem;
        }

        .privacy-policy h1 {
            position: relative;
            z-index: 2;
            font-size: var(--font-size-xxxl);
            font-family: "Albert Sans", sans-serif;
            color: var(--dark-color);
            text-align: center;
        }

        .privacy-policy h3 {
            font-size: var(--font-size-l);
            margin-top: 20px;
            margin-bottom: 10px;
            font-family: "Albert Sans", sans-serif;
        }

        .privacy-policy p {
            margin-bottom: 15px;
            font-size: var(--font-size-n);
            line-height: 1.8;
            font-family: "Lato", sans-serif;
        }
                
        .privacy-policy ul {
            list-style-type: disc;
            padding-left: 30px; 
            margin-bottom: 20px; 
        }

        .privacy-policy li {
            margin-bottom: 10px;
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
        
        /*PRIVACY POLICY*/
        .privacy-policy h1{
            padding: 50px;
        }

        .privacy-policy{
            margin: 20px;
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

    <!--PRIVACY POLICY-->
    <main>
        <section class="privacy-policy">
            <h1>
                Privacy Policy
            </h1>
            <p>
                <strong>Last updated November 01, 2024</strong>
            </p>
            <br><br>
            <p>
                This Privacy Notice for MASS SPM('we', 'us', or 'our'), describes how and why we might access, collect, store, use, and/or share ('process') your personal information when you use our services('Services'), including when you:
            </p>
            <ul>
                <li>Visiting our website at (<a href="http://www.mass_spm.com">http://www.mass_spm.com</a>) or any website of ours that links to this Privacy Notice</li>
                <li>Use MASS SPM. MASS SPM offers a fun and engaging platform designed to help SPM students quickly revise and prepare for their exams. With interactive quizzes, personalized study content, and a user-friendly interface, our website makes learning both effective and enjoyable. Whether you're looking for quick practice sessions or in-depth revision, we provide the tools you need to boost your confidence and succeed in your SPM journey.</li>
                <li>Engage with us in other related ways, including any sales, marketing, or events</li>
            </ul>
            <br>
            <p>
                <strong>Questions or concerns? </strong>Reading this Privacy Notice will help you understand your privacy rights and choices. We are responsible for making decisions about how your personal information is processed. If you do not agree with out policies and practices, please do not use our Services. If you still have any questions or concerns, please contact us at mass_spm@gmail.com.
            </p>
            <br><br>
            <h3>Summary of key points</h3>
            <p>
                <strong>What personal information do we process? </strong>When you visit, use, or navigate our Services, we may process personal information depending on how you interact with us and the Services, the choices you make, and the products and features you use.
            </p>
            <P>
                <strong>Do we process any sensitive personal information? </strong>Some of the information may be considered 'special' or 'sensitive' in certain jurisdictions, for example your racial or ethnic origins, sexual orientation, and religious beliefs. We do not process sensitive personal information.
            </P>
            <p>
                <strong>Do we collect any information from third parties? </strong>We do not collect any information from third parties.
            </p>
            <p>
                <strong>How do we process your information? </strong>We process your information to provide, improve, and administer our Services, communicate with you, for security and fraud prevention, and to comply with law. We may also process your information for other purposes with your consent. We process your information only when we have a valid legal reason to do so.
            </p>
            <p>
                <strong>In what situations and with which parties do we share personal information? </strong>We may share information in specific situations and with specific third parties.
            </p>
            <p>
                <strong>How do we keep your information safe? </strong>We have adequate organizational and technical processes and procedures in place to protect your personal information. However, no electronic transmission over the internet or information storage technology can be guaranteed to be 100% secure, so we cannot promise or guarantee that hackers, cybercriminals, or other unauthorised third parties will not be able to defeat our security and improperly collect, access, steal, or modify your information. Learn more about how we keep your information safe.
            </p>
            <p>
                <strong>What are your rights? </strong>Depending on where you are located geographically, the applicable privacy law may mean you have certain rights regarding your personal information. Learn more about your privacy rights.
            </p>
            <p>
                <strong>How do you exercise your rights? </strong>The easiest way to exercise your rights is by submitting a data subject access request, or by contacting us. We will consider and act upon any request in accordance with applicable data protection laws.
            </p>
            <br><br>
            <h3>Information We Collect</h3>
            <p>
                <strong>Personal Identification Information:</strong>
                <ul>
                    <li>Name</li>
                    <li>Email address</li>
                    <li>Password</li>
                    <li>Profile Picture(if applicable)</li>
                </ul>
                <strong>Non-Personal Identification Information:</strong>
                <ul>
                    <li>Browser type</li>
                    <li>Internet Service Provider (ISP)</li>
                    <li>Referring/exit pages</li>
                    <li>Date/time stamps</li>
                    <li>Clickstream data</li>
                </ul>
            </p>

            <h3>Cookies and Tracking Technologies</h3>
            <p>
                <strong>What are Cookies?</strong>
                <p>Cookies are small data files placed on your device that help us improve your experience on our site.</p>
                <strong>Types of Cookies Used:</strong>
                <ul>
                    <li>Session cookies</li>
                    <li>Persistent cookies</li>
                    <li>Third-party cookies</li>
                </ul>
                <strong>Managing Cookies:</strong>
                <p>You can manage your cookie preferences through your browser settings.</p>
            </p>

            <h3>Third-Party Services</h3>
            <p>
                <strong>Third-Party Service Providers:</strong>
                <p>We may use third-party services such as payment processors and analytics services that may collect and use your personal information.</p>
                <strong>Links to Other Websites:</strong>
                <p>Our site may contain links to other websites, and we are not responsible for their privacy practices.</p>
            </p>

            <h3>Data Retention</h3>
            <p>
                <strong>How Long We Keep Your Information:</strong>
                <p>We retain personal information for as long as necessary to fulfill the purposes outlined in this policy.</p>
            </p>

            <h3>Changes to This Privacy Policy</h3>
            <p>
                <strong>Policy Updates:</strong>
                <p>We will notify users of changes to this privacy policy via email or website notification.</p>
                <strong>Effective Date:</strong>
                <p>This privacy policy is effective as of November 01, 2024.</p>
            </p>

            <h3>Contact Information</h3>
            <p>
                <strong>How to Contact Us:</strong>
                <p>If you have questions or concerns regarding this privacy policy, please contact us at mass_spm@gmail.com.</p>
                <strong>Data Protection Officer:</strong>
                <p>If applicable, you can reach our Data Protection Officer at [insert contact details].</p>
            </p>

            <h3>International Data Transfers</h3>
            <p>
                <strong>Cross-Border Data Transfers:</strong>
                <p>Your personal information may be transferred to other countries that may have different data protection laws than your country. We will ensure that any such transfers comply with applicable laws and that your personal information remains protected.</p>
            </p>

            <h3>Children's Privacy</h3>
            <p>
                <strong>Age Restrictions:</strong>
                <p>Our services are not intended for children under the age of 13. We do not knowingly collect personal information from children under 13. If we become aware that we have collected personal information from a child under 13, we will take steps to delete such information.</p>
            </p>

            <h3>Governing Law</h3>
            <p>
                <strong>Applicable Law:</strong>
                <p>This privacy policy shall be governed by and construed in accordance with the laws of [insert applicable jurisdiction].</p>
            </p>
        </section>
    </main>

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
                        <a href="#" class="nav-link">Privacy Policy</a>
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