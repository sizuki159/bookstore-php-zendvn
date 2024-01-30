<?php
class CartController extends BackendController
{
    public function indexAction()
    {
        $this->_view->_title = ucfirst($this->_controllerName) . ' Manager :: List';
        $totalItems                    = $this->_model->countItems($this->_arrParam);
        $configPagination = ['totalItemsPerPage'    => 4, 'pageRange' => 3];
        $this->setPagination($configPagination);
        $this->_view->pagination    = new Pagination($totalItems, $this->_pagination);
        $this->_view->countActive = $this->_model->countItems($this->_arrParam, ['task' => 'count-active']);
        $this->_view->countInactive = $this->_model->countItems($this->_arrParam, ['task' => 'count-inactive']);
        $this->_view->items = $this->_model->listItems($this->_arrParam);
        $this->_view->render($this->_controllerName . '/index');
    }
}