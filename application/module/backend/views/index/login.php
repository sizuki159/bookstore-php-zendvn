<?php

$linkAction         = URL::createLink('backend', 'index', 'login');
$linkForgotPassword = URL::createLink('frontend', 'index', 'forgot');

?>


<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>Admin Control Panel</b>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <!-- Errors -->
                <?php
                echo $this->errors;
                ?>

                <form action="<?php echo $linkAction; ?>" method="post">

                    <!-- USER NAME -->
                    <div class="input-group mb-3">
                        <input name="form[username]" type="text" class="form-control" placeholder="Email or Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="input-group mb-3">
                        <input name="form[password]" type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <!-- TOKEN -->
                    <input name="form[token]" type="hidden" value="<?php echo md5(time()); ?>">

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


                <p class="mb-1">
                    <a href="<?php echo $linkForgotPassword; ?>">I forgot my password</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <?php echo $this->_jsFiles; ?>

</body>