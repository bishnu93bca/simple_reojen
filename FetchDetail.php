<?php
	if(isset($_POST['mobile_no']))
	{
		$mbno=$_POST['mobile_no'];
		include("connect/db.php"); //Establishing connection with our database
		$query_verify_email = "SELECT * FROM users WHERE mobile_no ='$mbno'";
		$verified_email = mysqli_query($connection,$query_verify_email) or die("Error: ".mysqli_error($connection));
		if(mysqli_num_rows($verified_email) >0) 
		{
			$row=mysqli_fetch_array($verified_email,MYSQLI_ASSOC);
			echo $row['SecurituyQuestion1'].','. $row['Answer1'] .','. $row['SecurityQuestion2'] .','. $row['Answer2'];
		}
		else
		{
			echo 'Invalid';
		}
	}
	else
	{
		echo 'Invalid mobile number';
	}
?>