<?php
	$title = "Admin Login Page";
	include 'header.php';

	if(isset($_SESSION['user']))
		header("Location: admin/dashboard.php");
?>
<body>

<div class="container" style="padding-top:50px;">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6 page-title white aligncenter">
			Admin Login
		</div>
		<div class="col-md-3"></div>
	</div>

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6 wrap-form aligncenter">
			<form method=post>
				<div class="row" style="padding:30px 0px 20px 0px">
					<div class="col-md-6 field-title">username</div>
					<div class="col-md-6"><input type=text name="username" required></div>
				</div>
				<div class="row" style="padding:30px 0px 20px 0px">
					<div class="col-md-6 field-title">password</div>
					<div class="col-md-6"><input type=password name="secret" required></div>
				</div>

				<div class="row" style="padding:30px 0px 30px 0px">
					<input type=submit name="login-submit" class="submit-button" value="Login">
				</div>
			</form>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>

<?php
	include 'footer.php';
?>