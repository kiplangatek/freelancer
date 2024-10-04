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
			margin: 0;
			padding: 0;
		}

		.container {
			max-width: 350px;
			margin: 40px auto;
			background-color: #ffffff;
			padding: 20px;
			border-radius: 12px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
		}

		h1 {
			color: #1a202c;
			font-size: 22px;
			font-weight: 700;
			text-align: center;
			margin-bottom: 20px;
		}

		p {
			font-size: 15px;
			color: #555555;
			text-align: center;
			line-height: 1.5;
			margin: 10px 0;
		}

		.otp-code {
			font-size: 36px;
			color: #1a202c;
			text-align: center;
			font-weight: 800;
			margin: 20px 0;
			letter-spacing: 4px;
		}

		.footer {
			font-size: 12px;
			color: #777777;
			text-align: center;
			margin-top: 30px;
		}
	</style>
</head>

<body>
	<div class="container">
		<h1>Your OTP Code</h1>
		<p>Your OTP code is:</p>
		<p class="otp-code">{{ $otp }}</p>
		<p>This code will expire in 10 minutes.</p>
		<p class="footer">
			If you didn’t request this code, please ignore this email or contact support.
		</p>
	</div>
</body>

</html>

