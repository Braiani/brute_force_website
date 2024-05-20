<?php
session_start();

function login($username, $password, $captcha){
    $valid_user = 'juanita';
    $valid_pass = 'ilovemyself';

    if (!verifyCaptcha($captcha)){
        $_SESSION['error'] = "Invalid captcha.";
        return;
    }

    if ($username !== $valid_user){
        $_SESSION['error'] = "Invalid username.";
        generateCaptcha();
        return;
    }
    
    if ($password !== $valid_pass){
        $_SESSION['error'] = "Invalid password.";
        generateCaptcha();
        return;
    }
    $_SESSION['logged_in'] = true;
}

function generateCaptcha(){
    $_SESSION['captcha_num1'] = rand(1, 9);
    $_SESSION['captcha_num2'] = rand(1, 9);
}

function verifyCaptcha($response){
    $captcha_num1 = $_SESSION['captcha_num1'];
    $captcha_num2 = $_SESSION['captcha_num2'];
    $captcha_result = $captcha_num1 + $captcha_num2;

    return $response == $captcha_result;
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header("Location: dashboard.php");
    exit();
}


$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$captcha = $_POST['captcha'] ?? '';

if($username != '' and $password != ''){

    login($username, $password, $captcha);

}else{
    generateCaptcha();
}

echo var_dump($_REQUEST);

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

    <form action="/" method="post">
        <h2>Login</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required autofocus>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="captcha">Captcha: <?php echo $_SESSION['captcha_num1']; ?> + <?php echo $_SESSION['captcha_num2']; ?> = ?</label>
        <input type="text" id="captcha" name="captcha" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>
