<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Reservation Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
<div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <div style="background-color: #1e90ff; color: #ffffff; padding: 20px; text-align: center;">
        <h1 style="margin: 0; font-size: 24px;">Reminder: Your Book Reservation is Due Soon</h1>
    </div>
    <div style="padding: 20px;">
        <p style="margin-top: 0;">Hello {{ $reservation->user->name }},</p>
        <p>We hope you are enjoying the book you reserved: <strong style="color: #1e90ff;">{{ $reservation->book->title }}</strong>.</p>
        <p>This is a friendly reminder to let you know that your reservation is due in 1 day. Please make sure to return the book before the due date.</p>
        <p>If you have any questions or need assistance, feel free to contact us.</p>
        <p>Thank you for using our library services!</p>
        <p style="margin-bottom: 0;">Best regards,</p>
        <p style="margin-top: 5px; font-weight: bold; color: #1e90ff;">The Library Team</p>
    </div>
    <div style="background-color: #1e90ff; color: #ffffff; padding: 10px; text-align: center; font-size: 14px;">
        © 2024 Your Library. All rights reserved.
    </div>
</div>
</body>
</html>
