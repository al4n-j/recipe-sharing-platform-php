<?php
// db.php - Include this file for database connection
include 'db.php';
session_start();

$error = "";  // To store login errors
$registration_success = ""; // To show registration success message
$show_register = false; // Flag to trigger the registration form if email is invalid

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit();
    } else {
        // If user not found, trigger the registration form to show with animation
        $error = "Invalid email or password.";
        $show_register = true;
    }
}

// Handle registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$username, $email, $password])) {
        $registration_success = "Registration successful! Please log in.";
        $show_register = false;
    } else {
        $error = "Error registering user.";
        $show_register = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
<div class="main">
  <h1>Recipe Sharing Platform<div class="roller">
    <span id="rolltext">COOK<br/>
    SHARE<br/>
    Discover<br/>
    <span id="spare-time">Fall in Love with Cooking!</span><br/>
    </div>
    </h1>
    
  </div>
<div class="container <?php echo $show_register ? 'right-panel-active' : ''; ?>" id="container">
	<div class="form-container sign-up-container">
		<form method="POST" action="">
			<h1>Create Account</h1>
			<input type="text" name="username" placeholder="Username" required>
			<input type="email" name="email" placeholder="Email" required>
			<input type="password" name="password" placeholder="Password" required>
			<button type="submit" name="register">Sign Up</button>
			<?php if ($registration_success): ?>
				<p style="color:green;"><?php echo $registration_success; ?></p>
			<?php endif; ?>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form method="POST" action="">
			<h1>Sign in</h1>
			<input type="email" name="email" placeholder="Email" required />
			<input type="password" name="password" placeholder="Password" required />
			<?php if ($error): ?>
				<p style="color:red;"><?php echo $error; ?></p>
			<?php endif; ?>
			<button type="submit" name="login">Sign In</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    // Check PHP variable to trigger the registration form with animation
    <?php if ($show_register): ?>
        container.classList.add("right-panel-active");
    <?php endif; ?>

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>
</body>
</html>
