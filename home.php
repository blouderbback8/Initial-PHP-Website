<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - BJJ Fighter Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <h1 class="site-title">BJJ Fighter Tracker</h1>
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About this site</a></li>
                <li><a href="contacts.php">Contact Us</a></li>
                <li><a href="admin.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Login/Signup Section -->
    <div class="wrapper">
        <div class="title-text">
            <div class="title login">Login Form</div>
            <div class="title signup">Signup Form</div>
        </div>
        <div class="form-container">
            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Login</label>
                <label for="signup" class="slide signup">Signup</label>
                <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
                <form action="login.php" method="POST" class="login">
                    <div class="field">
                        <input type="text" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="pass-link"><a href="#">Forgot password?</a></div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" name="login" value="Login">
                    </div>
                    <div class="signup-link">Not a member? <a href="">Signup now</a></div>
                </form>
                <form action="home.php" method="POST" class="signup">
                    <div class="field">
                        <input type="text" name="first_name" placeholder="First Name" required>
                    </div>
                    <div class="field">
                        <input type="text" name="last_name" placeholder="Last Name" required>
                    </div>
                    <div class="field">
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" name="register" value="Signup">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Video Section -->
    <div class="main-content">
        <section class="overview">
            <video width="800" controls>
                <source src="Home%20Page%20Maya%20-%20Gym%20Move.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </section>
    </div>

    <script src="auth.js"></script>
</body>
</html>
