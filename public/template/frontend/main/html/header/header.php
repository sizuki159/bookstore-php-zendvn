<?php

$linkHome       = URL::createLink($this->arrParam['module'], 'index', 'home', null, 'home.html');
$linkLogin      = URL::createLink($this->arrParam['module'], 'index', 'login', null, 'login.html');
$linkLogout     = URL::createLink($this->arrParam['module'], 'index', 'logout', null, 'logout.html');
$linkRegister   = URL::createLink($this->arrParam['module'], 'index', 'register', null, 'register.html');
$linkCategory   = URL::createLink($this->arrParam['module'], 'category', 'index', null, 'categorys.html');
$linkBook       = URL::createLink($this->arrParam['module'], 'book', 'index', null, 'books.html');
$linkProfile    = URL::createLink($this->arrParam['module'], 'user', 'profile', null, 'my-account.html');
$linkAcp        = URL::createLink('backend', 'dashboard', 'index');

$childCategory = [];

if(!empty($this->listItemCategory))
{
    foreach($this->listItemCategory as $item)
    {
        $linkItemCategory   = URL::createLink($this->arrParam['module'], 'book', 'index', ['category_id' => $item['id']]);
        $childCategory[]    = ['id' => $item['id'], 'name' => $item['name'], 'link' => $linkItemCategory];
        unset($linkItemCategory);
    }
}

$arrHome        = [
                    'parent' => [
                            'name'          => 'Trang chủ',
                            'controller'    => 'index',
                            'link'          => $linkHome
                    ]
];

$arrBook        = [
                    'parent' => [
                            'name'          => 'Sách',
                            'controller'    => 'book',
                            'link'          => $linkBook
                    ]
];

$arrCategory    = [
                    'parent' => [
                            'name'          => 'Danh mục',
                            'controller'    => 'category',
                            'link'          => $linkCategory,
                            'child' => $childCategory
                    ],
];

$menuHome       = HTML::createMenuHeaderFrontend($this->arrParam['controller'], $arrHome);
$menuBook       = HTML::createMenuHeaderFrontend($this->arrParam['controller'], $arrBook);
$menuCategory   = HTML::createMenuHeaderFrontend($this->arrParam['controller'], $arrCategory);
unset($arrHome, $arrBook, $arrCategory);

?>

<div class="loader_skeleton">
    <div class="typography_section">
        <div class="typography-box">
            <div class="typo-content loader-typo">
                <div class="pre-loader"></div>
            </div>
        </div>
    </div>
</div>

<!-- header start -->
<header class="my-header sticky">
    <div class="mobile-fix-option"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-menu">
                    <div class="menu-left">
                        <div class="brand-logo">
                            <a href="<?php echo $linkHome; ?>">
                                <h2 class="mb-0" style="color: #5fcbc4">BookStore</h2>
                            </a>
                        </div>
                    </div>
                    <div class="menu-right pull-right">
                        <div>
                            <nav id="main-nav">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                    <?php echo $menuHome . $menuBook . $menuCategory ?>
                                </ul>
                            </nav>
                        </div>

                        <?php require_once 'icons_header_layout.php'; ?>
                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end -->