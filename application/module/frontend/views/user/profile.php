<?php

echo HTML::pageHeaderContentFrontend('Thông Tin Tài khoản');


$dataForm   = $this->arrParam['form'];
$email      = $dataForm['email'];
$username   = $dataForm['username'];
$fullname   = $dataForm['fullname'];
$phone      = $dataForm['phone'];
$address    = $dataForm['address'];

?>

<section class="faq-section section-b-space">
    <div class="container">
        <div class="row">
            <?php include_once 'element/menu.php'; ?>
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard">
                        <form action="" method="post" id="admin-form" class="theme-form">
                            <?php echo $this->errors; ?>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="form[email]" value="<?php echo $email ?>" class="form-control" id="email" readonly="1">
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="form[username]" value="<?php echo $username ?>" class="form-control" id="username" readonly="1">
                            </div>

                            <div class="form-group">
                                <label for="fullname">Họ tên</label>
                                <input type="text" name="form[fullname]" value="<?php echo $fullname ?>" class="form-control" id="fullname">
                            </div>

                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="phone" name="form[phone]" value="<?php echo $phone ?>" class="form-control" id="phone">
                            </div>

                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" name="form[address]" value="<?php echo $address ?>" class="form-control" id="address">
                            </div>
                            <input type="hidden" id="form[token]" name="form[token]" value="<?php echo md5((time())); ?>"><button type="submit" id="submit" name="submit" value="Cập nhật thông tin" class="btn btn-solid btn-sm">Cập nhật thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>