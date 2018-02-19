<?php
require("connect/db.php");
require_once("libraries/helper.php");
ob_start();
@session_start();
global $connection;
$_SESSION["show_notification"] = 1;
if (isset($_COOKIE['slrememberme']) && $_COOKIE['slrememberme'] != null) {
    $mobid = $_COOKIE['slrememberme'];

    $sql = $connection->query("select * from users where mobile_no='" . $mobid . "'");

    while ($row = $sql->fetch_assoc()) {
        $_SESSION['mob_id'] = $row['mobile_no'];
        $_SESSION['user_name'] = $row['fname'] . ' ' . $row['mname'] . " " . $row['lname'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email'] = $row['Email'];
        $_SESSION['CompanyName'] = $row['CompanyName'];
    }
}
if (!isset($_SESSION['mob_id']) || !isset($_SESSION['user_name'])) {

    header("location: http://" . $_SERVER['HTTP_HOST'] . "/reojen/");
}

$nowType = $connection->query('SELECT * FROM settings WHERE name="payment_type" LIMIT 1')->fetch_assoc();

if ($nowType['value'] == 'BACS') {
    $currency_symbol = '&#163;';
} elseif($nowType['value'] == 'PAYPAL') {
	$currency_symbol = '<i class="fa fa-eur"></i>';
} else {
    $currency_symbol = '&#x24;';
}

//change the below code please change the passwd in query .php to 	
require('query.php');
$QueryFire = new QueryFire();
$products = $QueryFire->getAllData('products', $where = 1);
require("header.php");
if (isset($_SESSION['user_name'])) {
    $gateway = $connection->query('SELECT * FROM settings WHERE name="payment_type" LIMIT 1')->fetch_assoc();
//    $gateway = $connection->query('SELECT * FROM payment_gateway WHERE status="1" LIMIT 1')->fetch_assoc();
    $page = "";
    if ($gateway['value'] == "BACS") {
        $page = "add-money.php";
    } else if ($gateway['value'] == "WU") {
        $page = "addmoney.php";
    } else if ($gateway['value'] == "WT") {
        $page = "add-money-via-wire-transfer.php";
    } else if ($gateway['value'] == "OP") {
        $page = "okpay_money.php";
    } else if ($gateway['value'] == "SEPA") {
        $page = "sepa-country.php";
    }
    ?>	
    <body>		
        <div class="mainmenu-wrapper">			
            <div class="container">				
                <div class="menuextras">					
                    <div class="extras">						
                        <ul>							
                            <li class="shopping-cart-items">								
                                <i class="glyphicon glyphicon-shopping-cart icon-white"></i> <a href="#"><b>Balance: <?php echo $currency_symbol; ?> <?php echo wallet();?></b></a>								
                            </li>														
                            <li>								
                                <div class="btn-group pull-right">									
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">										
                                        <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> <?php echo (isset($_SESSION['CompanyName']) && !empty($_SESSION['CompanyName'])) ? $_SESSION['CompanyName'] : $_SESSION['user_name'] ?></span>										
                                        <span class="caret"></span>										
                                    </button>									
                                    <ul class="dropdown-menu">										
                                        <li><a href="myaccount.php">My account</a></li>										
                                        <li class="divider"></li>										
                                        <li><a href="logout.php">Log out</a></li>										
                                    </ul>									
                                </div>								
                            </li>							
                        </ul>						
                    </div>					
                </div>				
                <?php require_once 'nav.php'; ?>				
            </div>			
        </div>		
        <?php
        if (isset($_SESSION['firstlogin']) && $_SESSION['firstlogin'] == "true") {
            ?>			
            <div class="alert alert-success">				
                Thank you <?php echo $_SESSION['user_name'] ?>, your Reojen account has been successfully created.				
            </div>			
            <?php
            $_SESSION['firstlogin'] = "false";
        }
        ?>			
        <div class="eshop-section section">							
            <div class="container">									
			<?php if(isset($_SESSION["notification.payment"]) && !empty($_SESSION["notification.payment"])):?>				
			<div class="alert alert-success alert-dismissable">				
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>					
				<?php echo $_SESSION["notification.payment"];$_SESSION["notification.payment"]=""?>				
			</div>				
			<?php endif;?>
                <h2>My products</h2>					
                <br>					
                <p>You haven't purchased any product yet.</p>					
                <br><br>					
                <div class="acuntbaner">						
                    <img class="img-responsive" src="img/myaccountbanner.jpg">						
                </div>					
                <br><br><br/>					
                <h2 class="prchs">Purchase a product</h2>					
                <div class="row">						
                    <div class="col-md-4 col-sm-6">							
                        <div class="shop-item">															
                            <div class="title">									
                                <h3>Reojen Newsletter Sending And Email Marketing Software</h3>									
                            </div>								
                            <div class="description">																	
                                <h5 align="center">About the plan</h5>									
                                <p>You can purchase the license for 3 months to 5 years. You can renew the license anytime after it expires										
                                    Comes packaged with Reojen Email Marketing and Newsletter Software.										
                                    Supports up to 1000000 subscribers of your newsletters.										
                                    Log in to your Reojen Email Marketing and Newsletter Software										
                                    with your Reojen login credential and start using this service.										
                                </p>																		
                                <h4 align="center">Features</h4>									
                                <ol>1. Intuitive template editor</ol>										
                                <ol>2. Stunning and effective email templates</ol>									
                                <ol>3. Clever autoresponders</ol>									
                                <ol>4. Real-time email tracking</ol>									
                                <ol>5. Achieve more from your email marketing</ol>									
                                <ol>6. Free Inbox Inspector</ol>									
                                <ol>7. Free Spam Test</ol>									
                                <ol>8. Send Time optimization</ol>									
                                <ol>9. Automatic A/B testing</ol>									
                                <ol>10. Targeting</ol>									
                                <ol>11. Personalisation and dynamic content</ol>									
                                <ol>12. Multiple awards</ol>									
                                <ol>13. Hundreds of happy clients</ol>									
                            </div>								
                            <div class="price">									
                                Price: <?php echo $currency_symbol; ?><?= $products[0]['price'] ?>/<?= $products[0]['text'] ?>									
                            </div>															
                            <div class="actions myacnt">									
                                <a href="<?= $page ?>" onClick="set_onCk();" class="btn btn-small"><i class="icon-shopping-cart icon-white"></i> Purchase</a> 									
                            </div>								
                        </div>							
                    </div>						
                    <div class="col-md-4 col-sm-6">							
                        <div class="shop-item">															
                            <div class="title">									
                                <h3>Reojen Geographic Location Based Targeted Email Lists</h3>									
                            </div>								
                            <div class="description">																	
                                <h5 align="center">										
                                    About Reojen Geographic Location Based Targeted Email Lists</h5>									
                                <p>Get a list of 1000000 targeted email addresses for only <?= $currency_symbol ?><?= $products[1]['price'] ?>. We have many different geographic location based targeted email lists. You can choose and purchase the email list of the geographic location you like. We use hundreds of different sources to aggregate our consumer email database. We gather raw data										
                                    from our own marketing and publication offers, third party offers,										
                                    online surveys, data acquisition, behavioral data and other accurate										
                                    sources before we integrate proprietary enrichment sources.										
                                    All email leads are 100% permission based, Can Spam compliant and										
                                    updated weekly. We provide online marketers the ability to reach US										
                                    local targeted audiences using quality direct email and postal										
                                    marketing data.<br><br>										
                                    Every data order passes through our email hygiene process to ensure										
                                    that emails have a 95%+ delivery rate.<br><br>										
                                    DON'T GET BLOCKED!<br>										
                                    GET SUPERIOR EMAIL DELIVERY and have successful email campaigns.										
                                </p>																
                            </div>								
                            <div class="price">									
                                Price: <?php echo $currency_symbol; ?><?= $products[1]['price'] ?>/<?= $products[1]['text'] ?>									
                            </div>								
                            <div class="actions myacnt">									
                                <a href="<?= $page ?>" onClick="set_onCk();" class="btn btn-small"><i class="icon-shopping-cart icon-white"></i> Purchase</a> 									
                            </div>								
                        </div>							
                    </div>						
                    <div class="col-md-4 col-sm-6">							
                        <div class="shop-item">															
                            <div class="title">									
                                <h3>Reojen Marketing Automation Software</h3>									
                            </div>								
                            <div class="description">																	
                                <h5 align="center">About the software</h5>									
                                <p> Reojen Marketing Automation Software enables										
                                    businesses to create a sales and marketing strategy and map out each										
                                    step; centralize customer interactions and daily activities; capture										
                                    new leads and automate follow-up based on preferences and needs;										
                                    follow-up, contact management all from one place.You can purchase the license for 3 months to 5 years. You can renew license anytime after it expires. Log in to your Reojen Marketing Automation Software with your Reojen login										
                                    credentials and start using this service.										
                                </p>									
                                <h4 align="center">Features</h4>									
                                <ol>1. Analytics / ROI Tracking</ol>									
                                <ol>2. Campaign Segmentation</ol>									
                                <ol>3. Contact Management</ol>									
                                <ol>4. Content / Blogging Platform</ol>									
                                <ol>5. Direct Mail Management</ol>									
                                <ol>6. Email Drip Campaigns</ol>									
                                <ol>7. Landing Pages / Web Forms</ol>									
                                <ol>8. Lead Management</ol>									
                                <ol>9. Lead Nurturing</ol>									
                                <ol>10. Lead Scoring</ol>									
                                <ol>11. Multi Channel Management</ol>									
                                <ol>12. Multivariate Testing</ol>									
                                <ol>13. Referrals / Affiliates</ol>									
                                <ol>14. Search Marketing</ol>									
                                <ol>15. Social Marketing</ol>									
                                <ol>16. Web Visitor Tracking</ol>									
                            </div>								
                            <div class="price">									
                                Price: <?php echo $currency_symbol; ?><?= $products[2]['price'] ?>/<?= $products[2]['text'] ?>									
                            </div>								
                            <div class="actions myacnt">									
                                <a href="<?= $page ?>" onClick="set_onCk();" class="btn btn-small" ><i class="icon-shopping-cart icon-white"></i>Purchase</a> 									
                            </div>								
                        </div>							
                    </div>						
                </div>					
            </div>				
        </div>			
        <?php
    } else {
        
    }
    require("footer.php");
    ob_end_flush();
    ?>	
    <script src="js/jquery.min.js"></script>	
    <script src="js/jquery.cookie.js"></script>	
    <script>
                                function set_onCk()
                                {
                                    $.cookie('money', 'Y');
                                }
    </script>	