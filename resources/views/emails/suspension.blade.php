<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $status === 'suspended' ? 'Account Suspension Notification' : 'Account Restore Notification' }}</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

		body {
			font-family: 'Inter', sans-serif;
			background-color: #f9f9f9;
			margin: 0;
			padding: 0;
		}

		.container {
			max-width: 600px;
			margin: 20px auto;
			padding: 20px;
			background-color: #ffffff;
			border: 1px solid #ddd;
			border-radius: 8px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		.header {
			padding: 15px;
			border-radius: 8px 8px 0 0;
			display: flex;
			align-items: center;
			color: #ffffff;
			font-size: 20px;
			background-color: {{ $status === 'suspended' ? '#e53e3e' : '#38a169' }};
		}

		.header ion-icon {
			margin-right: 10px;
			font-size: 24px;
		}

		.content {
			margin-top: 20px;
			color: #333;
			line-height: 1.6;
		}

		.footer {
			padding: 10px;
			margin-top: 20px;
			font-size: 14px;
			color: #777777;
		}
	</style>
</head>

<body>
<div class="container">
	<div class="header">
		<ion-icon name="{{ $status === 'suspended' ? 'warning-outline' : 'checkmark-circle' }}"></ion-icon>
		<h1>{{ $status === 'suspended' ? 'Account Suspended' : 'Account Restored' }}</h1>
	</div>
	<div class="content">
		<p>Hello {{ $name }},</p>
		@if ($status === 'suspended')
			<p>After a review, our team has decided to suspend your account. If you feel like this was a mistake,
				please file a complaint with our support team.</p>
			<p>Your complaint could take up to 5 working days. As your account is suspended, you can’t log in.
				@if ($user->usertype === 'freelancer')
					Note Users can't  apply for your services.
				@endif
			</p>
		@else
			<p>After a review, your account has been restored. The team has worked to analyze the reports and will
				follow up further.</p>
			<p>Please note that if you are suspended 3 times, your account will be permanently disabled, and all your
				information will be deleted. Ensure you follow all our Terms of Service.</p>
		@endif
	</div>
	<div class="footer">
		<p>Best regards,<br>The Team</p>
	</div>
</div>
</body>

</html>
