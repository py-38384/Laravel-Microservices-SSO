<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verification Code</title>
</head>
<body>
    <h2>Hello {{ $user->name ?? 'User' }},</h2>

    <p>Your verification code is:</p>

    <h1 style="color: #2d3748; font-size: 24px;">{{ $code }}</h1>

    <p>This code will expire in 5 minutes.</p>

    <p>Thank you,<br>{{ config('app.name') }}</p>
</body>
</html>
