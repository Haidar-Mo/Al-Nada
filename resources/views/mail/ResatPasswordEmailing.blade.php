<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>AL-Nada Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #eaeaea;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            margin: 20px 0;
        }

        .content p {
            font-size: 16px;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            font-size: 12px;
            color: #777777;
        }

        .new-password {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIm-EY4NRgfMrybP7WfVBWPmvYj90uNlT3kZfxHVsnOMdvBpGdk5iCHIMy8opHiO9a0Ko&usqp=CAU" alt="AL-Nada Association Logo">
        </div>
        <div class="content">
            <p>Dear {{ $name }},</p>
            <p>Your password has been reset. Please use the following new password to log in to your account:</p>
            <div class="new-password">
                {{ $password }}
            </div>
            <p>We recommend that you change this password immediately after logging in.</p>
            <p>If you did not request a password reset, please contact our support team immediately.</p>
            <p>Best regards,</p>
            <p>AL-Nada Association Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} AL-Nada Association. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
