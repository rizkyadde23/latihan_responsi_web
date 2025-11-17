<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="container" style="max-width: 420px;">
        <div class="card shadow p-4">

            <h3 class="text-center mb-3 fw-bold">Sign In</h3>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="../login.php" method="POST">

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">Login</button>

                <p class="text-center mt-3 mb-0">
                    Don't have an account?
                    <a href="register_form.php" class="text-decoration-none">Register</a>
                </p>

            </form>

        </div>
    </div>
</body>

</html>