<?php
	ob_start();
	session_start();
	require("header.php");
	include("connect/db.php"); //Establishing connection with our database	 
	$error = ""; //Variable for storing our errors.
	$show_div=false;
	if(isset($_POST["btn-reset"]))
	{
		
		// Define $username and $password
		$mobile=$_POST['mobile'];
		// To protect from MySQL injection
		//$password = trim(mysqli_escape_string($connection,$_POST['password']));
	 	$password= $_POST['password'];
		$password = stripslashes($password);
		$c_password = mysqli_escape_string($connection,$_POST['c_password']);
		$password = mysqli_real_escape_string($connection,$password);
		$password = md5($password);
		$c_password = md5($c_password);
		$sql="UPDATE users SET password='".$password."', c_password='".$c_password."' where mobile_no='".$mobile."'";
		$result=mysqli_query($connection,$sql);
		if ($result) 
		{
			//If the Insert Query was successfull.
			$show_div=true;
			$_SESSION['password_change'] = "true";
			header("location: forgotpassword.php");
			//echo '<div class="alert alert-success">Updated Successfully </div>';
		}
	} 
?>   
    <body>
        <!-- Navigation & Logo-->
        <div class="mainmenu-wrapper">
	        <div class="container">	        	
		        <nav id="mainmenu" class="mainmenu">
					<ul>
						<li class="logo-wrapper">
							<a href="index.php">
								<img src="img/logo.png"/>
							</a>
						</li>
						<li>
							<a href="index.php">Home</a>
						</li>
						<li class="active">
							<a href="forgotpassword.php">Forgot password</a>
						</li>
						<li>
                            <a href="support.php">Support</a>
                        </li>					
					</ul>
				</nav>
			</div>
		</div>
        <!-- Page Title -->
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12 ">
						<h1>Forgot password</h1>
					</div>
				</div>
			</div>
		</div>        
        <div class="section">
	    	<div class="container">
				<div class="row">
					<div class="col-sm-5">
                    	<?php 
                    	if(!$show_div)
                    	{
                    	?>
							<div class="basic-login" id="forgotdiv" >
							 <?php
							 	if(isset($_SESSION['password_change']) && $_SESSION['password_change']=="true")
								{
									?>
									<div class="alert alert-success">
										You have changed your password successfully. You may 
										<a href="login.php">Log in</a> now.
									</div>
									<?php 
									$_SESSION['password_change']="false"; 
								} 
								?>
								<div class="form-group">
		        				 	<label for="register-mobile">
		        				 		<i class="icon-user"></i> 
		        				 		<b>Mobile number* </b>
		        				 	</label>
									<input name="register-mobile" class="form-control" id="register-mobile" type="text" value="" placeholder="in international format; e.g. +19174971072" onkeypress="javascript:return isNumberKey(event);">
                                    <span class="error"><p></p></span>
								</div>
								<div class="form-group">
									<div class="clearfix"></div>
									<button type="submit" class="btn pull-right" name="btn-forgot"  onClick="FetchDetails();">
										Continue
									</button>
								</div>							
							</div>
                        	<div class="basic-login" id="securityDiv" style="display:none;">
								<div class="form-group">
		        				 	<label for="login-username" id="qn1"></label>
									<input name="answer1" class="form-control" id="answer1" type="text" placeholder="Answer">
                                    <input name="hiddenanswer1" class="form-control" id="hiddenanswer1" type="hidden" >
								</div>
								<div class="form-group">
		        				 	<label for="login-username" id="qn2"></label>
									<input name="answer2" class="form-control" id="answer2" type="text" placeholder="Answer">
                                    <input name="hiddenanswer2" class="form-control" id="hiddenanswer2" type="hidden" >
                                    <input name="hiddenPassword" class="form-control" id="hiddenPassword" type="hidden" >
                                    <span class="error" id="worngData" name="worngData">
                                    	<p></p>
                                    </span>
								</div>
								<div class="form-group">
									<div class="clearfix"></div>
									<input type="button" class="btn pull-right" name="btn-pass" onClick="FetchPassword();" value="Next"/>
								</div>
							</div>
                        <?php } ?>
                        <form role="form" action="forgotpassword.php" onSubmit="return validate2();" method="post">
                        	<div class="basic-login" id="Password_Div" style="display:<?php echo ($show_div)?'block':'none'; ?>;">
                         		
								<div class="form-group">
		        				 	<label for="register-password">
		        				 		<i class="icon-lock"></i> 
		        				 		<b>Enter your new password*</b>
		        				 	</label>
                                    <div style="width:200px;padding-left: 50px;float: right;cursor: pointer;">
                                    	<a onClick="showpass1()">Show password</a></div>
										<input onKeyUp="hide_nxt(this);" onKeyDown="hide_nxt(this);" class="form-control" id="register-password" type="password" placeholder="" name="password" autocomplete="off" value="">  
                                    	<span class="error" ><p></p></span>
                                    	<input name="mobile" class="form-control" id="mobile" value="<?php if(isset($_REQUEST['mobile_no'])){echo $_REQUEST['mobile_no'];}?>" type="hidden" >
									</div>
									<div class="show_tooltip notification-password" style="display: none;">
										<img src="img/noti.png">
										Your password must contains a minimum of 8 characters and must contain at least two of the following-<br>
										* Upper case letter(s)<br>
										* Lower case letter(s)<br>
										* Number(s).
									</div>                               
								<div class="form-group">
		        				 	<label for="register-password2">
		        				 		<i class="icon-lock"></i> <b>Re-enter your new password*</b>
		        				 	</label>
                                    <div style="width:200px;padding-left: 50px;float: right;cursor: pointer;">
	                                    <a onClick="showpass2()">Show password</a></div>
	                                    <input onblur="check_pass(this);" class="form-control" 
	                                    autocomplete="off" id="register-password2" type="password" placeholder="" name="c_password" 
	                                    value="">
	                                    <span class="error" ><p></p></span>
									</div>
									<div class="form-group">
									<div class="clearfix"></div>
	                                <input type="submit" class="btn pull-right" name="btn-reset" value="Submit here"/>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<script type="text/javascript">
$(document).ready(function(){
		$('#register-password').blur(function() {
		    $(".show_tooltip").hide(); 
		});

		$('#register-password').focus(function() {
		  $(".show_tooltip").show();
		});   
	});
function validate()
{
	var ee=true;	
	if($("#register-mobile").val()=='')
	{		
		$("#register-mobile").next('.error').children("p").html('Enter your mobile number');
		$("#register-mobile").next('.error').show();
		ee=false;
	}
	else if(!validatePlus($("#register-mobile").val()))
	{
		$("#register-mobile").next('.error').children("p").html('Mobile number must start with a leading + sign.');
		$("#register-mobile").next('.error').show();
		ee=false;
	}
	else if($("#register-mobile").val().match(/\+/gi).length>1)
	{
		$("#register-mobile").next('.error').children("p").html('No more non-numeric character is allowed in "Mobile number" field apart from the leading + sign');
		$("#register-mobile").next('.error').show();
		ee=false;
	}
	else if(!isValidChar($("#register-mobile").val()))
	{
		$("#register-mobile").next('.error').children("p").html('Invalid mobile number. Spaces, dashes, hyphens,symbols (except the leading + sign) aren\'t allowed');
		$("#register-mobile").next('.error').show();
		ee=false;
	}
		if(ee==true)	
		return true;
		else
		return false;	
	}
function validatePlus(mbno) {
  var regExp = /^\+/;
  	if(regExp.test(mbno))
	{
  		return true;
	}
	return false;
}
function isValidChar(str){
	//var str = $('#Search').val();
	if(/^[a-zA-Z0-9- +]*$/.test(str) == false) 
	{
		return false;
	}
	return true;
}
function Validatephonenumber(inputtxt)  
    {  
 	var numbers = /^\+[1-9]{2}[0-9]{4,15}$/;
    //  var numbers = /^[-+]?[0-9]+$/; 
      if(inputtxt.match(numbers))  
      {
    // value is ok, use it
	return true;
	} else {
	   // alert("Invalid number; must be ten digits")
	   // number.focus()
		return false;
	}
    }  
	function validate2()
	{	
		var ee=true;
		if($("#register-password").val()=='')
		{	
			$("#register-password").next('.error').children("p").html('Enter your password');
			$("#register-password").next('.error').show();
			ee=false;
		}
		else 
		{
			if(!Validatepass($("#register-password").val()))
			{
				$("#register-password").next('.error').children("p").html('<small>Your password must contain minimum 8 characters and must contain at least two of the following: upper case letter(s), lower case letter(s), number(s)</small>');
				$("#register-password").next('.error').show();
				ee=false;
			}
		}
		if($("#register-password2").val()=='')
		{
			$("#register-password2").next('.error').children("p").html('Re-enter your password');
			$("#register-password2").next('.error').show();
			
			ee=false;
		}	
		if(ee==true)
		{
			if($("#register-password").val()!=$("#register-password2").val())
			{
				ee=false;				
				$("#register-password2").next('.error').children("p").html("Your passwords don't match");
				$("#register-password2").next('.error').show();
			}
			// else {
			// 	$("#register-password").val("");
			// 	$("#register-password2").val("");
			// }
			
		}
		return ee;
	}


	function Validatepass(pass) 
	{
		var passReg1 = /^(?=.*[A-Za-z])[A-Za-z]{8,}$/;
		var passReg2 = /^(?=.*[A-Z])(?=.*\d)[A-Z\d]{8,}$/;
		var passReg3 = /^(?=.*[a-z])(?=.*\d)[a-z\d]{8,}$/;
		var passReg4 = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
		 
		if(!(passReg1.test( pass )) && !(passReg2.test( pass )) && !(passReg3.test( pass )) && !(passReg4.test( pass )))	 	
	 	return false;
		else return true;
	}

	function check_pass(c)
	{
		$("#register-password2").next('.error').hide();
		if($("#register-password2").val()=='')
		{
			$("#register-password2").next('.error').children("p").html('Re-enter your password');
			$("#register-password2").next('.error').show();
			
			ee=false;
		}
		else if($("#register-password").val()!=$("#register-password2").val())
		{	
			ee=false;	
			//$("#register-password").val("");
			//$("#register-password2").val("");
			$("#register-password2").next('.error').children("p").html("Your passwords don't match");
			$("#register-password2").next('.error').show();
		}
	}
	function showpass1()
	{
		if($("#register-password").attr('type')=="text")
		{
			$("#register-password").attr('type', 'password');
			
		}
		else
		{
			$("#register-password").attr('type', 'text');
			
		}
	}

	function showpass2()
	{
		if($("#register-password2").attr('type')=="text")
		{
			$("#register-password2").attr('type', 'password');
		}
		else
		{
			$("#register-password2").attr('type', 'text');
		}
	}
	function hide_nxt(c)
	{
		$(c).next('.error').hide();
	}
	function FetchPassword() 
	{	
		var answer1 = document.getElementById("answer1");
		var hiddenanswer1 = document.getElementById("hiddenanswer1");
		var answer2 = document.getElementById("answer2");
		var hiddenanswer2 = document.getElementById("hiddenanswer2");	
		//var hiddenPassword = document.getElementById("hiddenPassword");
		if(answer1.value.toLowerCase() == hiddenanswer1.value.toLowerCase() && answer2.value.toLowerCase() == hiddenanswer2.value.toLowerCase())
		{
			var PasswordDiv = document.getElementById("Password_Div");
			PasswordDiv.style.display="block";
			var securityDiv = document.getElementById("securityDiv");
			securityDiv.style.display="none";
			var forgotdiv = document.getElementById("forgotdiv");
			forgotdiv.style.display="none";
		}
		else
		{
			var worngData = document.getElementById("worngData");
			var securityDiv = document.getElementById("securityDiv");
			securityDiv.style.display="block";
			worngData.style.display="block";
			worngData.innerHTML="<p>Incorrect answer</p>";
		}
	}

	$(document).on('change','.country_code',function(){
	   $(this).parent().find('.code').html('+'+$(this).val());
	   //$('.code').html('+'+$(this).val());
	  });
	function FetchDetails() 
	{
		if(!validate())
		return false;
		var mobileNum=	$("#register-mobile").val();
		$.ajax({
	        type: "POST",
	        url: "FetchDetail.php",
	        data: {mobile_no:mobileNum},
	        success: function(result) {			
				if(result.trim()!=="Invalid")
				{
					$("#securityDiv").css('display','block');
					$("#forgotdiv").css('display','none');
					var values=result.split(',');				
					$("#qn1").html( '1)'+values[0] );
					$("#qn2").html('2)'+values[2]);
					$("#hiddenanswer1").val(values[1]);
					$("#hiddenanswer2").val(values[3]);
					//$("#hiddenPassword").val(values[3]);
					$("#mobile").val($("#register-mobile").val());				
				}
				else
				{
	            	$("#securityDiv").css('display','none');
					$("#forgotdiv").css('display','block');
					$("#forgotdiv .error").show();
					$("#forgotdiv .error p").html('Mobile number does not exits');
				}
	        }
	    }); 
	}
</script>

<!-- Footer -->
<?php require("footer.php");
ob_end_flush();

 ?>