<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Forget Password</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Custom styles -->
    <link rel="stylesheet" type="text/css" href="css/Login_Design.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center"><u>FORGET PASSWORD</u></h1>

                        <!-- Error message if exists -->
                        <?php if(isset($_GET['error'])): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_GET['error']; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Step 1: Enter Username -->
                        <form id="usernameForm" action="send_otp.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Enter your username:</label>
                                <input class="form-control" type="text" name="username" id="username" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Send OTP</button>
                            </div>
                        </form>

                        <!-- Step 2: Enter OTP and New Password -->
                        <form id="otpForm" action="verify_otp.php" method="POST" style="display:none;">
                            <div class="mb-3">
                                <label for="otp" class="form-label">Enter OTP:</label>
                                <input class="form-control" type="text" name="otp" id="otp" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password:</label>
                                <input class="form-control" type="password" name="new_password" id="new_password" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Reset Password</button>
                            </div>
                        </form>

                        <!-- Back to Login link -->
                        <p class="text-center text-white"><a href="login.php" class="text-white">Back to Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle form display -->
    <script>
        // Function to show the OTP form after username submission
        function showOtpForm() {
            document.getElementById('usernameForm').style.display = 'none';
            document.getElementById('otpForm').style.display = 'block';
        }

        // Show the OTP form if redirected for OTP input
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('step') === 'otp') {
                showOtpForm();
            }
        };
    </script>
</body>
</html>
