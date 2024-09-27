<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>New Changes to Account</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
			padding: 20px;
		}

		.container {
			background-color: white;
			border-radius: 10px;
			padding: 20px;
			max-width: 600px;
			margin: auto;
		}

		.header {
			font-size: 24px;
			color: #333;
		}

		.content {
			font-size: 16px;
			color: #555;
			margin-top: 10px;
		}

		.button {
			display: inline-block;
			margin-top: 20px;
			padding: 10px 15px;
			background-color: #4CAF50;
			color: white;
			text-decoration: none;
			border-radius: 5px;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="header">
		New Changes to Account
	</div>
	<div class="content">
		<b>Dear User,</b> <br><br>
		We are shifting to username rather than public emails for security.
		It looks like your account does not have a username. To continue using our services smoothly, you are required
		to create one.

		<br><br>
		Please log in to your account, navigate to the "Update Profile" section, and create a username.

		<br><br>
		<a href="{{ url('/login') }}" class="button">Login to Your Account</a>
	</div>
</div>
</body>
</html>
