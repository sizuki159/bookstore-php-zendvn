<?php

class CategoryController extends FrontendController
{
    public function indexAction()
    {
        $this->_view->render('category/index');
    }
}