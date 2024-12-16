<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="admin/assets/images/favi.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify The OTP</title>
    <link rel="stylesheet" href="style.css">

    <?php
        include('links.php');
    ?>

</head>
<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f0f0f0;
    }
    
    .container {
        background-color: white;
        padding: 60px 60px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 25%;
    }
    
    h1 {
        margin-bottom: 20px;
        margin-top: 20px;
    }
    
    .otp-form {
        display: flex;
        flex-direction: column;
    }
    
    input[type="text"] {
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        border-style: ridge;
        font-size: 18px;
    }
    
    button {
        padding: 20px;
        margin-bottom: 20px;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        background-color: #ff5e57;
        color: white;
        cursor: pointer;
        font-style: normal;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
    
    button:hover {
        background-color: #ff4343;
    }
    
    .hidden {
        display: none;
    }
    
    #resendSection {
        font-size: 14px;
        color: gray;
    }
    
    #resendOtpLink {
        color: #ff5e57;
        text-decoration: none;
        margin-left: 10px;
    }
    
    #resendOtpLink:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="container">
        <h1>Verify The OTP</h1>
        <div class="otp-form">
            <input type="text" id="mobileNumber" placeholder="Mobile Number">
            <button id="sendOtpBtn" onclick="sendOtp()">Send OTP</button>
            <div id="otpSection" class="hidden">
                <input type="text" id="otpInput" placeholder="Enter OTP" maxlength="6">
                <button id="verifyBtn" onclick="verifyOtp()">Verify</button>
                <p id="resendSection">
                    <span id="timer">00:30</span> <a href="#" id="resendOtpLink" onclick="resendOtp()">Resend OTP</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        let countdown;
        let timerElement = document.getElementById("timer");

        function sendOtp() {
            let mobileNumber = document.getElementById("mobileNumber").value;
            if (mobileNumber === "") {
                alert("Please enter a mobile number.");
                return;
            }

            alert("OTP sent to " + mobileNumber);
            document.getElementById("otpSection").classList.remove("hidden");
            startTimer(30);
        }

        function startTimer(seconds) {
            let timeLeft = seconds;
            timerElement.textContent = `00:${timeLeft < 10 ? "0" : ""}${timeLeft}`;
            countdown = setInterval(() => {
                timeLeft--;
                timerElement.textContent = `00:${timeLeft < 10 ? "0" : ""}${timeLeft}`;
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    document.getElementById("resendOtpLink").style.visibility = "visible";
                }
            }, 1000);
        }

        function resendOtp() {
            clearInterval(countdown);
            document.getElementById("resendOtpLink").style.visibility = "hidden";
            sendOtp();
        }

        function verifyOtp() {
            let otp = document.getElementById("otpInput").value;
            if (otp === "") {
                alert("Please enter the OTP.");
                return;
            }

            alert("OTP verified: " + otp);

            document.getElementById("mobileNumber").value = "";
            document.getElementById("otpInput").value = "";
            document.getElementById("otpSection").classList.add("hidden");
            clearInterval(countdown);
        }
    </script>

<script src="js/script.js"></script>


</body>

</html>