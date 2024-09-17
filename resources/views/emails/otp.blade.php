<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Your OTP Code</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

		body {
			font-family: 'Inter', sans-serif;
			background-color: #f4f4f4;
		}
	</style>
</head>

<body>
<div
	style="max-width: 600px; margin: 40px auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
	<h1 style="color: #333333; font-size: 24px; text-align: center;">Your OTP Code</h1>
	<p style="font-size: 16px; color: #555555; text-align: center;">Your OTP code is:</p>
	<p style="font-size: 36px; color: #1a202c; text-align: center; font-weight: bold; margin: 20px 0;">
		{{ $otp }}</p>
	<p style="font-size: 14px; color: #777777; text-align: center;">This code will expire in 10 minutes.</p>
	<p style="font-size: 14px; color: #777777; text-align: center; margin-top: 40px;">If you didn’t request this
		code, please ignore this email or contact support.</p>
</div>
</body>

</html>
