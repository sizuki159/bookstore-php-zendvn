<?php

$linkHome           = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], 'home', null, 'home.html');

$pageHeaderContent  = '';
$errorCode          = 'oops!';
$message            = '';

switch ($this->arrParam['type']) {
    case 'not-url':
        $pageHeaderContent  = 'KHÔNG TÌM THẤY TRANG YÊU CẦU';
        $errorCode          = '404';
        $message            = 'ĐƯỜNG DẪN KHÔNG HỢP LỆ';
        break;
    case 'register-success':
        $errorCode          = 'SUCCESS';
        $message = 'Tài khoản đã được đăng kí thành công, vui lòng chờ quản trị viên kích hoạt tài khoản!';
        break;
    case 'register-error':
        $message = 'Tài khoản đăng kí thất bại! Xin vui lòng thử lại';
        break;
    case 'not-permission':
        $message = 'Bạn không có quyền truy cập vào nội dung này!';
        break;
    case 'buy-error':
        $message = 'Đặt hàng thất bại. Vui lòng thử lại!';
        break;
}
?>


<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2"><?php echo $pageHeaderContent; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="p-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="error-section">
                    <h1><?php echo $errorCode; ?></h1>
                    <h2><?php echo $message; ?></h2>
                    <a href="<?php echo $linkHome ?>" class="btn btn-solid">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</section>