<?php
class SliderController extends BackendController
{
    public function indexAction()
    {
        $this->_view->_title = ucfirst($this->_controllerName) . ' Manager :: List';
        $totalItems                    = $this->_model->countItems($this->_arrParam);

        $configPagination = ['totalItemsPerPage'    => 5, 'pageRange' => 3];
        $this->setPagination($configPagination);
        $this->_view->pagination    = new Pagination($totalItems, $this->_pagination);
        $this->_view->countActive = $this->_model->countItems($this->_arrParam, ['task' => 'count-active']);
        $this->_view->countInactive = $this->_model->countItems($this->_arrParam, ['task' => 'count-inactive']);
        $this->_view->items = $this->_model->listItems($this->_arrParam);
        $this->_view->render($this->_controllerName . '/index');
    }

    public function formAction()
    {
        $this->_view->_title = ucfirst($this->_controllerName) . ' Manager :: Add';
        if (isset($this->_arrParam['id']) && !isset($this->_arrParam['form']['token'])) {
            $this->_view->_title = ucfirst($this->_controllerName) . ' Manager :: Edit';
            $this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
            if (empty($this->_arrParam['form'])) URL::redirect($this->_moduleName, $this->_controllerName, 'index');
        }

        if (isset($this->_arrParam['form']['token'])) {
            $fileCurrent = $this->_arrParam['form']['file_current'];

            $isUploadFile = false;
            if ($_FILES['picture']['name'] != null && $_FILES['picture']['type'] != null && $_FILES['picture']['size'] != null) {
                $isUploadFile = true;
                require_once LIBRARY_PATH . 'extends/Upload.php';
                $uploadObj = new Upload();
            }

            $this->_validate->validate();
            $this->_arrParam['form'] = $this->_validate->getResult();

            if (!$this->_validate->isValid()) {
                $this->_view->errors = $this->_validate->showErrorsAdmin();
            } else {
                $task = isset($this->_arrParam['form']['id']) ? 'edit' : 'add';
                if ($isUploadFile) {
                    if ($task == 'edit' && $fileCurrent != null) {
                        $uploadObj->removeFile($this->_controllerName, $fileCurrent);
                    }
                    $fileName = $uploadObj->uploadFile($_FILES['picture'], $this->_controllerName, 60, 90);
                    $this->_arrParam['form']['picture'] = $fileName;
                }
                
                $id = $this->_model->saveItem($this->_arrParam, ['task' => $task]);
                if ($this->_arrParam['type'] == 'save-close')   URL::redirect($this->_moduleName, $this->_controllerName, 'index');
                if ($this->_arrParam['type'] == 'save-new')     URL::redirect($this->_moduleName, $this->_controllerName, 'form');
                if ($this->_arrParam['type'] == 'save')         URL::redirect($this->_moduleName, $this->_controllerName, 'form', ['id' => $id]);
            }
        }

        $this->_view->arrParam = $this->_arrParam;
        $this->_view->render("{$this->_controllerName}/form");
    }
}