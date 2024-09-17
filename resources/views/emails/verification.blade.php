<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Verification</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

		body {
			font-family: 'Inter', sans-serif;
			background-color: #f8f9fa;
			color: #333;
			margin: 0;
			padding: 0;
		}

		.container {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background: #fff;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		.header {
			background-color: #007bff;
			color: #fff;
			padding: 20px;
			text-align: center;
			border-radius: 8px 8px 0 0;
		}

		.header svg {
			width: 50px;
			height: 50px;
			margin-bottom: 10px;
		}

		.content {
			padding: 30px;
			text-align: center;
		}

		.content p {
			font-size: 1.1rem;
			line-height: 1.6;
		}

		.footer {
			text-align: center;
			padding: 20px;
			background-color: #f1f1f1;
			border-radius: 0 0 8px 8px;
			margin-top: 30px;
		}

		.footer img {
			width: 100px;
			margin-top: 10px;
		}
	</style>
</head>

<body>
<div class="container">
	<div class="header">
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
		</svg>
		<h1>Verification</h1>
	</div>
	<div class="content">
		<p>Hey, guess who just got verified, {{ $name }}. Congratulations, you are now verified!</p>
		<p>Your verification is now complete. You have access to all our features and services.</p>
	</div>
	<div class="footer">
		<p>Thank you for being with us.</p>
		<img src="https://github.com/vybekid1/fcs/blob/main/assets/images/logo.png?raw=true" alt="Company Logo">
	</div>
</div>
</body>

</html>
