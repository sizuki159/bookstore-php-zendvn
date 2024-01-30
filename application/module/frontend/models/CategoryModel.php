<?php
class CategoryModel extends FrontendModel
{
    protected $_columns = ['id', 'username', 'fullname', 'password','created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'email', 'group_id', 'register_ip', 'register_date'];
    protected $fieldSearchAccepted = ['id', 'name'];

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_CATEGORY);
    }
}