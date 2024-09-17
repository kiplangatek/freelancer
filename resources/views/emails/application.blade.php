<!DOCTYPE html>
<html>
<head>
	<title>New Application Notification</title>
	<style>

		@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

		body {
			font-family: 'Inter', sans-serif;
			background-color: #f4f4f4;
			margin: 0;
			padding:6px;
		}

		.email-container {
			background-color: #ffffff;
			border: none;
			border-radius: 10px;
			max-width: 85%;
			margin: 0 auto;
			padding: 10px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			overflow: hidden;
		}

		.header {
			background-color: #2c3e50;
			color: #ecf0f1;
			padding: 20px;
			text-align: center;
			border-radius: 10px 10px 0 0;
		}

		h1 {
			margin: 0;
			font-size: 28px;
			font-weight: bold;
		}

		h3 {
			margin: 0;
			font-size: 20px;
			color: #34495e;
		}

		p {
			font-size: 16px;
			line-height: 1.2;
			color: #7f8c8d;
		}

		.cta {
			display: inline-block;
			background-color: #3498db;
			color: #ffffff;
			text-decoration: none;
			padding: 12px 25px;
			border-radius: 18px;
			font-size: 16px;
			margin-top: 20px;
			font-weight: bold;
			transition: background-color 0.3s ease;
		}

		.cta:hover {
			background-color: #2980b9;
		}

		.footer {
			margin-top: 40px;
			font-size: 14px;
			color: #bdc3c7;
			text-align: center;
		}

		.content-wrapper {
			padding: 16px;
		}

		/* Add responsiveness */
		@media (max-width: 550px) {
			.email-container {
				width: 100% !important;
				padding: 15px !important;
			}

			h1 {
				font-size: 24px;
			}

			h3, p {
				font-size: 16px;
			}

			.cta {
				padding: 10px 20px;
			}
		}
	</style>
</head>
<body>
<div class="email-container">
	<div class="header">
		<h1>New Application Notification</h1>
	</div>
	<div class="content-wrapper">
		<h3>Dear {{ $service->freelancer->name }},</h3>
		<p>You have received a new application for your service:</p>
		<p><strong>Service Name:</strong> {{ $service->title }}</p>
		<p><strong>Applicant Name:</strong> {{ Auth::user()->name }}</p>
		<p>Please log in to your account to view and respond to the application.</p>
		<a href="http://freelancer.test/my" class="cta">View Application</a>
	</div>
	<div class="footer">
		<p>&copy; {{ date('Y') }} FCS. All rights reserved.</p>
	</div>
</div>
</body>
</html>
