<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function sendVerificationCode($email, $name, $code)
{
    $mail = new PHPMailer(true);

    try {

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'justambot10@gmail.com';
        $mail->Password   = 'palautog';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender
        $mail->setFrom(
            'justambot10@gmail.com',
            'Doc Marly SQMS'
        );

        // Recipient
        $mail->addAddress($email, $name);

        // Embed logo
        $logoPath = __DIR__ . '/../assets/images/seal.png';

        if (file_exists($logoPath)) {
            $mail->addEmbeddedImage(
                $logoPath,
                'logo'
            );
        }

        $mail->isHTML(true);

        $mail->Subject = 'Your Verification Code';

        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Email Verification</title>
        </head>

        <body style="
            margin:0;
            padding:0;
            background:#f4f6f8;
            font-family:Arial, Helvetica, sans-serif;
        ">

            <div style="
                max-width:600px;
                margin:40px auto;
                background:#ffffff;
                border-radius:15px;
                overflow:hidden;
                box-shadow:0 5px 20px rgba(0,0,0,0.08);
            ">

                <div style="
                    background:#b30000;
                    padding:30px;
                    text-align:center;
                ">

                    <img
                        src="cid:logo"
                        alt="Logo"
                        style="
                            max-width:120px;
                            max-height:80px;
                        "
                    >

                </div>

                <div style="padding:40px 35px;">

                    <h2 style="
                        color:#333333;
                        margin-top:0;
                    ">
                        Email Verification
                    </h2>

                    <p style="
                        color:#555555;
                        font-size:15px;
                        line-height:1.6;
                    ">
                        Hello <strong>' . htmlspecialchars($name) . '</strong>,
                    </p>

                    <p style="
                        color:#555555;
                        font-size:15px;
                        line-height:1.6;
                    ">
                        We received a request to sign in to your account.
                        Please use the verification code below:
                    </p>

                    <div style="
                        margin:30px 0;
                        text-align:center;
                    ">

                        <div style="
                            display:inline-block;
                            background:#f8f8f8;
                            border:2px dashed #b30000;
                            border-radius:12px;
                            padding:20px 35px;
                        ">

                            <span style="
                                font-size:36px;
                                font-weight:bold;
                                letter-spacing:8px;
                                color:#b30000;
                            ">
                                ' . $code . '
                            </span>

                        </div>

                    </div>

                    <p style="
                        color:#777777;
                        font-size:14px;
                        text-align:center;
                    ">
                        This verification code will expire in
                        <strong>10 minutes</strong>.
                    </p>

                    <p style="
                        color:#777777;
                        font-size:13px;
                        line-height:1.6;
                    ">
                        If you did not attempt to sign in, you can safely
                        ignore this email.
                    </p>

                </div>

                <div style="
                    background:#f8f8f8;
                    padding:20px;
                    text-align:center;
                    color:#999999;
                    font-size:12px;
                ">
                    © ' . date('Y') . ' Doc Marly SQMS
                </div>

            </div>

        </body>
        </html>
        ';

        $mail->AltBody =
            "Your verification code is: $code";

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;
    }
}