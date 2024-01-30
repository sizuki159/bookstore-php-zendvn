<?php

class FrontendController extends Controller
{
    protected $infoUserLogin;

    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('frontend/main/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
        $this->_moduleName      = $this->_arrParam['module'];
        $this->_controllerName  = $this->_arrParam['controller'];

        if( (isset($this->_arrParam['id']) && !is_numeric($this->_arrParam['id'])) || (isset($this->_arrParam['category_id']) && !is_numeric($this->_arrParam['category_id'])) )
                URL::redirect404();

        $this->infoUserLogin    = Session::get('user');
        $this->_view->infoUserLogin         = $this->infoUserLogin;


        $this->_view->listItemCategory              = $this->listItemCategory               = $this->_model->getListCategory($this->_arrParam);
        $this->_view->listItemCategorySpecial       = $this->listItemCategorySpecial        = $this->_model->getListCategory($this->_arrParam, ['special' => true]);
        $this->_view->listItemBookSpecial           = $this->listItemBookSpecial            = $this->_model->getListBook($this->_arrParam, ['special' => true]);
        $this->_view->totalCart                     = array_sum(Session::get('cart')['quantity']);
    }

    public function quickViewAction()
    {
        $result = $this->_model->getListBook($this->_arrParam, ['task' => 'info-book']);
        $result['linkDetail'] = URL::filterURL($result['category_name']) . DS . URL::filterURL($result['name']) . "-{$result['category_id']}-{$result['id']}.html";
        echo json_encode($result);
    }
}
