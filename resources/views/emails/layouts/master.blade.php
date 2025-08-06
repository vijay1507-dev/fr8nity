<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
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
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        .content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 0.9em;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ config('app.url') }}/images/logo_png.png" alt="Fr8nity" class="logo">
    </div>

    <div class="content">
        {!! $content !!}
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Fr8nity. All rights reserved.</p>
        <p>This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.</p>
    </div>
</body>
</html> 