<?php  
session_start();
if(isset($_REQUEST["paymentId"]))
{
	if(isset($_SESSION["user_id"]))	
	{		
		//load paypal library classes		
		require __DIR__  . '/libraries/paypal/vendor/autoload.php';				
		
		//load database files		
		//require_once('connect/db.php');		
		require_once('query.php');
		
		$client_id		=	config("paypal_client_id");
		$secrete_key	=	config("paypal_secret_key");
		$apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($client_id,$secrete_key));		
		$apiContext->setConfig(	
			array(
				'mode'=>	'sandbox',
				'log.LogEnabled' => true,
				'log.FileName' => 'PayPal.log',
				'log.LogLevel' => 'DEBUG'			  
			)		
		);				
		//Get the payment details		
		$query 		= 	new QueryFire();		
		$payments 	=	$query->getAllData("app_payment_transactions", "payment_id='".$_REQUEST["paymentId"]."'");
		$payments	=	$payments[0];
		//echo "<pre>";print_r($_REQUEST["PayerID"]);
	
		$payment = new \PayPal\Api\Payment();
		$payment = $payment::get($_REQUEST["paymentId"],$apiContext);
		$execution	=	new \PayPal\Api\PaymentExecution();
		$execution->setPayerId($_REQUEST["PayerID"]);
		$payment->execute($execution,$apiContext);
		
		if($payment->state == "approved")
		{
			$payments["completed_on"]	=	date("Y-m-d H:i:s");
			$payments["status"]			=	"approved";
		}else{
			$payments["completed_on"]	=	date("Y-m-d H:i:s");
			$payments["status"]			=	"canceled";
		}	
		$query->upDateTable("app_payment_transactions", "payment_id='".$_REQUEST["paymentId"]."'", $payments);
		$_SESSION["notification.payment"]	=	"You have successfully added $".$payments["amount"]." to your wallet";
		header("Location:home.php");exit(0);
	}
}
header("Location:index.php");
