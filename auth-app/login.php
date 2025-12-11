<?php
require 'db.php';
session_start();

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = $conn->prepare("SELECT * FROM users WHERE email=?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user["name"];
        header("Location: dashboard.php");
        exit();
    } else {
        $msg = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width:450px;">
    <div class="card shadow p-4">
        <h2 class="text-center mb-3">Login</h2>

        <?php if($msg): ?>
            <div class="alert alert-danger"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" required class="form-control">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" required class="form-control">
            </div>

            <button class="btn btn-success w-100">Login</button>
        </form>

        <p class="text-center mt-3">Don't have an account?
            <a href="register.php">Register</a>
        </p>
    </div>
</div>

</body>
</html>
