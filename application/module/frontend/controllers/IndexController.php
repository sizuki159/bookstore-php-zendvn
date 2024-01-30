<?php

class IndexController extends FrontendController
{

    public function indexAction()
    {
        // URL::redirect($this->_moduleName, $this->_controllerName, 'home');
        $cart = Session::get('cart');
        echo '<pre style="color:red;font-weight:bold">';
        print_r($cart);
        echo '</pre>';
        die();
    }

    public function homeAction()
    {
        $this->_view->listBookSpecial               = $this->_model->getListBook($this->_arrParam, ['special' => true]);
        $this->_view->listBookOfCategorySpecial     = $this->_model->getListBook($this->_arrParam, ['task' => 'book-of-category-special']);
        $this->_view->slider                        = $this->_model->getSlider($this->_arrParam);
        $this->_view->render('index/home');
    }

    public function loginAction()
    {
        if(Session::get('user')['isLogin'])
            URL::redirect($this->_moduleName, $this->_controllerName, 'home');

        if (isset($this->_arrParam['form']['token']))
        {
            $email      = $this->_arrParam['form']['email'];
            $password   = md5($this->_arrParam['form']['password']);
            $query = "SELECT `id` FROM `user` WHERE `email` = '$email' AND `password` = '$password'";
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
                    
                URL::redirect($this->_moduleName, 'index', 'home', null, 'home.html');
            }
            else
            {
                $this->_view->errors = 'Đăng nhập thất bại';
            }

        }
        $this->_view->setTitle('Login Account Member');
        $this->_view->render('index/login');
    }
    
    public function logoutAction()
    {
        Session::delete('user');
        URL::redirect($this->_moduleName, $this->_controllerName, 'login', null, 'login.html');
    }

    public function registerAction()
    {
        if(Session::get('user')['isLogin'])
            URL::redirect($this->_moduleName, $this->_controllerName, 'home', 'home.html');

        if (isset($this->_arrParam['form']['submit'])) {
            $this->_validate->validateRegister($this->_arrParam, $this->_model);
            $this->_arrParam['form'] = $this->_validate->getResult();

            if ($this->_validate->isValid()) {
                $result = $this->_model->register($this->_arrParam);
                if ($result) {
                    URL::redirect($this->_moduleName, $this->_controllerName, 'notice', ['type' => 'register-success'], "notice-register-success");
                } else {
                    URL::redirect($this->_moduleName, $this->_controllerName, 'notice', ['type' => 'register-error'], "notice-register-error");
                }
            } else {
                $this->_view->errors = $this->_validate->showErrors();
            }
        }

        $this->_view->setTitle('Register Account');
        $this->_view->render('index/register');
    }

    public function noticeAction()
    {
        $this->_view->setTitle('Notice');
        $this->_view->render('index/notice');
    }
}
