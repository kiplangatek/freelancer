<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Create Your First Service</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

		body {
			font-family: 'Inter', sans-serif;
			background-color: #f9f9f9;
			margin: 0;
			padding: 0;
			color: #333;
		}

		.container {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #ffffff;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		.header {
			text-align: center;
			padding: 20px 0;
		}

		.header img {
			height: 50px;
		}

		.content {
			padding: 20px;
			text-align: center;
		}

		.content h1 {
			font-size: 24px;
			margin-bottom: 20px;
			color: #2c3e50;
		}

		.content p {
			font-size: 16px;
			margin-bottom: 20px;
			line-height: 1.5;
		}

		.btn {
			display: inline-block;
			padding: 12px 24px;
			background-color: #3490dc;
			color: #ffffff;
			text-decoration: none;
			border-radius: 6px;
			font-weight: 600;
		}

		.footer {
			padding: 20px;
			text-align: center;
			font-size: 12px;
			color: #777;
		}

		.footer p {
			margin: 0;
		}
	</style>
</head>

<body>
<div class="container">
	<div class="header">
		<img src="https://github.com/vybekid1/fcs/blob/main/assets/images/logo.png?raw=true" alt="Company Logo">
	</div>
	<div class="content">
		<h1>Create Your First Service</h1>
		<p>Hi {{ $freelancer->name }},</p>
		<p>We noticed that you haven't created any services yet on our platform. To get started and attract clients,
			it's important to create at least one service.</p>
		<p>Creating a service is easy and helps you showcase your skills to potential clients. Don’t miss out on
			opportunities to grow your freelance business!</p>
		<a href="{{ url('/my')}}" class="btn" >Create Service Now</a>
	</div>
	<div class="footer">
		<p>If you have any questions or need assistance, feel free to contact our support team.</p>
		<p>&copy; {{ date('Y') }} FCS. All rights reserved.</p>
	</div>
</div>
</body>

</html>
