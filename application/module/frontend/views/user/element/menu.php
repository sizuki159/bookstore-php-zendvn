<div class="col-lg-3">
    <div class="account-sidebar">
        <a class="popup-btn">Menu</a>
    </div>
    <h3 class="d-lg-none">Tài khoản</h3>
    <div class="dashboard-left">
        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> Ẩn</span></div>
        <div class="block-content">
            <ul id="menu-account">
                <li id="account-info"><a href="<?php echo URL::createLink('frontend', 'user', 'profile', null, 'my-account.html'); ?>">Thông tin tài khoản</a></li>
                <li id="account-change-pass"><a href="<?php echo URL::createLink('frontend', 'user', 'changePass', null, 'change-password.html'); ?>">Thay đổi mật khẩu</a></li>
                <li id="account-history-order"><a href="<?php echo URL::createLink('frontend', 'user', 'orderHistory', null, 'order-history.html'); ?>">Lịch sử mua hàng</a></li>
                <li><a href="<?php echo $linkLogout; ?>">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </div>
</div>