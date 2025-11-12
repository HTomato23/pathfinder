<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
        }
        .label {
            font-weight: bold;
            color: #495057;
        }
        .message-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0; color: #212529;">New Contact Form Submission</h2>
    </div>
    
    <div class="content">
        <p><span class="label">From:</span> {{ $name }}</p>
        <p><span class="label">Email:</span> <a href="mailto:{{ $email }}">{{ $email }}</a></p>
        <p><span class="label">Subject:</span> {{ $subject }}</p>
        
        <div class="message-box">
            <p class="label">Message:</p>
            <p style="margin: 10px 0 0 0; white-space: pre-line;">{{ $messageContent }}</p>
        </div>
    </div>
</body>
</html>