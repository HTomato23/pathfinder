<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pathfinder | Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
        }

        .header {
            background-color: #000000;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
            text-align: center;
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc; 
            border-bottom: 1px solid #ccc; 
            border-radius: 4px;             
            background-color: #F5F7F8; 
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #41B06E;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            color: #777;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Reset Your Password</h2>
        </div>
        <div class="content">
            <p>Click the button below to reset your password:</p>
            <a href="{{ url('/admin/auth/resetpassword/' . $token) }}">Reset Password</a>
            <p class="footer">
                If you did not request a password reset, no further action is required.
            </p>
        </div>
    </div>
</body>
</html>
