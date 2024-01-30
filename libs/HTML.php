<?php
class HTML
{

    public static function formatCurrency($number, $unit = 'đ')
    {
        return number_format($number) . " $unit";
    }

    // creat ALL
    public static function createSidebar($controller, $action, $arr)
    {
        $action     = ucfirst($action);
        $controller = ucfirst($controller);
        $parent     = $arr['parent'];
        $child      = $arr['child'];

        if (isset($child)) {
            if ($controller == $parent['name']) {
                $openMenu = 'has-treeview menu-open';
                $activeP = 'active';
            }
            $html = '   <li class="nav-item ' . $openMenu . '"> 
                            <a href="' . $parent['link'] . '" class="nav-link ' . $activeP . '">
                                <i class="nav-icon fas fa-' . $parent['icon'] . '"></i>
                                <p>' . $parent['name'] . '<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">';
            $action = ($action == 'Index') ? 'List' : $action;

            foreach ($child as $key => $value) {
                $active = "";
                if ($controller == $parent['name'] && $action == $value['name']) $active = 'active';
                $html .=    '<li class="nav-item">
                                <a href="' . $value['link'] . '" class="nav-link ' . $active . '" >
                                    <i class="nav-icon fas fa-' . $value['icon'] . '"></i>
                                    <p>' . $value['name'] . '</p>
                                </a>
                            </li>';
            }
            $html .= '</ul></li>';
        } else {
            if ($controller == $parent['name']) {
                $activeP = 'active';
            }
            $html = '   <li class="nav-item "> 
                            <a href="' . $parent['link'] . '" class="nav-link ' . $activeP . '">
                                <i class="nav-icon fas fa-' . $parent['icon'] . '"></i>
                                <p>' . $parent['name'] . '</p>
                            </a>
                        </li>';
        }
        return $html;
    }

    // Create Item Checkbox
    public static function showItemCheckbox($id)
    {
        $xhtml = '
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" type="checkbox" id="checkbox-' . $id . '" name="checkbox[]" value="' . $id . '">
			<label for="checkbox-' . $id . '" class="custom-control-label"></label>
		</div>
		';
        return $xhtml;
    }

    // Create Item State
    public static function showItemState($link, $state, $useAjax = false)
    {
        $classUseAjax = $useAjax ? 'my-btn-ajax ' : '';

        $class = 'success';
        $icon = 'check';
        if ($state == 'inactive' || $state == '0') {
            $class = 'danger';
            $icon = 'minus';
        }

        $xhtml = '
		<a href="' . $link . '" class="my-btn-state ' . $classUseAjax . 'rounded-circle btn btn-sm btn-' . $class . '"><i class="fas fa-' . $icon . '"></i></a>
		';
        return $xhtml;
    }

    // Create Item History
    public static function showItemHistory($by, $time)
    {
        $time = Helper::formatDate(DATETIME_FORMAT, $time);
        $xhtml = '
		<p class="mb-0 history-by"><i class="far fa-user"></i> ' . $by . '</p>
        <p class="mb-0 history-time"><i class="far fa-clock"></i> ' . $time . '</p>
		';
        return $xhtml;
    }

    // HightLight
    public static function highLight($input, $searchValue)
    {
        $result = $input;
        if ($searchValue != '') {
            $result = preg_replace("/" . preg_quote($searchValue, "/") . "/i", "<mark>$0</mark>", $input);
        }
        return $result;
    }

    public static function showFilterButton($module, $controller, $itemStatusCount, $currentFilterStatus)
    {
        $xhtml = '';
        foreach ($itemStatusCount as $key => $value) {
            $link = URL::createLink($module, $controller, 'index', ['status' => $key]);
            $name = '';
            switch ($key) {
                case 'all':
                    $name = 'All';
                    break;
                case 'active':
                    $name = 'Active';
                    break;
                case 'inactive':
                    $name = 'Inactive';
                    break;
            }

            $linkParam = '';
            $linkParam .= isset($_GET['filter_group_acp']) ? '&filter_group_acp=' . $_GET['filter_group_acp'] : '';
            $linkParam .= isset($_GET['search']) ? '&search=' . $_GET['search'] : '';
            $link .= $linkParam;

            $active = $key == $currentFilterStatus ? 'info' : 'secondary';
            $xhtml .= '<a href="' . $link . '" class="mr-1 btn btn-sm btn-' . $active . '">' . $name . ' <span class="badge badge-pill badge-light">' . $value . '</span></a>';
        }
        return $xhtml;
    }

    public static function showMessage()
    {
        $message = Session::get('notify') ?? '';
        Session::delete('notify');

        if (!empty($message)) {
            $message = '
            <div class="alert alert-' . $message['type'] . ' alert-dismissible" id="admin-message">
                <button type="button" class="close p-2" data-dismiss="alert" aria-hidden="true">×</button>
                <p class="mb-0">' . $message['message'] . '</p>
            </div>
            ';
        }

        return $message;
    }

    public static function createActionButton($link, $class, $textContent, $icon = '')
    {
        if ($icon != '') {
            $icon = '<i class="fas fa-' . $icon . '"></i>';
        }
        $xhtml = sprintf('<a href="%s" class="btn btn-sm %s">%s %s</a>', $link, $class, $icon, $textContent);
        return $xhtml;
    }

    public static function showInfoUser($username, $fullname, $email)
    {
        $xhtml = '
        <p class="mb-0">Username: ' . $username . '</p>
        <p class="mb-0">Fullname: ' . $fullname . '</p>
        <p class="mb-0">Email: ' . $email . '</p>
        ';

        return $xhtml;
    }

    public static function showInfoUserBuyItem($fullname, $address, $email, $phone)
    {
        $xhtml = '
        <p class="mb-0">Họ và tên: ' . $fullname . '</p>
        <p class="mb-0">Địa chỉ: ' . $address . '</p>
        <p class="mb-0">Email: ' . $email . '</p>
        <p class="mb-0">Phone: ' . $phone . '</p>
        ';

        return $xhtml;
    }

    public static function createSelectBox($arrData = null, $name = null, $class = null, $style = null, $id = null, $dataID = null, $keySelected = null)
    {
        $name   = ($name != null) ? 'name="' . $name . '"' : '';
        $class  = ($class != null) ? 'class="' . $class . '"' : '';
        $id     = ($id != null) ? 'id="' . $id . '"' : '';
        $dataID = ($dataID != null) ? 'data-id="' . $dataID . '"' : '';
        $style  = ($style != null) ? 'style="' . $style . '"' : '';

        $xhtml  = '<select ' . $name . ' ' . $class . ' ' . $style . ' ' . $id . ' ' . $dataID . '>';
        if (!empty($arrData)) {
            foreach ($arrData as $value) {
                if ($keySelected == $value['id']) {
                    $xhtml .= '<option value="' . $value['id'] . '" selected>' . $value['name'] . '</option>';
                } else {
                    $xhtml .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                }
            }
        }
        $xhtml .= '</select>';

        return $xhtml;
    }

    public static function createDashboard($name, $amount, $linkMore, $classBg = "bg-info", $iconFrontAwesome = "ion-ios-people")
    {
        $xhtml = '
        <div class="col-lg-3 col-6">
        <div class="small-box ' . $classBg . '">
            <div class="inner">
                <h3>' . $amount . '</h3>
                <p>' . $name . '</p>
            </div>
            <div class="icon text-white">
                <i class="ion ' . $iconFrontAwesome . '"></i>
            </div>
            <a href="' . $linkMore . '" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        
        </div>
        ';
        return $xhtml;
    }

    // ----------------------------------------- FRONT END -----------------------------------------

    public static function cmsRowFormFrontEnd($lblName, $input, $submit = false)
    {
        $xhtml = '';
        if (!$submit) {
            $xhtml = '
            <div class="col-md-6">
                <label>' . $lblName . '</label>
                ' . $input . '
            </div>';
        } else {
            $xhtml = '
            <div class="col-md-6">
                ' . $input . '
            </div>';
        }
        return $xhtml;
    }

    public static function pageHeaderContentFrontend($title)
    {
        $xhtml = '
        <div class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title">
                            <h2 class="py-2">
                                ' . $title . '
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';

        return $xhtml;
    }

    public static function showProductFrontend($arrInfoBook = [])
    {
        $bookID             = $arrInfoBook['id'];
        $categoryID         = $arrInfoBook['category_id'];
        $linkRouter         = URL::filterURL($arrInfoBook['category_name']) . DS . URL::filterURL($arrInfoBook['name']) . "-$categoryID-$bookID.html";
        $linkItem           = URL::createLink('frontend', 'book', 'item', ['category_id' => $arrInfoBook['category_id'], 'id' => $bookID], $linkRouter);
        $priceAfterDiscount = $arrInfoBook['price'] * (1 - ($arrInfoBook['sale_off'] / 100));
        $price              = HTML::formatCurrency($arrInfoBook['price']);
        $priceAfterDiscount = HTML::formatCurrency($priceAfterDiscount);
        $linkPicture        = UPLOAD_URL . 'book' . DS . $arrInfoBook['picture'];
        $linkBuy            = URL::createLink('frontend', 'user', 'order', ['book_id' => $bookID, 'quantity' => 1]);

        $xhtml = '
        <div class="product-box">
            <div class="img-wrapper">
                <div class="lable-block">
                    <span class="lable4 badge badge-danger"> -' . $arrInfoBook['sale_off'] . '%</span>
                </div>
                <div class="front">
                    <a href="' . $linkItem . '">
                        <img src="' . $linkPicture . '" class="img-fluid blur-up lazyload bg-img" alt="product">
                    </a>
                </div>
                <div class="cart-info cart-wrap">
                    <a href="'.$linkBuy.'" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                    <a href="javascript:quickView('.$bookID.')" title="Quick View"><i class="ti-search" data-toggle="modal" data-target="#quick-view"></i></a>
                </div>
            </div>
            <div class="product-detail">
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
                <a href="' . $linkItem . '" title="'.$arrInfoBook['name'].'">
                    <h6>' . $arrInfoBook['name'] . '...</h6>
                </a>
                <h4 class="text-lowercase">' . $priceAfterDiscount . ' <del>' . $price . '</del></h4>
            </div>
        </div>
        ';

        return $xhtml;
    }

    // SHOW DETAIL PRODUCT FRONTEND
    public static function showDetailProductFrontend($arrInfoBook = [])
    {
        $disCount           = $arrInfoBook['sale_off'];
        $priceAfterDiscount = $arrInfoBook['price'] * (1 - ($disCount / 100));
        $price              = HTML::formatCurrency($arrInfoBook['price']);
        $priceAfterDiscount = HTML::formatCurrency($priceAfterDiscount);
        $name               = $arrInfoBook['name'];
        $description        = $arrInfoBook['description'];
        $linkPicture        = UPLOAD_URL . 'book' . DS . $arrInfoBook['picture'];
        $linkBuy            = URL::createLink('frontend', 'user', 'order', ['book_id' => $arrInfoBook['id'], 'quantity' => 1]);

        $xhtml = '
        <div class="col-lg-9 col-sm-12 col-xs-12">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="filter-main-btn mb-2"><span class="filter-btn"><i class="fa fa-filter" aria-hidden="true"></i> filter</span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="product-slick">
                            <div><img src="'.$linkPicture.'" alt="" class="img-fluid w-100 blur-up lazyload image_zoom_cls-0"></div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-8 rtl-text">
                        <div class="product-right">
                            <h2 class="mb-2">'.$name.'</h2>
                            <h4><del>'.$price.' đ</del><span> -'.$disCount.'%</span></h4>
                            <h3>'.$priceAfterDiscount.'</h3>
                            <div class="product-description border-product">
                                <h6 class="product-title">Số lượng</h6>
                                <div class="qty-box">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                                <i class="ti-angle-left"></i>
                                            </button>
                                        </span>
                                        <input type="text" name="quantity" class="form-control input-number" value="1">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                                <i class="ti-angle-right"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-buttons">
                                <a href="'.$linkBuy.'" class="btn btn-add-to-cart btn-solid ml-0"><i class="fa fa-cart-plus"></i> Chọn mua</a>
                            </div>
                            <div class="border-product">
                                '.$description.'
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="tab-product m-0">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-selected="true">Mô tả sản phẩm</a>
                                    <div class="material-border"></div>
                                </li>
                            </ul>
                            <div class="tab-content nav-material" id="top-tabContent">
                                <div class="tab-pane fade show active ckeditor-content" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                    '.$description.'
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        ';

        return $xhtml;
    }

    public static function showProductBySlideFrontend($title = 'Sách nổi bật', $numberOfBookShowInOneSlide = 4, $arrProduct, $arrParam, $class = '')
    {
        $totalBookSpecial   = count($arrProduct);
        $totalSlider        = ceil($totalBookSpecial / $numberOfBookShowInOneSlide);
        
        $xhtml = '
        <div class="theme-card '.$class.'">
            <h5 class="title-border">'.$title.'</h5>
            <div class="offer-slider slide-1">
        ';
        
        $currentBook = 0;
        
        for($i = 0; $i < $totalSlider; $i++)
        {
            $xhtml .= '<div>';
        
            $count = 0;
            for($j = $currentBook; $j < $totalBookSpecial && $count < $numberOfBookShowInOneSlide; $j++, $count++)
            {
                $id = $arrProduct[$j]['id'];
                $categoryID     = $arrProduct[$j]['category_id'];
                $categoryName   = $arrProduct[$j]['category_name'];
                $linkPicture = UPLOAD_URL . 'book' . DS . $arrProduct[$j]['picture'];
                $name   = $arrProduct[$j]['name'];
                $price  = HTML::formatCurrency($arrProduct[$j]['price']);
                $linkRouter         = URL::filterURL($categoryName) . DS . URL::filterURL($name) . "-$categoryID-$id.html";
                $linkDetail = URL::createLink($arrParam['module'], 'book', 'item', ['category_id' => $arrProduct[$j]['category_id'], 'id' => $id], $linkRouter);
                $xhtml .= '
                <div class="media">
                    <a href="'.$linkDetail.'">
                        <img class="img-fluid blur-up lazyload" src="'.$linkPicture.'" alt="'.$name.'"></a>
                    <div class="media-body align-self-center">
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <a href="'.$linkDetail.'" title="'.$name.'">
                            <h6>'.$name.'</h6>
                        </a>
                        <h4 class="text-lowercase">'.$price.'</h4>
                    </div>
                </div>
                ';
                $currentBook = $j + 1;
            }
            $xhtml .= '</div>';
        }
        
        $xhtml .= ' 
            </div>
        </div>
        ';

        // $count = 0;
        // foreach($this->listItemBookSpecial as $key => $book)
        // {
        //     $linkPicture = UPLOAD_URL . 'book' . DS . $book['picture'];
        //     $count++;
        //     if($count > $numberOfBookShowInOneSlider)
        //         break;
                
        //     $xhtml .= '
        //     <div class="media">
        //         <a href="item.html">
        //             <img class="img-fluid blur-up lazyload" src="'.$linkPicture.'" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
        //         <div class="media-body align-self-center">
        //             <div class="rating">
        //                 <i class="fa fa-star"></i>
        //                 <i class="fa fa-star"></i>
        //                 <i class="fa fa-star"></i>
        //                 <i class="fa fa-star"></i>
        //                 <i class="fa fa-star"></i>
        //             </div>
        //             <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
        //                 <h6>'.$book['name'].'</h6>
        //             </a>
        //             <h4 class="text-lowercase">'.$book['price'].'</h4>
        //         </div>
        //     </div>
            
        //     ';

        //     $currentBook = $key;

        // }

        return $xhtml;
        
    }

    // CREATE MENU HOME FRONTEND
    public static function createMenuHeaderFrontend($controllerName, $arrData)
    {
        $xhtml = '';
        if (!empty($arrData)) {
            foreach ($arrData as $menuLevelOne) {
                $xhtml .= '<li>';
                $classActive = ($controllerName == $menuLevelOne['controller']) ? 'active' : '';

                $xhtml .= '<a href="' . $menuLevelOne['link'] . '" class="my-menu-link ' . $classActive . '">' . $menuLevelOne['name'] . '</a>';
                if (isset($menuLevelOne['child']) && !empty($menuLevelOne['child'])) {
                    $xhtml .= '<ul>';
                    foreach ($menuLevelOne['child'] as $menuLevelTwo) {
                        $xhtml .= '<li><a href="' . $menuLevelTwo['link'] . '">' . $menuLevelTwo['name'] . '</a></li>';
                    }
                    $xhtml .= '</ul>';
                }

                $xhtml .= '</li>';
            }
        }

        return $xhtml;
    }

    public static function showStatusFrontend($status)
    {
        $status = '';

        switch($status)
        {
            case 'pending':
                $status .= '<span style="color: pink">Chờ xác nhận...</span>';
                break;
            case 'inactive':
                $status .= '<span style="color: red">Đã hủy</span>';
                break;
            case 'active':
                $status .= '<span style="color: closure">Đang giao hàng...</span>';
                break;
            case 'success':
                $status .= '<span style="color: blue">Hoàn tất</span>';
                break;
            default:
                $status .= '<span style="color: black">Lỗi không xác định!</span>';
                break;  
        }

        return $status;
    }
}
