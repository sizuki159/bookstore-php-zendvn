<?php

echo HTML::pageHeaderContentFrontend('Thay đổi mật khẩu');


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
                                <label for="old_pass">Mật khẩu hiện tại</label>
                                <input type="password" name="form[old_pass]" value="<?php echo $fullname ?>" class="form-control" id="old_pass">
                            </div>

                            <div class="form-group">
                                <label for="new_pass">Mật khẩu mới</label>
                                <input type="password" name="form[new_pass]" value="<?php echo $phone ?>" class="form-control" id="new_pass">
                            </div>

                            <div class="form-group">
                                <label for="new_pass_again">Nhập lại mật khẩu mới</label>
                                <input type="password" name="form[new_pass_again]" value="<?php echo $address ?>" class="form-control" id="new_pass_again">
                            </div>
                            <input type="hidden" id="form[token]" name="form[token]" value="<?php echo md5((time())); ?>"><button type="submit" id="submit" name="submit" value="Cập nhật thông tin" class="btn btn-solid btn-sm">Cập nhật thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>