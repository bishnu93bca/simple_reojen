<?php  
error_reporting(E_ALL);

session_start();

if(isset($_POST["addMoney"]))
{
	//load paypal library classes
	require __DIR__  . '/libraries/paypal/vendor/autoload.php';
	
	//load database files
	require_once('connect/db.php');
	require_once('query.php');
	require_once('libraries/helper.php');
	
	//use PayPal\Api\Details;
	$amountToPay		=	trim($_POST["amount"]);

	$apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(config("paypal_client_id"),config("paypal_secret_key"))
	);
	$apiContext->setConfig(
		  array(
			'mode'		=>	'sandbox',
			'log.LogEnabled' => true,
			'log.FileName' => 'PayPal.log',
			'log.LogLevel' => 'DEBUG'
		  )
	);
	
	$payer = new \PayPal\Api\Payer();
	$payer->setPaymentMethod('paypal');
	
	$amount = new \PayPal\Api\Amount();
	$amount->setTotal($amountToPay);
	$amount->setCurrency('GBP');

	$item = new \PayPal\Api\Item();                            
	$item->setQuantity(1);                         
	$item->setName("Adding amount to wallet");           
	$item->setPrice($amountToPay);               
	$item->setCurrency("GBP"); 
	
	$itemList = new \PayPal\Api\ItemList();                    
	$itemList->setItems(array($item));

	$transaction = new \PayPal\Api\Transaction();
	$transaction->setAmount($amount)->setDescription("Adding amount to wallet");
	$transaction->setItemList($itemList); 
	
	$redirectUrls = new \PayPal\Api\RedirectUrls();
	
	$return_url		=	$_SERVER["REQUEST_SCHEME"]."://www.".$_SERVER["HTTP_HOST"]."/paypal.php";
	$cancel_url		=	$_SERVER["REQUEST_SCHEME"]."://www.".$_SERVER["HTTP_HOST"]."/paypalcancel.php";
	$redirectUrls->setReturnUrl($return_url)->setCancelUrl($cancel_url);

	
	// Create the WebProfile
    $presentation = new \PayPal\Api\Presentation();
    $presentation->setLogoImage($_SERVER["REQUEST_SCHEME"]."://www.".$_SERVER["HTTP_HOST"]."/img/logo.png")
        ->setBrandName("Reojen Co.")
        ->setLocaleCode("en_US");
    $inputFields = new \PayPal\Api\InputFields();
    $inputFields->setAllowNote(true)
        ->setNoShipping(1)
        ->setAddressOverride(0);
    
	$webProfile = new \PayPal\Api\WebProfile();
    $webProfile->setName("Reojen Co." . uniqid())
        ->setPresentation($presentation)
        ->setInputFields($inputFields);
    try {
        $createdProfile = $webProfile->create($apiContext);
        $createdProfileID = json_decode($createdProfile);
        $profileid = $createdProfileID->id;
    } catch(PayPal\Exception\PayPalConnectionException $pce) {
        //echo '<pre>',print_r(json_decode($pce->getData())),"</pre>";
        exit;
    }
	
	
	$payment = new \PayPal\Api\Payment();
	$payment->setExperienceProfileId($profileid)->setIntent('sale')->setPayer($payer)->setTransactions(array($transaction))->setRedirectUrls($redirectUrls);
	
	
	
	try {
		$payment->create($apiContext);
		//echo "<pre>";print_r($payment);die;
		$data	=	[
			"user_id"		=>	$_SESSION["user_id"],
			"payment_id"	=>	$payment->id,
			"status"		=>	"created",
			"amount"		=>	$amountToPay,
			"payment_method"=>	"paypal",
			"currency"		=>	"USD"
		];
		
		$query 	= 	new QueryFire();
		
		$query->insertData("app_payment_transactions", $data, implode(",",array_keys($data)));
		
		header("Location:".$payment->getApprovalLink());exit(0);
		//echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
	}catch (\PayPal\Exception\PayPalConnectionException $ex) {
		// This will print the detailed information on the exception.
		//REALLY HELPFUL FOR DEBUGGING
		$data = $ex->getData();
		$data	=	json_decode($data);
		$_SESSION["notification.add_money"]	=	$data->details[0]->issue;
		header("Location:add-money.php");exit(0);
	}
}else{
	header("Location:index.php");
}
?>