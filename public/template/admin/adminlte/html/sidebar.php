<?php

$controller     = $this->arrParam['controller'];
$action         = $this->arrParam['action'];

$linkDashboard      = URL::createLink('backend', 'dashboard', 'index');
$linkGroupList      = URL::createLink('backend', 'group', 'index');
$linkGroupForm      = URL::createLink('backend', 'group', 'form');
$linkUserList       = URL::createLink('backend', 'user', 'index');
$linkUserForm       = URL::createLink('backend', 'user', 'form');
$linkCategoryList   = URL::createLink('backend', 'category', 'index');
$linkCategoryForm   = URL::createLink('backend', 'category', 'form');
$linkBookList       = URL::createLink('backend', 'book', 'index');
$linkBookForm       = URL::createLink('backend', 'book', 'form');
$linkSliderList     = URL::createLink('backend', 'slider', 'index');
$linkSliderForm     = URL::createLink('backend', 'slider', 'form');
$linkCartList       = URL::createLink('backend', 'cart', 'index');
$linkCartView       = URL::createLink('backend', 'cart', 'view');
$linkChangePassword = URL::createLink('backend', 'index', 'changePassword');

//dashboard
$arrDashboard       = [ 'parent' => [ 'name' => 'Dashboard', 'icon'   => 'tachometer-alt','link' => $linkDashboard]];
$dashboard          = Html::createSidebar($controller,$action,$arrDashboard);

//Group
$arrGroup           = ['parent' => ['name' => 'Group', 'icon' => 'users','link' => '#'],'child' =>[['name' =>'List','icon' => 'list-ul','link' => $linkGroupList ],['name' => 'Form','icon' => 'edit','link' => $linkGroupForm]]];
$group              = Html::createSidebar($controller,$action,$arrGroup);

//user
$arrUser            = ['parent' => ['name' => 'User', 'icon' => 'user','link' => '#'],'child' =>[['name' =>'List','icon' => 'list-ul','link' => $linkUserList ],['name' => 'Form','icon' => 'edit','link' => $linkUserForm]]];
$user               = Html::createSidebar($controller,$action,$arrUser);

//Category
$arrCategory        = ['parent' => ['name' => 'Category', 'icon' => 'thumbtack','link' => '#'],'child' =>[['name' =>'List','icon' => 'list-ul','link' => $linkCategoryList ],['name' => 'Form','icon' => 'edit','link' => $linkCategoryForm]]];
$category           = Html::createSidebar($controller,$action,$arrCategory);

//Book
$arrBook            = ['parent' => ['name' => 'Book', 'icon' => 'book-open','link' => '#'],'child' =>[['name' =>'List','icon' => 'list-ul','link' => $linkBookList ],['name' => 'Form','icon' => 'edit','link' => $linkBookForm]]];
$book               = Html::createSidebar($controller,$action,$arrBook);

//Slider
$arrSlider          = ['parent' => ['name' => 'Slider', 'icon' => 'book-open','link' => '#'],'child' =>[['name' =>'List','icon' => 'list-ul','link' => $linkSliderList ],['name' => 'Form','icon' => 'edit','link' => $linkSliderForm]]];
$slider             = Html::createSidebar($controller,$action,$arrSlider);

//Cart
$arrCart            = ['parent' => ['name' => 'Cart', 'icon' => 'book-open','link' => '#'],'child' =>[['name' =>'List','icon' => 'list-ul','link' => $linkCartList ],['name' => 'View','icon' => 'edit','link' => $linkCartView]]];
$cart               = Html::createSidebar($controller,$action,$arrCart);


// CHANGE PASSWORD
$arrChangePass      = [ 'parent' => [ 'name' => 'Change Password', 'icon'   => 'tachometer-alt','link' => $linkChangePassword]];
$changepass          = Html::createSidebar($controller,$action,$arrChangePass);

?>

<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?php echo $this->_dirImg ?>/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Control Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo $this->_dirImg ?>/default-user.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?php echo $linkProfile; ?>" class="d-block"><?php echo $infoUserLogin['info']['fullname']; ?></a>
            </div>  
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php echo $dashboard ; ?>
                <?php echo $group . $user . $category . $book . $slider . $cart . $changepass; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>