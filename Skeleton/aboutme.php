<?php
include 'header.php';
include 'minue.php';
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aboat me</title> 
</head>
<body>
<style>
  body {
  font-family: "Poppins", Arial, sans-serif;
  background-color: #FEF7E4;
  color: white;
  overflow-x: hidden;
}
article {
  margin:auto;
  padding: 60px 10%;
  display: flex;
  flex-direction: column;
  gap: 70px;
  align-items: center;
  animation: fadeIn 1.2s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ABOUT ME */
.aboutMe {
  text-align: center;
  max-width: 900px;
}

.aboutMe h1 {
  font-size: 36px;
  color: #391B25;
  margin-bottom: 15px;
}

.aboutMe h2 {
  font-size: 22px;
  margin-bottom: 20px;
}

.aboutMe h2 span {
  position: relative;
  display: inline-block;
  color: transparent;
  -webkit-text-stroke: 0.7px #391B25;
  animation: display-text 16s linear infinite;
  animation-delay: calc(-3s * var(--i));
}

.aboutMe h2 span::before {
  content: attr(date-text);
  position: absolute;
  width: 0%;
  border-right: 2px solid #391B25;
  color: #391B25;
  white-space: nowrap;
  overflow: hidden;
  animation: fill-text 4s linear infinite;
}
@keyframes fill-text {
  10%, 100% { width: 0; }
  70%, 90% { width: 100%; }
}

@keyframes display-text {
  25%, 100% { display: none; }
}

#ff {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  margin-top: 30px;
  gap: 40px;
}




</style>

<article>
        <div class="aboutMe" id="about">
        <h1>Rama Jboor</h1>
        <h2>I am
            <span style="--i:3;"date-text="Software engineer">Software engineer</span>
            <span style="--i:2;" date-text="&">&</span>
            <span style="--i:1;" date-text="Problem solver">Problem solver</span>
        </h2>
        <div id="ff">
        <div id="pp">
        <p>Hi! I’m a Software Engineering student who believes coffee and Mozart can fix almost any bug.I enjoy building projects, learning new tech, and pretending I fully understand why my code suddenly works after adding one print statement</p>
        
            <ul id="contact">
                <li><a href="https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox"><img src="https://cdn2.iconfinder.com/data/icons/address-book-providers-in-colors/512/gmail-2-512.png" alt="" width="45px" height="45px"></a></li>
                <li><a href="https://www.linkedin.com/in/rama-jboor-0a365a2b9/"><img src="https://www.logo.wine/a/logo/LinkedIn/LinkedIn-Icon-Logo.wine.svg" alt="" width="45px" height="45px"></a></li>
                <li><a href="https://www.instagram.com/rama_k_jboor?igsh=MTR2YzVzeWgwaG1jcw=="><img src="https://img.freepik.com/premium-vector/instagram-vector-logo-icon-social-media-logotype_901408-392.jpg?semt=ais_hybrid&w=740&q=80" alt="" width="45px" height="45px"></a></li>
            </ul>
        
    </div>
</article> 
</body>
</html>