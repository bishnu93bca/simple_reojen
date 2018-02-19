<?PHP 
if(isset($_SESSION['expire'])){
		 $now = time();
		if ($now > $_SESSION['expire']) {
            session_destroy();
           // echo "Your session has expired! <a href='http://localhost/somefolder/login.php'>Login here</a>";
        }
}

require_once 'amal-functions.php';
require_once 'functions.php';
$addr_data = getContactAddress();


?>
<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->

<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->

<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

    <head>

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php echo isset($addr_data['company_name'])? $addr_data['company_name']:"Reojen"; ?></title>

        <meta name="description" content="">

        <meta name="viewport" content="width=device-width">

		<link rel="icon" href=".img/favicon.ico" type="image/x-icon"/>
        
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>

        <link rel="stylesheet" href="css/bootstrap.min.css">

        <link rel="stylesheet" href="css/icomoon-social.css">
 		
 		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <!--link rel="stylesheet" href="css/font-awesome.css"-->

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800' rel='stylesheet' type='text/css'>



        <link rel="stylesheet" href="css/leaflet.css" />

		<!--[if lte IE 8]>

		    <link rel="stylesheet" href="css/leaflet.ie.css" />

		<![endif]-->

        <link rel="stylesheet" href="css/main.css">

        <!--<link href="css/flags.css" rel="stylesheet">-->



         <!--<script src="js/jquery.flagstrap.js"></script>-->

        <script src="js/jquery.min.js"></script>
 		<script src="js/custom_validation.js"></script>

	<script src="js/jquery.cookie.js"></script>

        <script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="assets/js/jquery.form-validator.min.js"></script>

    </head>