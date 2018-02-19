<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="javascript:void(0)" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="../img/logo.png" style="width: 100px;height: 30px;"/></span>
            <!-- logo for regular state and mobile devices -->
           <span class="logo-lg"><img src="../img/logo.png" style="width: 250px;height: 30px;"/></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="admin_logout.php" id="logout" style="float:right;color:#FFF;padding:5px"><h4>Logout</h4></a>
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <!-- <li class="<?php echo (isset($active_tab) && trim($active_tab) == 'sendMessage') ? 'active open' : ''; ?>">
          <a href="">
            <i class="fa fa-send"></i>
            <span>Send Message</span>            
          </a>          
        </li>  -->				<li class="<?php echo (isset($active_tab) && trim($active_tab) == 'settings') ? 'active open' : ''; ?>">                    <a href="settings.php">                        <i class="fa fa-cog"></i>                        <span>Settings</span>                    </a>                </li>
                <li class="<?php echo (isset($active_tab) && trim($active_tab) == 'students') ? 'active open' : ''; ?>">
                    <a href="home.php">
                        <i class="fa fa-group"></i>
                        <span>Deposits</span>
                    </a>
                </li>
                <li class="treeview <?php echo (isset($active_tab) && trim($active_tab) == 'products') ? 'active open' : ''; ?>">
                    <a href="products.php">
                        <i class="fa fa-product-hunt"></i><span>Change price</span>
                    </a>
                </li>

                <li class="treeview <?php echo (isset($active_tab) && trim($active_tab) == 'user') ? 'active open' : ''; ?>">
                    <a href="user.php">
                        <i class="fa fa-user"></i><span>Users</span>
                    </a>
                </li>

                <li class="treeview <?php echo (isset($active_tab) && trim($active_tab) == 'change_pwd') ? 'active open' : ''; ?>">
                    <a href="change_pwd.php">
                        <i class="fa fa-key"></i><span>Change Password</span>
                    </a>
                </li>

                <li class="treeview <?php echo (isset($active_tab) && trim($active_tab) == 'change_payment') ? 'active open' : ''; ?>">
                    <a href="change_payment_type.php">
                        <i class="fa fa-paypal"></i><span>Change Payment Method</span>
                    </a>
                </li>
                <li class="<?php echo (isset($active_tab) && trim($active_tab) == 'pass_auth') ? 'active open' : ''; ?>">
                    <a href="pass_auth.php">
                        <i class="fa fa-lock"></i>
                        <span>Password Authentication</span>
                    </a>
                </li>
        </section>
        <!-- /.sidebar -->
    </aside>

  


