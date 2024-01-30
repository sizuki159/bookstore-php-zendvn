<?php

class BackendController extends Controller
{
    protected $infoUserLogin;

    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('admin/adminlte/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
        $this->_moduleName      = $this->_arrParam['module'];
        $this->_controllerName  = $this->_arrParam['controller'];
        $this->infoUserLogin    = Session::get('user');
    }
    public function changeStatusAction()
	{
		$this->_model->changeStatus($this->_arrParam);
		URL::redirect($this->_moduleName, $this->_controllerName, 'index');
    }
    
    public function deleteAction()
	{
		$this->_model->deleteItems($this->_arrParam);
		URL::redirect($this->_moduleName, $this->_controllerName, 'index');
    }
    
    public function activeAction()
	{
		$this->_model->changeStatus($this->_arrParam, ['task' => 'active']);
		URL::redirect($this->_moduleName, $this->_controllerName, 'index');
	}

	public function inactiveAction()
	{
		$this->_model->changeStatus($this->_arrParam, ['task' => 'inactive']);
		URL::redirect($this->_moduleName, $this->_controllerName, 'index');
    }
    
    public function ajaxOrderingAction()
    {
        $result = $this->_model->changeOrdering($this->_arrParam);
        echo json_encode($result);
    }
}

?>