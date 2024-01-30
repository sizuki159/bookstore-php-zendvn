<?php
class GroupController extends BackendController
{
	public function indexAction()
	{
		$this->_view->_title = ucfirst($this->_controllerName) . ' Manager :: List';
		$totalItems					= $this->_model->countItems($this->_arrParam);

		$configPagination = ['totalItemsPerPage'	=> 10, 'pageRange' => 3];
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);
		$this->_view->countActive = $this->_model->countItems($this->_arrParam, ['task' => 'count-active']);
		$this->_view->countInactive = $this->_model->countItems($this->_arrParam, ['task' => 'count-inactive']);
		$this->_view->items = $this->_model->listItems($this->_arrParam);
		$this->_view->render($this->_controllerName . '/index');
	}

	public function changeGroupACPAction()
	{
		$result = $this->_model->changeStatus($this->_arrParam, ['task' => 'change-group-acp']);
		echo json_encode($result);
		// URL::redirect($this->_moduleName, $this->_controllerName, 'index');
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
			$this->_validate->validate();
			$this->_arrParam['form'] = $this->_validate->getResult();

			if (!$this->_validate->isValid()) {
				$this->_view->errors = $this->_validate->showErrorsAdmin();
			} else {
				$task = isset($this->_arrParam['form']['id']) ? 'edit' : 'add';

				$id = $this->_model->saveItem($this->_arrParam, ['task' => $task, 'table' => 'group']);
				if ($this->_arrParam['type'] == 'save-close')   URL::redirect($this->_moduleName, $this->_controllerName, 'index');
				if ($this->_arrParam['type'] == 'save-new')     URL::redirect($this->_moduleName, $this->_controllerName, 'form');
				if ($this->_arrParam['type'] == 'save')         URL::redirect($this->_moduleName, $this->_controllerName, 'form', ['id' => $id]);
			}
		}

		$this->_view->arrParam = $this->_arrParam;
		$this->_view->render("{$this->_controllerName}/form");
	}
}
