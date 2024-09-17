<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
	</style>
	<title>Reset Password</title>
</head>
<body style="font-family: 'Inter', sans-serif; background-color: #f3f4f6; padding: 24px;">
<div style=" width:80%;  margin: 0 auto; background-color: #ffffff; padding: 18px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
	<h1 style="font-size: 24px; font-weight: 700; margin-bottom: 16px; color: #2d3748;">Password Reset Request</h1>
	<p style="color: #4a5568; margin-bottom: 16px;">Hello,</p>
	<p style="color: #4a5568; margin-bottom: 24px;">We received a request to reset your password. You can reset your
		password by clicking
		the link below:</p>
	<a href="{{ url('/reset-password', $token) }}" style="
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
            background-color: #3182ce;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        " onmouseover="this.style.backgroundColor='#2b6cb0'" onmouseout="this.style.backgroundColor='#3182ce'">
		Reset Password
	</a>
	<p style="color: #4a5568; margin-top: 24px;">If you did not request a password reset, please ignore this email.</p>
	<p style="color: #4a5568;">Best regards,<br>Your Company Team</p>
</div>
</body>
</html>
