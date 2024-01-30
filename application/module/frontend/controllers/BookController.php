<?php

class BookController extends FrontendController
{
    public function indexAction()
    {
        $totalItems = $this->_model->countItems($this->_arrParam);
		$configPagination = ['totalItemsPerPage'	=> 8, 'pageRange' => 3];
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);
        $this->_view->totalItem = $configPagination;

        if(!isset($this->_arrParam['category_id']))
        {
            $this->_view->listBookOfCategoryID = $this->_model->getListBook($this->_arrParam);
        }
        else
        {
            $this->_view->listBookOfCategoryID = $this->_model->getListBook($this->_arrParam, ['task' => 'book-of-category_id']);
        }

        $this->_view->setTitle('Danh sách sách');
        $this->_view->render('book/index');
    }

    public function itemAction()
    {

        $infoBook                       = $this->_model->infoItem($this->_arrParam);

        if(!isset($this->_arrParam['id']) || !isset($this->_arrParam['category_id']) || $this->_arrParam['category_id'] != $infoBook['category_id'])
            URL::redirect404();

        $this->_view->infoBook          = $infoBook;
        $this->_view->listBookRelative  = $this->_model->getListBook($this->_arrParam, ['task' => 'book-of-category_id']);
        $this->_view->setTitle('Chi tiết sách');
        $this->_view->render('book/item');

    }
}