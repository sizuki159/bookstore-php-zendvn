<?php
class UserController extends BackendController
{

    public function indexAction()
    {
        $this->_view->_title = 'User Manager :: List';
        $totalItems                    = $this->_model->countItems($this->_arrParam);
        $configPagination = ['totalItemsPerPage'    => 4, 'pageRange' => 3];
        $this->setPagination($configPagination);
        $this->_view->pagination    = new Pagination($totalItems, $this->_pagination);
        $this->_view->countActive = $this->_model->countItems($this->_arrParam, ['task' => 'count-active']);
        $this->_view->countInactive = $this->_model->countItems($this->_arrParam, ['task' => 'count-inactive']);
        $this->_view->items = $this->_model->listItems($this->_arrParam);
        $this->_view->listItemGroup = $this->_model->getListGroup($this->_arrParam);
        $this->_view->render($this->_controllerName . '/index');
    }

    public function formAction()
    {
        $this->_view->_title = ucfirst($this->_controllerName) . ' Manager :: Add';
        $this->_view->listItemGroup = $this->_model->getListGroup($this->_arrParam);
        if (isset($this->_arrParam['id']) && !isset($this->_arrParam['form']['token'])) {
            if($this->infoUserLogin['info']['id'] == $this->_arrParam['id'])
                URL::redirect($this->_moduleName, $this->_controllerName, 'index');

            $this->_view->_title = ucfirst($this->_controllerName) . ' Manager :: Edit';
            $this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
            if (empty($this->_arrParam['form'])) URL::redirect($this->_moduleName, $this->_controllerName, 'index');
        }
        if (isset($this->_arrParam['form']['token'])) {
            $task = isset($this->_arrParam['form']['id']) ? 'edit' : 'add';
            $this->_validate->validate($this->_arrParam);
            $this->_arrParam['form'] = $this->_validate->getResult();
            if (!$this->_validate->isValid()) {
                $this->_view->errors = $this->_validate->showErrorsAdmin();
            } else {

                $id = $this->_model->saveItem($this->_arrParam, ['task' => $task, 'table' => 'user']);
                if ($this->_arrParam['type'] == 'save-close')   URL::redirect($this->_moduleName, $this->_controllerName, 'index');
                if ($this->_arrParam['type'] == 'save-new')     URL::redirect($this->_moduleName, $this->_controllerName, 'form');
                if ($this->_arrParam['type'] == 'save')         URL::redirect($this->_moduleName, $this->_controllerName, 'form', ['id' => $id]);
            }
        }
        $this->_view->arrParam = $this->_arrParam;
        $this->_view->render("{$this->_controllerName}/form");
    }

    public function resetPasswordAction()
    {
        if (!isset($this->_arrParam['id']) || $this->infoUserLogin['info']['id'] == $this->_arrParam['id'])
            URL::redirect($this->_moduleName, $this->_controllerName, 'index');

        $this->_view->_title = ucfirst($this->_controllerName) . ' Manager :: Reset Password';
        if (isset($this->_arrParam['id']) && !isset($this->_arrParam['form']['token'])) {
            $this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
            if (empty($this->_arrParam['form'])) URL::redirect($this->_moduleName, $this->_controllerName, 'index');
        }

        if (isset($this->_arrParam['form']['token'])) {
            $this->_validate->validateResetPassword();
            $this->_arrParam['form'] = $this->_validate->getResult();
            if (!$this->_validate->isValid()) {
                $this->_view->errors = $this->_validate->showErrorsAdmin();
            } else {
                // require_once LIBRARY_PATH . 'extends/php-mailer/function.php';
                $id = $this->_model->updatePassword($this->_arrParam);
                // $fullname       = $this->_arrParam['form']['fullname'];
                // $email          = $this->_arrParam['form']['email'];
                // $username       = $this->_arrParam['form']['username'];
                // $newPassword    = $this->_arrParam['form']['new_password'];
                // $emailTitle = "Mật khẩu đã được thay đổi thành công";
                // $emailContent = "Xin Chào " . $fullname . " tài khoản của bạn đã được thay đổi mật khẩu thành công! Thông tin tài khoản hiện tại là: Username: " . $username . " Password: " . $newPassword;
                // sendEmail($email, $emailTitle, $emailContent);
                if ($this->_arrParam['type'] == 'save-close')   URL::redirect($this->_moduleName, $this->_controllerName, 'index');
                if ($this->_arrParam['type'] == 'save')         URL::redirect($this->_moduleName, $this->_controllerName, 'resetPassword', ['id' => $id]);
            }
        }

        $this->_view->arrParam = $this->_arrParam;
        $this->_view->render("{$this->_controllerName}/formResetPassword");
    }

    public function ajaxChangeGroupAction()
    {
        $result = $this->_model->changeGroup($this->_arrParam);
        echo json_encode($result);
    }


}
