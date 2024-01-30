<?php
echo HTML::pageHeaderContentFrontend('giỏ hàng');
$arrInfoBook = $this->infoBookOfListCart;
$totalPrice = array_sum($this->listCart['price']);
$linkBuy = URL::createLink('frontend', 'user', 'buy');


$xhtml = '';
if (!empty($this->listCart['quantity'])) {

    $xhtml .= '
    
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table cart-table table-responsive-xs">
                        <thead>
                            <tr class="table-head">
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên sách</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col"></th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                        </thead>

                        <tbody>
    
    
    ';


    foreach ($this->listCart['quantity'] as $bookID => $quantity) {
        $name       = $arrInfoBook[$bookID]['name'];
        $linkPicture = UPLOAD_URL . 'book' . DS . $arrInfoBook[$bookID]['picture'];
        $pirce      = $this->listCart['price'][$bookID];
        $pirce      = HTML::formatCurrency($pirce);
        $priceFinal = HTML::formatCurrency($arrInfoBook[$bookID]['price'] * (1 - ($arrInfoBook[$bookID]['sale_off'] / 100)));
        $linkDetail = URL::createLinkBookDetail($bookID, $arrInfoBook[$bookID]['category_id']);
        $linkDelete = URL::createLink('frontend', 'user', 'deleteOrder', ['id' => $bookID]);

        $xhtml .= '
        <tr>
            <td>
                <a href="' . $linkDetail . '"><img src="' . $linkPicture . '"
                        alt="' . $name . '"></a>
            </td>
            <td><a href="' . $linkDetail . '">' . $name . '</a>
                <div class="mobile-cart-content row">
                    <div class="col-xs-3">
                        <div class="qty-box">
                            <div class="input-group">
                                <input type="text" name="quantity" value="' . $quantity . '"
                                    class="form-control input-number" id="quantity-' . $bookID . '" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <h2 class="td-color text-lowercase">' . $pirce . '</h2>
                    </div>
                    <div class="col-xs-3">
                        <h2 class="td-color text-lowercase">
                            <a href="' . $linkDelete . '" class="icon"><i class="ti-close"></i></a>
                        </h2>
                    </div>
                </div>
            </td>
            <td>
                <h2 class="text-lowercase">' . $priceFinal . '</h2>
            </td>
            <td>
                <div class="qty-box">
                    <div class="input-group">
                        <input type="number" name="quantity" value="' . $quantity . '"
                            class="form-control input-number" id="quantity-' . $bookID . '" min="1">
                    </div>
                </div>
            </td>
            <td><a href="' . $linkDelete . '" class="icon"><i class="ti-close"></i></a></td>
            <td>
                <h2 class="td-color text-lowercase">' . $pirce . '</h2>
            </td>
        </tr>
        
        ';
    }

    $xhtml .= '
    
                        </tbody>
                    </table>
                    <table class="table cart-table table-responsive-md">
                        <tfoot>
                            <tr>
                                <td>Tổng :</td>
                                <td>
                                    <h2 class="text-lowercase">'.HTML::formatCurrency($totalPrice).'</h2>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
        </div>
        </div>
        <div class="row cart-buttons">
        <div class="col-6"><a href="'.URL::createLink('frontend', 'book', 'index', null, 'books.html').'" class="btn btn-solid">Tiếp tục mua sắm</a></div>
                <div class="col-6"><a type="button" href="'.$linkBuy.'" class="btn btn-solid">Đặt hàng</a></div>
            </div>
        </div>
    </section>
        
    
    ';
}else{
    $xhtml = '
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <i class="fa fa-cart-plus fa-5x my-text-primary"></i>
                    <h5 class="my-3">Không có sản phẩm nào trong giỏ hàng của bạn</h5>
                    <a href="books.html" class="btn btn-solid">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </section>
    ';
}

?>


<!-- <form action="" method="POST" name="admin-form" id="admin-form"> -->
<?php echo $xhtml; ?>


<!-- </form> -->

<!-- <input type="hidden" name="form[book_id][]" value="10" id="input_book_id_10">
            <input type="hidden" name="form[price][]" value="48300" id="input_price_10">
            <input type="hidden" name="form[quantity][]" value="1" id="input_quantity_10">
            <input type="hidden" name="form[name][]" value="'.$name.'"
                id="input_name_10"><input type="hidden" name="form[picture][]" value="product.jpg"
                id="input_picture_10"> -->