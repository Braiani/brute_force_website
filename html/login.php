<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$captcha = $_POST['captcha'] ?? '';

$valid_user = 'admin';
$valid_pass = 'password';

$_SESSION['login_attempts'] += 1;

if ($_SESSION['login_attempts'] > 3) {
    $captcha_num1 = $_SESSION['captcha_num1'];
    $captcha_num2 = $_SESSION['captcha_num2'];
    $captcha_result = $captcha_num1 + $captcha_num2;

    if ($captcha != $captcha_result) {
        $_SESSION['captcha_num1'] = rand(1, 9);
        $_SESSION['captcha_num2'] = rand(1, 9);
        
        $_SESSION['error'] = "Invalid captcha.";
        header("Location: index.php");
        exit();
    }
}

$_SESSION['captcha_num1'] = rand(1, 9);
$_SESSION['captcha_num2'] = rand(1, 9);

if ($username !== $valid_user){
    $_SESSION['error'] = "Invalid username.";
    header("Location: index.php");
    exit();
}

if ($password !== $valid_pass){
    $_SESSION['error'] = "Invalid password.";
    header("Location: index.php");
    exit();
}

$_SESSION['logged_in'] = true;
$_SESSION['login_attempts'] = 0;
header("Location: dashboard.php");
exit();