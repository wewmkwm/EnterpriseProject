<!DOCTYPE html>
<html lang="en">
	<!--Testing Country Code-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>
	
	
<!--Start Here--> 
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
	html, body {margin: 0; height: 100%; overflow: hidden}
    .no-gutters {
        margin-right: 0;
        margin-left: 0;
    }
.col {
    flex: 1 0 0%;
    padding: 0;
}
	.container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
    width: auto;
    padding-left: 200px;
    padding-right: 200px;
		padding-top: 130px;
}
</style>
</head>
<body>

    <div class="row no-gutters">
        <div class="col">
            <!--<img src="Picture/Nav-Sunglasses_2.jpeg" class="img-fluid" alt="Image">-->
        </div>
        <div class="col">
            <div class="container">
                <h1>Registration</h1>
                <form method="post" action="register_code.php" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
					
                    <div class="mb-3">
                        <label for="phonenumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phonenumber" name="phonenumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <div id="password_error" class="text-danger"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>

<script>
function validateForm() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;

    if (password !== confirm_password) {
        document.getElementById("password_error").innerText = "Passwords do not match";
        return false;
    } else {
        document.getElementById("password_error").innerText = "";
        return true;
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
