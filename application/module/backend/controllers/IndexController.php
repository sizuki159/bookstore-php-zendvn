<?php
class IndexController extends BackendController
{

    public function indexAction()
    {
        URL::redirect($this->_moduleName, 'dashboard', 'index');
    }
    
    public function changePasswordAction()
    {
        if(isset($this->_arrParam['form']['token']))
        {
            $idUser         = $this->infoUserLogin['info']['id'];
            $dataForm       = $this->_arrParam['form'];
            $passCurrent    = $this->_model->getPassword($idUser);
            $oldPass        = md5($dataForm['old_pass']);
            $newPass        = $dataForm['new_pass'];
            $newPassAgain   = $dataForm['new_pass_again'];

            $this->_validate->validateChangePassword();
            if($this->_validate->isValid())
            {
                if($newPass == $newPassAgain && strlen($newPass) >= 6 && strlen($newPassAgain) >= 6)
                {
                    if($oldPass == $passCurrent)
                    {
                        $newPass = md5($newPass);
                        $this->_model->query("UPDATE " .TBL_USER. " SET `password` = '$newPass' WHERE `id` = '$idUser'");
                        URL::redirect($this->_moduleName, 'index', 'logout');
                    }
                    else
                    {
                        $this->_view->errors = 'Mật khẩu cũ không đúng';
                    }
                }
                else
                {
                    $this->_view->errors = 'Mật khẩu mới không hợp lệ';
                }
            }
            else
            {
                $this->_view->errors = $this->_validate->showErrorsAdmin();
            }
        }

        $this->_view->_title = 'Change Password';
        $this->_view->render('index/changepass');
    }

    public function loginAction()
    {
        if(Session::get('user')['isLogin'])
            URL::redirect($this->_moduleName, 'dashboard', 'index');

        $this->_templateObj->setFolderTemplate('admin/adminlte/');
        $this->_templateObj->setFileTemplate('login.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();

        if (isset($this->_arrParam['form']['token']))
        {
            $username = $this->_arrParam['form']['username'];
            $password = md5($this->_arrParam['form']['password']);
            $query = "SELECT `id` FROM `user` WHERE `username` = '$username' AND `password` = '$password'";
            $this->_model->query($query);

            if($this->_model->affectedRows() > 0)
            {
                $infoUser = $this->_model->infoItem($this->_arrParam);
                $arraySession = [
                        'isLogin' => true,
                        'info' => $infoUser,
                        'time' => time(),
                        'group_acp' => $infoUser['group_acp']
                ];
                if(!empty($infoUser))
                    Session::set('user', $arraySession);
                    
                URL::redirect($this->_moduleName, 'dashboard', 'index');
            }
            else
            {
                $this->_view->errors = 'Đăng nhập thất bại';
            }
        }

        $this->_view->render('index/login');
    }

    public function logoutAction()
    {
        Session::delete('user');
        URL::redirect($this->_moduleName, $this->_controllerName, 'login');
    }

    public function profileAction()
    {
        $this->_view->arrParam['form'] = $this->_model->infoItem($this->_arrParam, 'profile');

        if(isset($this->_arrParam['form']['token']))
        {
            $this->_validate->validateProfile($this->_arrParam);
            $this->_arrParam['form'] = $this->_validate->getResult();

            if($this->_validate->isValid())
            {
                $this->_model->saveInfoProfile($this->_arrParam);
                if ($this->_arrParam['type'] == 'save')         URL::redirect($this->_moduleName, $this->_controllerName, 'profile');
            }
            else
            {
                $this->_view->errors = $this->_validate->showErrorsAdmin();
            }

        }

        $this->_view->_title = 'My Profile';
        $this->_view->render('index/profile');
    }

    public function forgotAction()
    {
        echo '<h3>' . __METHOD__ . '<h3>';
    }
}
