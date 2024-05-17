<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header("Location: dashboard.php");
    exit();
}

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

$show_captcha = $_SESSION['login_attempts'] >= 3;
$hasAlert = isset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if ($hasAlert): ?>
    <div class="alert">
        <?php echo $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="login.php" method="post">
        <h2>Login</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required autofocus>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <?php if ($show_captcha): ?>
        <label for="captcha">Captcha: <?php echo $_SESSION['captcha_num1']; ?> + <?php echo $_SESSION['captcha_num2']; ?>?</label>
        <input type="text" id="captcha" name="captcha" required>
        <?php endif; ?>

        <button type="submit">Login</button>
    </form>
</body>
</html>
