<?php

session_start();

if (
    !isset($_SESSION['verification_user_id']) ||
    !isset($_SESSION['verification_code'])
) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Verify Email</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            min-height: 100vh;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .verify-card {
            width: 100%;
            max-width: 430px;
            border: none;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,.1);
        }

        .verify-body {
            padding: 40px;
            text-align: center;
        }

        .otp-input {
            height: 60px;
            text-align: center;
            font-size: 28px;
            letter-spacing: 10px;
            border-radius: 12px;
        }

        .verify-btn {
            height: 50px;
            border: none;
            border-radius: 12px;
            background: #b30000;
            color: white;
            font-weight: 600;
        }

        .verify-btn:hover {
            background: #8a0000;
        }

    </style>

</head>

<body>

<div class="card verify-card">

    <div class="verify-body">

        <h3 class="mb-3">
            Verify Your Email
        </h3>

        <p class="text-muted mb-4">
            We've sent a 6-digit verification code
            to your email address.
        </p>

        <?php if (isset($_SESSION['error'])): ?>

            <div class="alert alert-danger">

                <?= htmlspecialchars($_SESSION['error']) ?>

            </div>

            <?php unset($_SESSION['error']); ?>

        <?php endif; ?>

        <form
            method="POST"
            action="verify.php"
        >

            <input
                type="text"
                name="code"
                class="form-control otp-input mb-4"
                maxlength="6"
                pattern="[0-9]{6}"
                inputmode="numeric"
                placeholder="000000"
                required
            >

            <button
                type="submit"
                class="btn verify-btn w-100"
            >
                Verify Code
            </button>

        </form>

        <div class="mt-4">

            <a href="login.php"
               class="text-decoration-none">
                Back to Login
            </a>

        </div>

    </div>

</div>

</body>

</html>

<?php

/*
|--------------------------------------------------------------------------
| Process OTP
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $code = trim($_POST['code'] ?? '');

    if (!preg_match('/^\d{6}$/', $code)) {

        $_SESSION['error'] =
            'Please enter a valid 6-digit code.';

        header('Location: verify.php');
        exit;
    }

    if (
        !isset($_SESSION['verification_expires']) ||
        time() > $_SESSION['verification_expires']
    ) {

        $_SESSION['error'] =
            'The verification code has expired.';

        header('Location: verify.php');
        exit;
    }

    if (
        !password_verify(
            $code,
            $_SESSION['verification_code']
        )
    ) {

        $_SESSION['error'] =
            'Incorrect verification code.';

        header('Location: verify.php');
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Verification successful
    |--------------------------------------------------------------------------
    */

    $_SESSION['user_id'] =
        $_SESSION['verification_user_id'];

    unset(
        $_SESSION['verification_user_id'],
        $_SESSION['verification_code'],
        $_SESSION['verification_expires']
    );

    header('Location: dashboard.php');
    exit;
}
?>