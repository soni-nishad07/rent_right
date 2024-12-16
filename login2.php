<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="admin/assets/images/favi.ico" type="image/x-icon">
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <?php include('links.php'); ?>
</head>

<body>
    <!-- Register Section -->
    <div class="container" id="signup">
        <h1 class="form-title">Register</h1>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="fName" name="name" placeholder="Enter Your Full Name" required>
                <label for="fName">Enter Full Name</label>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="rEmail" name="emailaddress" placeholder="Email" required>
                <label for="rEmail">Email</label>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-phone"></i>
                <input type="number" id="phone" name="phonenumber" placeholder="Enter Phone Number" required>
                <label for="phone">Phone Number</label>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="rPassword" name="password" placeholder="Password" required>
                <label for="rPassword">Password</label>
            </div>

            <button class="btn" name="Signup">Sign Up</button>
        </form>
        <p class="or">----------or----------</p>
        <div class="icons">
            <div id="gSignInWrapper">
                <div id="googleSignIn" class="customGPlusSignIn">
                    <i class="fab fa-google"></i>
                    <span>Sign in with Google</span>
                </div>
            </div>
        </div>
        <div class="links">
            <p>Already have an account?</p>
            <button id="signInButton">Sign In</button>
        </div>
    </div>

    <!-- Login Section -->
    <div class="container" id="signIn" style="display:none;">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" placeholder="Email" name="emailaddress" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" placeholder="Password" name="password" required>
                <label for="password">Password</label>
            </div>
            <button class="btn" name="Login">Sign In</button>
        </form>
        <p class="or">----------or----------</p>
        <div class="icons">
            <div id="gSignInWrapper">
                <div id="googleSignIn" class="customGPlusSignIn">
                    <i class="fab fa-google"></i>
                    <span>Sign in with Google</span>
                </div>
            </div>
        </div>
        
        
        <div id="g_id_onload"
     data-client_id="228853359778-llh5uqf3dgqsuau294bmjekh83tcp0f5.apps.googleusercontent.com"
     data-login_uri="https://wype.site/users/user-dashboard"
     data-auto_prompt="false">
</div>

<div class="g_id_signin"
     data-type="standard"
     data-shape="rectangular"
     data-theme="outline"
     data-text="sign_in_with"
     data-size="large"
     data-logo_alignment="left">
</div>

        
        <div class="links">
            <p>Don't have an account yet?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>

    <!-- Google Sign-In -->
    <script>
        function handleCredentialResponse(response) {
            const responsePayload = decodeJwtResponse(response.credential);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "google-login.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    window.location.href = 'https://wype.site/users/user-dashboard';
                } else {
                    alert('Login failed. Please try again.');
                }
            };
            xhr.send('id_token=' + response.credential);
        }

        function decodeJwtResponse(token) {
            const base64Url = token.split('.')[1];
            const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            const jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
            return JSON.parse(jsonPayload);
        }

        window.onload = function () {
            google.accounts.id.initialize({
                client_id: "228853359778-llh5uqf3dgqsuau294bmjekh83tcp0f5.apps.googleusercontent.com",
                callback: handleCredentialResponse
            });

            google.accounts.id.renderButton(
                document.getElementById("googleSignIn"),
                { theme: "outline", size: "large" }
            );
        };
    </script>
    <script src="js/script.js"></script>
</body>

</html>
