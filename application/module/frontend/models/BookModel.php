<?php
class BookModel extends FrontendModel
{
    protected $_columns = ['id', 'username', 'fullname', 'password','created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'email', 'group_id', 'register_ip', 'register_date'];
    protected $fieldSearchAccepted = ['id', 'name'];

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_BOOK);
    }

    public function infoItem($params, $option = null)
    {
        $id = mysqli_real_escape_string($this->connect, $params['id']);

        $query[] = "SELECT *";
        $query[] = "FROM `" . TBL_BOOK . "`";
        $query[] = "WHERE `id` = '{$id}'";
        $query[] = "AND `status` = 'active'";

        $query = implode(' ', $query);
        $result = $this->fetchRow($query);
        return $result;
    }

}