<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Google reCAPTCHA Enterprise script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Custom styles -->
    <link rel="stylesheet" type="text/css" href="css/Login_Design.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">
                <div class="card" style="height: auto">
                    <div class="card-body">
                        <h1 class="text-center"><u>LOGIN</u></h1>
                        
                        <!-- Error message if exists -->
                        <?php if(isset($_GET['error'])): ?>
                            <p class="error"><?php echo $_GET['error']; ?></p>
                        <?php endif; ?>
                        <form id="loginForm" action="Login_Code.php" method="POST">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input class="form-control" type="text" name="username" id="username" placeholder="Username">
                        </div>
                        
                        <!-- Password input -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input class="form-control" type="password" name="pwd" id="admin_pwd" placeholder="Password">
                        </div>
                        
                        <!-- reCAPTCHA button -->
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LcAuqspAAAAAApJdnspouMh4WelaOphc_oChx_D"></div>
                        </div>
                        
                        <!-- Login button -->
						<div class="form-group">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>

                        <!-- Create Account link -->
                        <p class="text-center text-white">Don't have an account yet? <br/> 
						<a href="Home.php" class="text-white">Create AN Account Now</a></p>
							</form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript function to submit the form with reCAPTCHA response -->
    <script>
        function onSubmit(event) {
            event.preventDefault();
            grecaptcha.ready(function() {
                grecaptcha.execute('6LcAuqspAAAAAApJdnspouMh4WelaOphc_oChx_D', {action: 'submit'}).then(function(token) {
                    document.getElementById("g-recaptcha-response").value = token;
                    document.getElementById("form").submit();
                });
            });
        }
    </script>
</body>
</html>
