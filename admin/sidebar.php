<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="home.php" class="logo">
            <img src="img/logo-admin-small.png" class="logo-mini"/>
            <img src="img/logo-admin.png" class="logo-lg"/>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="admin_logout.php" id="logout" style="float:right;color:#FFF;padding:5px"><h4>Logout</h4></a>
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>
    <aside class="main-sidebar">
        <!-- sidebar -->
        <section class="sidebar">
            <ul class="sidebar-menu">
                <!-- <li class="<?php echo (isset($active_tab) && trim($active_tab) == 'sendMessage') ? 'active open' : ''; ?>">
          <a href="">
            <i class="fa fa-send"></i>
            <span>Send Message</span>
          </a>
        </li>  -->
                <li class="treeview <?php echo (isset($active_tab) && trim($active_tab) == 'products') ? 'active open' : ''; ?>">
                    <a href="products.php">
                        <i class="fa fa-product-hunt"></i><span>Products</span>
                    </a>
                </li>

                <li class="<?php echo (isset($active_tab) && trim($active_tab) == 'Western union details') ? 'active open' : ''; ?>">
                    <a href="home.php">
                        <i class="fa fa-group"></i>
                        <span>Western union details</span>
                    </a>
                </li>
                <li class="<?php echo (isset($active_tab) && trim($active_tab) == 'Western union status') ? 'active open' : ''; ?>">
                    <a href="western_union_status.php">
                        <i class="fa fa-group"></i>
                        <span>Western union status</span>
                    </a>
                </li>
                <li class="<?php echo (isset($active_tab) && trim($active_tab) == 'Change address') ? 'active open' : ''; ?>">
                    <a href="change_address.php">
                        <i class="fa fa-map-marker"></i>
                        <span>Change address</span>
                    </a>
                </li>
                
        </section>
        <!-- /.sidebar -->
    </aside>




