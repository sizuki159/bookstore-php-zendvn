<?php
class UserModel extends BackendModel
{
    protected $_columns = ['id', 'username', 'group_id', 'created', 'created_by', 'modified', 'modified_by', 'status', 'email', 'password', 'fullname'];
    protected $fieldSearchAccepted = ['id', 'fullname'];

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);
    }

    public function listItems($arrParam, $options = null)
    {
        $query[]    = "SELECT `u`.`id`, `u`.`username`, `u`.`group_id`, `u`.`email`, `u`.`fullname`, `u`.`status`, `u`.`ordering`, `u`.`created`, `u`.`created_by`, `u`.`modified`, `u`.`modified_by`, `g`.`name` AS `groupname`";
        $query[]    = "FROM `$this->table` AS `u` LEFT JOIN `" . TBL_GROUP . "` AS `g` ON `u`.`group_id` = `g`.`id`";
        $query[]    = "WHERE `u`.`id` > 0";
        $query[]    = "AND `u`.`id` <> '{$this->infoUserLogin['info']['id']}'";

        // FILTER : KEYWORD
        if (!empty($arrParam['search'])) {
            $query[] = "AND (";
            $keyword    = "'%{$arrParam['search']}%'";
            foreach ($this->fieldSearchAccepted as $field) {
                $query[] = "`u`.`$field` LIKE $keyword";
                $query[] = "OR";
            }
            array_pop($query);
            $query[] = ")";
        }

        // FILTER : GROUP ID
        if (isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default') {
            $query[] = "AND `u`.`group_id` = '{$arrParam['filter_group_id']}'";
        }

        // FILTER : STATUS
        if (isset($arrParam['status']) && $arrParam['status'] != 'all') {
            $query[] = "AND `u`.`status` = '{$arrParam['status']}'";
        }

        $query[]    = "ORDER BY `u`.`id` ASC";

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

    public function getListGroup($arrParams, $option = null)
	{
		$query[]	= "SELECT `name`, `id`";
		$query[]	= "FROM `group`";
		$query		= implode(' ', $query);
		$result		= $this->fetchAll($query);
		return $result;
    }
    
    public function infoItem($arrParam, $option = null)
    {
        if ($option == null) {
            $query[]    = "SELECT `id`, `username`, `email`, `status`, `fullname`, `group_id`";
            $query[]    = "FROM `$this->table`";
            $query[]    = "WHERE `id` = '" . $arrParam['id'] . "'";
            $query        = implode(" ", $query);
            $result        = $this->fetchRow($query);
            return $result;
        }
    }

    public function updatePassword($arrParam, $option = null)
    {
        $newPassword            = md5($arrParam['form']['new_password']);
        $data['password']       = $newPassword;
        $data['modified']       = date(DB_DATETIME_FORMAT);
        $data['modified_by']    = $this->infoUserLogin['info']['id'];
        
        $result = $this->update($data, [['id', $arrParam['id']]]);
        if($result)
            Session::set('notify', Helper::createNotify('success', SUCCESS_CHANGE_PASSWORD));
        else
            Session::set('notify', Helper::createNotify('danger', FAIL_ACTION));

        return $arrParam['id'];
    }

    public function changeGroup($params)
    {
        $id         = $params['id'];
        $groupId    = $params['group_id'];
        $modifiedBy = $this->infoUserLogin['info']['id'];
        $modified   = date(DB_DATETIME_FORMAT, time());
        $query      = "UPDATE `$this->table` SET `group_id` = $groupId, `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
        $this->query($query);
        return [
            'id' => $id,
            'modified'  => HTML::showItemHistory($modifiedBy, $modified),
        ];
    }

}