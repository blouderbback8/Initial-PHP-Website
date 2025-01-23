<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hash Generator</title>
</head>
<body>
    <h1>Password Hash Generator</h1>
    <form method="POST">
        <label for="password">Enter Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Generate Hash</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        echo "<h2>Generated Hash:</h2>";
        echo "<p>$hash</p>";
    }
    ?>
</body>
</html>
