<?php

$linkCart = URL::createLink($this->arrParam['module'], 'user', 'cart', null, 'cart.html');

$menuProfile = '';

if($this->infoUserLogin['isLogin'])
{
    if($this->infoUserLogin['info']['group_acp'] == 1)
    {
        $menuProfile .= '
        <li><a style="color:red" href="'.$linkAcp.'">Control Panel</a></li>
        ';
    }
    $menuProfile .= '
        <li><a href="'.$linkProfile.'">My Profile</a></li>
        <li><a href="'.$linkLogout.'">Logout</a></li>
    ';
}
else
{
    $menuProfile .= '
    <li><a href="'.$linkLogin.'">Đăng nhập</a></li>
    <li><a href="'.$linkRegister.'">Đăng ký</a></li>
    ';
}

?>


<div class="top-header">
    <ul class="header-dropdown">
        <li class="onhover-dropdown mobile-account">
            <img src="<?php echo $this->_dirImg; ?>avatar.png" alt="avatar">
            <ul class="onhover-show-div">
                <?php echo $menuProfile; ?>
            </ul>
        </li>
    </ul>
</div>

<div>
    <div class="icon-nav">
        <ul>
            <li class="onhover-div mobile-search">
                <div>
                    <img src="<?php echo $this->_dirImg; ?>search.png" onclick="openSearch()" class="img-fluid blur-up lazyload" alt="">
                    <i class="ti-search" onclick="openSearch()"></i>
                </div>
                <div id="search-overlay" class="search-overlay">
                    <div>
                        <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                        <div class="overlay-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <form action="" method="GET">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="search" id="search-input" placeholder="Tìm kiếm sách...">
                                            </div>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="onhover-div mobile-cart">
                <div>
                    <a href="<?php echo $linkCart; ?>" id="cart" class="position-relative">
                        <img src="<?php echo $this->_dirImg; ?>cart.png" class="img-fluid blur-up lazyload" alt="cart">
                        <i class="ti-shopping-cart"></i>
                        <span class="badge badge-warning"><?php echo $this->totalCart; ?></span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>