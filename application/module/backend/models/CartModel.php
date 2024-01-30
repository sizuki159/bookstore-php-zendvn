<?php
class CartModel extends BackendModel
{
    protected $_columns = ['id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering'];
    protected $fieldSearchAccepted = ['id', 'username', 'status'];

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_CART);
    }

    public function listItems($arrParam, $options = null)
    {
        $query[]    = "SELECT `c`.`id`, `c`.`username`, `c`.`books`, `c`.`prices`, `c`.`quantities`, `c`.`names`, `c`.`status`, `c`.`date`, `u`.`fullname` AS `fullname`, `u`.`address` AS `address`, `u`.`email` AS `email`, `u`.`phone` AS `phone`";
        $query[]    = "FROM `$this->table` AS `c` LEFT JOIN `" . TBL_USER ."` AS `u`";
        $query[]    = "ON `c`.`username` = `u`.`username`";


        $pagination            = $arrParam['pagination'];
        $totalItemsPerPage    = $pagination['totalItemsPerPage'];
        if ($totalItemsPerPage > 0) {
            $position    = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
            $query[]    = "LIMIT $position, $totalItemsPerPage";
        }

        $query      = implode(" ", $query);
        $result     = $this->fetchAll($query);
        return $result;
    }
    
}