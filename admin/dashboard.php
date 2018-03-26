<?php
	$title = "Admin Dashboard";
	include '../header.php';

	$xlmsg = "";
	$pwdmsg = "";
	$emailmsg = "";

	$adm = new admin();
	$clr = "#ffaaaa";

	if($_POST){		
		if($_POST['formtype']=="emailupd"){
			if(!$adm->updateEmail($_POST['useremail'])){
				$emailmsg = "Something went wrong. Please try again!";
				$clr = "#ffaaaa";
			}else{
				$emailmsg = "Email updated successfully.";
				$clr = "#aaffaa";
			}
		}

		if($_POST['formtype']=="chgpwd"){
			if($_POST['userpass'] != $_POST['usercpass']){
				$pwdmsg = "Passwords don't match. Please try again!";
				$clr = "#ffaaaa";
			}else{
				if($adm->updatePassword($_POST['userpass'])){
					$pwdmsg = "Password updated successfully.";
					$clr = "#aaffaa";
				}else{
					$pwdmsg = "Something went wrong. Please try again!";
					$clr = "#ffaaaa";	
				}
			}
		}
		
		if($_POST['formtype']=="chgpwd"){
			if($_POST['userpass'] != $_POST['usercpass']){
				$pwdmsg = "Passwords don't match. Please try again!";
				$clr = "#ffaaaa";
			}else{
				if($adm->updatePassword($_POST['userpass'])){
					$pwdmsg = "Password updated successfully.";
					$clr = "#aaffaa";
				}else{
					$pwdmsg = "Something went wrong. Please try again!";
					$clr = "#ffaaaa";	
				}
			}
		}

		if($_POST['formtype']=="xlupld"){
			if($adm->handleExcel($_POST, $_FILES)){
				$xlmsg = "Data uploaded successfully.";
				$clr = "#aaffaa";
			}else{
				$xlmsg = "Something went wrong. Please try again!";
				$clr = "#ffaaaa";
			}
		}
		//print_r($_POST);
		//echo "<br>";
		//print_r($_FILES);
	}
	$username = "sagrasa";
	$adminData = $adm->getDashboardData($username);
?>
<body>

<div class="container" style="padding-top:20px;">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6 page-title aligncenter" style="background-color:#fff;border-bottom:1px solid #ddd">
			Dashboard
		</div>
		<div class="col-md-3"></div>
	</div>
</div>
<br><br><br><br>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
			<div class="page-title2 white aligncenter">Upload Data</div>
			<div class="wrap-form aligncenter" style="height:350px;min-height:350px;">
				<form method=post enctype="multipart/form-data" class="adminform">
					<div class="row" style="padding:30px 0px 20px 0px">
						<div class="col-md-12 field-title">Select file to Upload</div>
					</div>
					<div class="row" style="padding:30px 0px 20px 0px">	
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<input type=file name="excelfile" style="padding:10px 10px 10px 10px;font-size:24px;width:100%;background-color:#eee" required accept=".xls, .xlsx, .csv" required>
							<input type="hidden" name="formtype" value="xlupld">
						</div>
						<div class="col-md-1"></div>
					</div>
					<?php
						if($xlmsg != ""){
					?>
					<div class="row errmsg" style="background-color: <?php echo $clr;?>;width:auto;margin:0 20px 0 20px;text-align:center;border-radius: 5px">
						<?php echo $xlmsg;?>
					</div>
					<?php
						}
					?>
					<div class="row" style="padding:30px 0px 30px 0px">
						<input type=submit name="excel-submit" class="submit-button" value="Upload">
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-4">
			<div class="page-title2 white aligncenter">Change Password</div>
			<div class="wrap-form aligncenter" style="height:350px;min-height:350px;">
				<form method=post class="adminform">
					<div class="row" style="padding:50px 0px 20px 0px">	
						<div class="col-md-12">
							<input type=password name="userpass" placeholder="Enter New Password" required>
						</div>
					</div>
					<div class="row" style="padding:10px 0px 20px 0px">	
					<div class="col-md-12">
						<input type=password name="usercpass" placeholder="Enter Password again" required>
						<input type="hidden" name="formtype" value="chgpwd">
					</div>
					</div>
					<?php
						if($pwdmsg != ""){
					?>
					<div class="row errmsg" style="background-color: <?php echo $clr;?>;width:auto;margin:0 20px 0 20px;text-align:center;border-radius: 5px">
						<?php echo $pwdmsg;?>
					</div>
					<?php
						}
					?>
					<div class="row" style="padding:30px 0px 30px 0px">
						<input type=submit name="pwd-submit" class="submit-button" value="Change Password">
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-4">
			<div class="page-title2 white aligncenter">Change E-mail Address</div>
			<div class="wrap-form aligncenter" style="height:350px;min-height:350px;">
				<form method=post class="adminform">
					<div class="row" style="padding:30px 0px 20px 0px">
						<div class="col-md-12 field-title">Enter Your New E-mail</div>
					</div>
					<div class="row" style="padding:30px 0px 20px 0px">	
						<div class="col-md-12">
							<div class="field-data">
								<input type=email name="useremail" placeholder="<?php echo $adminData['email'];?>" required>
								<div class="alertfocus"></div>
							</div>
							<input type="hidden" name="formtype" value="emailupd">
						</div>
					</div>
					<?php
						if($emailmsg != ""){
					?>
					<div class="row errmsg" style="background-color: <?php echo $clr;?>;width:auto;margin:0 20px 0 20px;text-align:center;border-radius: 5px">
						<?php echo $emailmsg;?>
					</div>
					<?php
						}
					?>
					<div class="row" style="padding:30px 0px 30px 0px">
						<input type=submit name="email-submit" class="submit-button" value="Update">
					</div>
				</form>
			</div>
		</div>
	</div>


</div>


<?php
	include '../footer.php';
?>