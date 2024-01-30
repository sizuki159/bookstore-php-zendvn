<?php
echo HTML::pageHeaderContentFrontend('Lịch sử mua hàng');


$xhtml = '';
if (!empty($this->listOrderHistory)) {
    foreach ($this->listOrderHistory as $order)
    {
        $order['books']         = json_decode($order['books']);
        $order['prices']        = json_decode($order['prices']);
        $order['quantities']    = json_decode($order['quantities']);
        $order['names']         = json_decode($order['names']);
        $order['pictures']      = json_decode($order['pictures']);

        $status = '';
        switch($order['status'])
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

        $id     = $order['id'];
        $date   = date('d-m-Y H:i', strtotime($order['date']));


        $totalPrice = 0;
        $xhtmlOrderBook = '';
        foreach($order['books'] as $key => $bookID)
        {
            $linkPicture    = UPLOAD_URL . 'book' . DS . $order['pictures'][$key];
            $quantity       = $order['quantities'][$key];

            $price          = $order['prices'][$key];
            $priceFormat    = HTML::formatCurrency($price);
            $priceFinal     = $order['prices'][$key] * $quantity;
            $priceFinalFormat = HTML::formatCurrency($priceFinal);
            $totalPrice += $priceFinal;


            $bookName       = $order['names'][$key];
            $linkBookDetail = URL::createLink('frontend', 'book', 'item', ['categpry_id' => 1, 'id' => 1]);

            $xhtmlOrderBook .= '
            <tr>
                <td><a href="'.$linkBookDetail.'"><img src="'.$linkPicture.'" alt="'.$bookName.'" style="width: 80px"></a></td>
                <td style="min-width: 200px">'.$bookName.'</td>
                <td style="min-width: 100px">'.$priceFormat.'</td>
                <td>'.$quantity.'</td>
                <td style="min-width: 150px">'.$priceFinalFormat.'</td>
            </tr>
            ';

        }

        $xhtml .= '
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <button style="text-transform: none;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#'.$id.'">Mã đơn hàng:
                        '.$id.'</button>&nbsp;&nbsp;Thời gian: '.$date.' - Trạng thái: '.$status.'
                </h5>
            </div>
            <div id="'.$id.'" class="collapse" data-parent="#accordionExample" style="">
                <div class="card-body table-responsive">
                    <table class="table btn-table">
                        <thead>
                            <tr>
                                <td>Hình ảnh</td>
                                <td>Tên sách</td>
                                <td>Giá</td>
                                <td>Số lượng</td>
                                <td>Thành tiền</td>
                            </tr>
                        </thead>

                        <tbody>
                            '.$xhtmlOrderBook.'
                        </tbody>

                        <tfoot>
                            <tr class="my-text-primary font-weight-bold">
                                <td colspan="4" class="text-right">Tổng: </td>
                                <td>'.HTML::formatCurrency($totalPrice).'</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        ';
    }
}
else
{
    $xhtml = '<h3>Bạn chưa mua đơn hàng nào!</h3>';
}

?>

<section class="faq-section section-b-space">
    <div class="container">
        <div class="row">
            <?php include_once 'element/menu.php'; ?>
            <div class="col-lg-9">
                <div class="accordion theme-accordion" id="accordionExample">
                    <div class="accordion theme-accordion" id="accordionExample">

                        <?php echo $xhtml; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>