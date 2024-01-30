<?php

class UserController extends FrontendController
{
    public function profileAction()
    {
        $this->_view->arrParam['form'] = $this->_model->infoAccount($this->_arrParam);

        if (isset($this->_arrParam['form']['token'])) {
            $this->_validate->validateProfile($this->_arrParam);
            $this->_arrParam['form'] = $this->_validate->getResult();
            if ($this->_validate->isValid()) {
                $this->_model->saveInfoProfile($this->_arrParam);
                $this->_view->arrParam = $this->_arrParam;
            } else {
                $this->_view->errors = $this->_validate->showErrors();
            }
        }

        $this->_view->setTitle('My Profile');
        $this->_view->render('user/profile');
    }

    public function orderHistoryAction()
    {
        $username         = $this->infoUserLogin['info']['username'];

        $this->_view->listOrderHistory = $this->_model->getOrderHistory($username);

        $this->_view->setTitle('My Profile');
        $this->_view->render('user/order-history');
    }


    public function changePassAction()
    {
        if (isset($this->_arrParam['form']['token'])) {
            $idUser         = $this->infoUserLogin['info']['id'];
            $dataForm       = $this->_arrParam['form'];
            $passCurrent    = $this->_model->getPassword($idUser);
            $oldPass        = md5($dataForm['old_pass']);
            $newPass        = $dataForm['new_pass'];
            $newPassAgain   = $dataForm['new_pass_again'];

            $this->_validate->validateChangePassword();
            if ($this->_validate->isValid()) {
                if ($newPass == $newPassAgain && strlen($newPass) >= 6 && strlen($newPassAgain) >= 6) {
                    if ($oldPass == $passCurrent) {
                        $newPass = md5($newPass);
                        $this->_model->query("UPDATE " . TBL_USER . " SET `password` = '$newPass' WHERE `id` = '$idUser'");
                        URL::redirect($this->_moduleName, 'index', 'logout', null, 'logout.html');
                    } else {
                        $this->_view->errors = 'Mật khẩu cũ không đúng';
                    }
                } else {
                    $this->_view->errors = 'Mật khẩu mới không hợp lệ';
                }
            } else {
                $this->_view->errors = $this->_validate->showErrorsAdmin();
            }
        }

        $this->_view->setTitle('My Profile');
        $this->_view->render('user/changepass');
    }

    public function orderAction()
    {
        $infoBook = $this->_model->infoBook($this->_arrParam);
        if (empty($infoBook))
            URL::redirect404();

        $cart       = Session::get('cart');
        $bookID     = $this->_arrParam['book_id'];
        $price      = ($infoBook['price'] * (1 - ($infoBook['sale_off'] / 100)));
        $quantity   = $this->_arrParam['quantity'];

        if (empty($cart)) {
            $cart['quantity'][$bookID]  = $quantity;
            $cart['price'][$bookID]     = $price * $cart['quantity'][$bookID];
        } else {
            if (key_exists($bookID, $cart['quantity'])) {
                $cart['quantity'][$bookID] += $quantity;
                $cart['price'][$bookID]     = $price * $cart['quantity'][$bookID];
            } else {
                $cart['quantity'][$bookID]  = $quantity;
                $cart['price'][$bookID]     = $price * $cart['quantity'][$bookID];
            }
        }


        Session::set('cart', $cart);

        URL::redirect($this->_moduleName, 'user', 'cart', null, 'cart.html');
    }

    public function cartAction()
    {
        $listCart               = Session::get('cart');
        $infoBookOfListCart     = $this->_model->infoBook($this->_arrParam, ['task' => 'in-ids', 'data' => ['ids' => array_keys($listCart['quantity'])]]);
        $this->_view->listCart  = $listCart;
        $this->_view->infoBookOfListCart = $infoBookOfListCart;
        $this->_view->setTitle('Giỏ hàng');
        $this->_view->render('user/cart');
    }

    public function buyAction()
    {
        $cart = Session::get('cart');
        if (empty($cart['quantity']) || empty($cart['price']))
            URL::redirect('frontend', 'index', 'notice', ['type' => 'buy-error'], 'notice-buy-error.html');

        $result = $this->_model->buyItem($this->_arrParam);

        if ($result) {
            Session::delete('cart');
            URL::redirect('frontend', 'user', 'orderHistory', null, 'order-history.html');
        }

        URL::redirect('frontend', 'index', 'notice', ['type' => 'buy-error'], 'notice-buy-error.html');
    }



    public function deleteOrderAction()
    {
        $id = $this->_arrParam['id'];
        unset($_SESSION['cart']['price'][$id]);
        unset($_SESSION['cart']['quantity'][$id]);
        URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'cart', null, 'cart.html');
    }
}
