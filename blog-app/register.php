<?php
require 'db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $pass  = trim($_POST["password"]);

    // Check duplicate email
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $msg = "Email already registered!";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $sql = $conn->prepare("INSERT INTO users(name, email, password) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $name, $email, $hash);

        if ($sql->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $msg = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width:500px;">
    <div class="card shadow p-4">
        <h2 class="text-center mb-3">Create Account</h2>

        <?php if($msg): ?>
            <div class="alert alert-info"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" required class="form-control">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" required class="form-control">
            </div>

            <!-- Password with Eye -->
            <div class="mb-3">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" required class="form-control">
                    <span class="input-group-text" style="cursor:pointer" onclick="togglePassword()">
                        <i id="eyeIcon" class="bi bi-eye"></i>
                    </span>
                </div>

                <small id="strengthText" class="text-muted"></small>

                <div class="progress mt-2">
                    <div id="strengthBar" class="progress-bar" role="progressbar"></div>
                </div>
            </div>

            <button class="btn btn-primary w-100">Register</button>
        </form>

        <p class="text-center mt-3">
            Already have an account? <a href="login.php">Login</a>
        </p>
    </div>
</div>

<script>
// Show / Hide Password
function togglePassword() {
    const pass = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (pass.type === "password") {
        pass.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        pass.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}

// Password Strength Meter
const passInput = document.getElementById("password");
const bar = document.getElementById("strengthBar");
const txt = document.getElementById("strengthText");

passInput.addEventListener("input", () => {
    let value = passInput.value;
    let strength = 0;

    
    if (/[A-Z]/.test(value)) strength++;
    if (value.length >= 6){ strength++;
    if (/[0-9]/.test(value)) strength++;
    if (/[^A-Za-z0-9]/.test(value)) strength++;
    }
    bar.style.width = (strength * 25) + "%";

    if (strength === 0) { bar.className="progress-bar"; txt.innerText=""; }
    if (strength === 1) { bar.className="progress-bar bg-danger"; txt.innerText="Weak"; }
    if (strength === 2) { bar.className="progress-bar bg-warning"; txt.innerText="Medium"; }
    if (strength === 3) { bar.className="progress-bar bg-info"; txt.innerText="Strong"; }
    if (strength === 4) { bar.className="progress-bar bg-success"; txt.innerText="Very Strong"; }
});
</script>

</body>
</html>
