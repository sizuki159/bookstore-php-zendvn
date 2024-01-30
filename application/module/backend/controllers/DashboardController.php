<?php
class DashboardController extends Controller
{
	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/adminlte/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function indexAction()
	{
		$this->_view->_title 		= 'Dashboard';
		$this->_view->countGroup 	= $this->_model->countItems($this->_arrParam, ['setTable' => TBL_GROUP]);
		$this->_view->countUser 	= $this->_model->countItems($this->_arrParam, ['setTable' => TBL_USER]);
		$this->_view->countCategory = $this->_model->countItems($this->_arrParam, ['setTable' => TBL_CATEGORY]);
		$this->_view->countBook 	= $this->_model->countItems($this->_arrParam, ['setTable' => TBL_BOOK]);
		$this->_view->countSlider 	= $this->_model->countItems($this->_arrParam, ['setTable' => TBL_SLIDER]);
		$this->_view->countCart 	= $this->_model->countItems($this->_arrParam, ['setTable' => TBL_CART]);
		$this->_view->render('dashboard/index');
	}
}
