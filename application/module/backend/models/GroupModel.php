<?php
class GroupModel extends BackendModel
{
    protected $_columns = ['id', 'name', 'group_acp', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering'];
    protected $fieldSearchAccepted = ['id', 'name'];

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_GROUP);
    }

    public function listItems($arrParam, $options = null)
    {
        $query[]    = "SELECT `id`, `name`, `group_acp`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by`";
        $query[]    = "FROM `$this->table`";
        $query[]    = "WHERE `id` > 0";

        // FILTER : KEYWORD
        if (!empty($arrParam['search'])) {
            $query[] = "AND (";
            $keyword    = "'%{$arrParam['search']}%'";
            foreach ($this->fieldSearchAccepted as $field) {
                $query[] = "`$field` LIKE $keyword";
                $query[] = "OR";
            }
            array_pop($query);
            $query[] = ")";
        }

        // FILTER : GROUP ACP
        if (isset($arrParam['filter_group_acp']) && $arrParam['filter_group_acp'] != 'default') {
            $query[] = "AND `group_acp` = {$arrParam['filter_group_acp']}";
        }

        // FILTER : STATUS
        if (isset($arrParam['status']) && $arrParam['status'] != 'all') {
            $query[] = "AND `status` = '{$arrParam['status']}'";
        }

        $query[]    = "ORDER BY `id`";

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

    public function infoItem($arrParam, $option = null)
    {
        if ($option == null) {
            $query[]    = "SELECT `id`, `name`, `group_acp`, `status`";
            $query[]    = "FROM `$this->table`";
            $query[]    = "WHERE `id` = '" . $arrParam['id'] . "'";
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result;
        }
    }
}
