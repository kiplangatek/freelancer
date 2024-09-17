<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Password Reset Confirmation</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
			margin: 0;
			padding: 0;
		}

		.container {
			width: 95%;
			max-width: 96%;
			margin: auto;
			background: #fff;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		h1 {
			color: #333;
		}

		p {
			color: #555;
		}

		.footer {
			font-size: 12px;
			color: #aaa;
			text-align: center;
			margin-top: 20px;
		}
	</style>
</head>
<body>
<div class="container">
	<h1>Your Password Has Been Reset</h1>
	<p>Hello,</p>
	<p>We want to let you know that your password has been successfully reset. If you did not request this change,
		please contact our support team immediately.</p>
	<p>Thank you!</p>
	<div class="footer"> F
		<p> &copy;{{ date('Y') }} FCS. All rights reserved.</p>
	</div>
</div>
</body>
</html>
