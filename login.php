<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - Doc Marly SQMS</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            min-height: 100vh;
            background: #f4f6f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.10);
            overflow: hidden;
        }

        .login-header {
            background: #b30000;
            padding: 35px;
            text-align: center;
            color: white;
        }

        .login-header img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .login-body {
            padding: 35px;
        }

        .form-control {
            height: 50px;
            border-radius: 12px;
        }

        .login-btn {
            height: 50px;
            border-radius: 12px;
            background: #b30000;
            border: none;
            color: white;
            font-weight: 600;
        }

        .login-btn:hover {
            background: #8a0000;
        }

    </style>

</head>

<body>

<div class="card login-card">

    <div class="login-header">

        <img
            src="assets/images/logo.png"
            alt="Logo"
        >

        <h3 class="mb-1">
            Doc Marly SQMS
        </h3>

        <small>
            Sign in to your account
        </small>

    </div>

    <div class="login-body">

        <?php if (isset($_SESSION['error'])): ?>

            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>

            <?php unset($_SESSION['error']); ?>

        <?php endif; ?>

        <form
            method="POST"
            action="authenticate.php"
        >

            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Enter your email"
                    required
                >

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter your password"
                    required
                >

            </div>

            <button
                type="submit"
                class="btn login-btn w-100"
            >
                Sign In
            </button>

        </form>

    </div>

</div>

</body>

</html>