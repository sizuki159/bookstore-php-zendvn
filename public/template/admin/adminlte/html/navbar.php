<?php
$infoUserLogin  = Session::get('user');

$linkLogout     = URL::createLink('backend', 'index', 'logout');
$linkProfile    = URL::createLink('backend', 'index', 'profile');



?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?= $this->_dirImg ?>default-user.jpg" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">My Profile</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-info">
                    <img src="<?= $this->_dirImg ?>default-user.jpg" class="img-circle elevation-2" alt="User Image">

                    <p><?php echo $infoUserLogin['info']['fullname']; ?> <small><?php echo $infoUserLogin['info']['username']; ?></small></p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="<?php echo $linkProfile ?>" class="btn btn-default btn-flat">Profile</a>
                    <a href="<?php echo $linkLogout ?>" class="btn btn-default btn-flat float-right">Sign out</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>