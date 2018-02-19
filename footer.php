<?php
require_once 'amal-functions.php';
require_once 'functions.php';
$addr_data = getContactAddress();
if (isset($addr_data) && count($addr_data) > 0) {
    $country_name = getCountryNameById($addr_data['country']);
}
?>
<a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-footer col-md-4 col-xs-6">
                <h3>Contacts</h3>
                <p class="contact-us-details">
                    <b>Address:</b> 
                    <?php if (isset($country_name) && count($country_name) > 0) { ?>
                        <br>			
                        <?php echo isset($addr_data['company_name']) ? html_entity_decode(stripcslashes($addr_data['company_name'])) : "" ?>,<br>
                        <?php echo isset($addr_data['address_line1']) ? html_entity_decode(stripcslashes($addr_data['address_line1'])) : "" ?>,<br>

                        <?php
                        if (isset($addr_data['address_line2']) && $addr_data['address_line2'] != '') {
                            ?>
                            <?php echo html_entity_decode(stripcslashes($addr_data['address_line2'])) . ',<br>'; ?>
                        <?php } ?>

                        <?php echo isset($addr_data['city']) ? html_entity_decode(stripcslashes($addr_data['city'])) : "" ?>,

                        <?php
                        if (isset($addr_data['state']) && $addr_data['state'] != '') {
                            ?>
                            <?php echo html_entity_decode(stripcslashes($addr_data['state'])) . ','; ?>
                        <?php } ?>

                        <?php echo isset($addr_data['post_code']) ? html_entity_decode(stripcslashes($addr_data['post_code'])) : "" ?>,<br>
                    <?php } ?>
                    <?php echo isset($country_name) ? $country_name : "" ?>

                    .
                    <br/>
                    Email: <a href="mailto:support@reojen.com">support@reojen.com</a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="footer-copyright">Copyright &copy; <?php echo date("Y") ?> Reojen Co. All rights reserved.</div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-1.9.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/leaflet.js"></script>
<script src="js/jquery.fitvids.js"></script>
<script src="js/jquery.sequence-min.js"></script>
<script src="js/jquery.bxslider.js"></script>
<script src="js/main-menu.js"></script>
<script src="js/template.js"></script>
</body>
</html>
