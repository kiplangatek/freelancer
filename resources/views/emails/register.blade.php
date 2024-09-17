<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration Confirmation</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

		body {
			font-family: 'Inter', sans-serif;
			background-color: #f7fafc;
			margin: 0;
			padding: 0;
		}

		.container {
			max-width: 600px;
			margin: 40px auto;
			padding: 20px;
			background-color: #ffffff;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		h1 {
			font-size: 24px;
			color: #2d3748;
			margin-bottom: 20px;
		}

		p {
			font-size: 16px;
			color: #4a5568;
			line-height: 1.5;
			margin-bottom: 20px;
		}

		.text-sm {
			font-size: 14px;
			color: #4a5568;
		}

		.font-bold {
			font-weight: 700;
		}

		.border-t {
			border-top: 1px solid #e2e8f0;
			padding-top: 20px;
			margin-top: 20px;
		}

		.text-center {
			text-align: center;
		}

		.text-blue-600 {
			color: #3182ce;
			text-decoration: none;
		}

		.text-blue-600:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
<div class="container">
	<section>
		<h1 class="font-bold">Hello {{ $user->name }},</h1>
		<p>Thank you for registering on our platform. We are excited to have you on board!</p>
		<p>You are registered as <strong>{{ $user->usertype }}</strong>.</p>
		<p>Best regards,<br>The Team</p>
	</section>
	<div class="border-t text-center text-sm">
		<p>If you have any questions, feel free to
			<a href="mailto:edwin@tablink.co.ke" class="text-blue-600">Contact us</a>.
		</p>
	</div>
</div>
</body>
</html>
