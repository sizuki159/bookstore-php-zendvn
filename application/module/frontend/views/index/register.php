<?php

$dataForm = $this->arrParam['form'];

$inputUsername  = Helper::cmsInput('text', 'form[username]', 'form[username]', $dataForm['username'], "form-control");
$inputPassword  = Helper::cmsInput('text', 'form[password]', 'form[password]', $dataForm['password'], "form-control");
$inputFullname  = Helper::cmsInput('text', 'form[fullname]', 'form[fullname]', $dataForm['fullname'], "form-control");
$inputEmail     = Helper::cmsInput('email', 'form[email]', 'form[email]', $dataForm['email'], "form-control");
$inputToken     = Helper::cmsInput('hidden', 'form[token]', 'form[token]', md5(time()));

$rowUsername    = HTML::cmsRowFormFrontEnd("Tên Tài Khoản", $inputUsername);
$rowPassword    = HTML::cmsRowFormFrontEnd("Mật khẩu", $inputPassword);
$rowFullname    = HTML::cmsRowFormFrontEnd("Họ và Tên", $inputFullname);
$rowEmail       = HTML::cmsRowFormFrontEnd("Email", $inputEmail);

$linkAction     = URL::createLink('frontend', 'index', 'register', null, 'register.html');


?>

<?php echo HTML::pageHeaderContentFrontend('đăng kí tài khoản') ?>


<section class="register-page section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Đăng ký tài khoản</h3>
                <?php echo $this->errors; ?>
                <div class="theme-card">
                    <form action="<?php echo $linkAction; ?>" method="post" id="admin-form" class="theme-form">
                        <div class="form-row">
                            <?php echo $rowUsername . $rowFullname . $rowEmail . $rowPassword . $inputToken?>
                        </div>
                        <button type="submit" id="form[submit]" name="form[submit]" value="Tạo tài khoản" class="btn btn-solid">Tạo tài khoản</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>