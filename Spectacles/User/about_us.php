<?php
session_start();
include("NavBar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Visionary Eyewear</title>
  <style>
    body {
        font-family: 'Times New Roman', serif;
        background-color: #001f3f;
        color: #fff;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    .section {
        margin-bottom: 30px;
        padding: 20px;
        background-color: #fff;
        color: #333;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        width: 48%;
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .section.visible {
        opacity: 1;
        transform: translateY(0);
    }
    h1 {
        font-size: 2.5em;
        text-align: center;
        margin-bottom: 20px;
        color: #4A90E2;
    }
    h2 {
        font-size: 1.8em;
        margin-top: 0;
    }
    p {
        line-height: 1.6;
        margin: 10px 0;
    }
    ul {
        list-style-type: disc;
        padding-left: 20px;
    }
    li {
        margin: 5px 0;
    }
    .story h2 {
        color: #E94E77;
    }
    .collection h2 {
        color: #3C763D;
    }
    .commitment h2 {
        color: #F39C12;
    }
    .choose-us h2 {
        color: #9B59B6;
    }
    .about-us {
        text-align: center;
        margin-bottom: 50px;
    }
    .left {
        float: left;
        clear: both;
    }
    .right {
        float: right;
        clear: both;
    }
  </style>
</head>
<body>
    <div class="container">
        <div class="about-us">
            <h1>About Us</h1>
            <p>Welcome to Visionary Eyewear, where style meets precision. We believe that the perfect pair of glasses is not just about clear vision—it's about expressing who you are. Our mission is to provide you with eyewear that enhances your lifestyle, offering both exceptional quality and cutting-edge style.</p>
        </div>
        
        <div class="section story left">
            <h2>Our Story</h2>
            <p>Founded in 2015, Visionary Eyewear began with a simple idea: to revolutionize the way people see the world. Frustrated with the limited choices and high prices in the market, our founders set out to create a brand that offers stylish, high-quality eyewear at accessible prices. Today, we are proud to have grown into a trusted name, beloved by customers around the globe.</p>
        </div>
        
        <div class="section collection right">
            <h2>Our Collection</h2>
            <p>At Visionary Eyewear, we offer a diverse range of glasses that cater to every taste and need. Whether you're looking for classic frames, modern designs, or something uniquely you, we have the perfect pair. Our collection features:</p>
            <ul>
                <li><strong>Prescription Glasses:</strong> Tailored to your exact needs with a focus on comfort and durability.</li>
                <li><strong>Sunglasses:</strong> Combining UV protection with the latest trends to keep you looking and feeling great.</li>
                <li><strong>Blue Light Glasses:</strong> Designed to reduce eye strain from digital screens, perfect for your modern lifestyle.</li>
            </ul>
        </div>
        
        <div class="section commitment left">
            <h2>Our Commitment</h2>
            <p>Quality is at the heart of everything we do. Each pair of glasses is crafted with precision, using the finest materials and advanced technology. We partner with skilled artisans and top optical experts to ensure every product meets our rigorous standards.</p>
        </div>
        
        <div class="section choose-us right">
            <h2>Why Choose Us?</h2>
            <ul>
                <li><strong>Style and Innovation:</strong> Stay ahead of the trends with our constantly updated collection.</li>
                <li><strong>Customer-Centric:</strong> Your satisfaction is our top priority. From seamless online shopping to exceptional customer service, we're here for you every step of the way.</li>
                <li><strong>Affordable Luxury:</strong> We believe that great eyewear shouldn't break the bank. Enjoy premium quality at prices you'll love.</li>
            </ul>
        </div>
        
        <div class="section" style="clear: both;">
            <p>Thank you for choosing Visionary Eyewear. See the world differently with us.</p>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sections = document.querySelectorAll(".section");

            const revealOnScroll = () => {
                const scrollPosition = window.pageYOffset + window.innerHeight;
                sections.forEach(section => {
                    if (section.offsetTop < scrollPosition) {
                        section.classList.add("visible");
                    }
                });
            };

            window.addEventListener("scroll", revealOnScroll);
            revealOnScroll(); // Initial check in case sections are already in view
        });
    </script>
</body>
</html>
