<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Creation Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
<div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <div style="background-color: #1e90ff; color: #ffffff; padding: 20px; text-align: center;">
        <h1 style="margin: 0; font-size: 24px;">Welcome! Your Account Has Been Created</h1>
    </div>
    <div style="padding: 20px;">
        <p style="margin-top: 0;">Hello {{ $user->name }},</p>
        <p>We are thrilled to inform you that your account has been successfully created.</p>
        <p>Here are your login credentials:</p>
        <ul style="list-style: none; padding-left: 0;">
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Password:</strong> passer@12</li>
        </ul>
        <p>You can now log in to our application and start exploring all the available features by clicking the link below:</p>
        <p style="text-align: center;">
            <a href="{{ route('auth.login') }}" style="background-color: #1e90ff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Log In to Your Account</a>
        </p>
        <p>If you have any questions or need assistance, feel free to contact us.</p>
        <p>Thank you for choosing our service!</p>
        <p style="margin-bottom: 0;">Best regards,</p>
        <p style="margin-top: 5px; font-weight: bold; color: #1e90ff;">The Support Team</p>
    </div>
    <div style="background-color: #1e90ff; color: #ffffff; padding: 10px; text-align: center; font-size: 14px;">
        © 2024 SchoolFlow. All rights reserved.
    </div>
</div>
</body>
</html>
