<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $time = date('d/m/Y H:i:s');
    file_put_contents('data/rankings.txt', "$name, $time\n", FILE_APPEND);
}

$rankings = file('data/rankings.txt');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Welcome, you are logged in!</h2>
    <form action="dashboard.php" method="post">
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Submit</button>
    </form>
    <h3>Rankings</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Time</th>
        </tr>
        <?php foreach ($rankings as $ranking): ?>
        <?php list($name, $time) = explode(',', $ranking); ?>
        <tr>
            <td><?php echo htmlspecialchars($name); ?></td>
            <td><?php echo htmlspecialchars($time); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
