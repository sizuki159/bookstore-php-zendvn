<?php
class SliderModel extends BackendModel
{
    protected $_columns = ['id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'link', 'description'];
    protected $fieldSearchAccepted = ['id', 'name', 'ordering', 'status'];

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_SLIDER);
    }

    public function listItems($arrParam, $options = null)
    {
        $query[]    = "SELECT *";
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

    public function saveItem($params, $options = [])
    {
        if ($options['task'] == 'add') {
            $params['form']['created']      = date(DB_DATETIME_FORMAT);
            $params['form']['created_by']   = $this->infoUserLogin['info']['id'];
            $params['form']['name']         = mysqli_real_escape_string($this->connect, $params['form']['name']);

            $data = array_intersect_key($params['form'], array_flip($this->_columns));
            $result = $this->insert($data);
            if ($result) {
                Session::set('notify', Helper::createNotify('success', SUCCESS_ADD));
            } else {
                Session::set('notify', Helper::createNotify('warning', FAIL_ACTION));
            }
            return $result;
        }

        if ($options['task'] == 'edit') {
            $params['form']['modified']     = date(DB_DATETIME_FORMAT);
            $params['form']['modified_by']  = $this->infoUserLogin['info']['id'];
            $params['form']['name']         = mysqli_real_escape_string($this->connect, $params['form']['name']);

            unset($params['form']['id']);
            $data = array_intersect_key($params['form'], array_flip($this->_columns));
            $result = $this->update($data, [['id', $params['id']]]);
            if ($result) {
                Session::set('notify', Helper::createNotify('success', SUCCESS_EDIT));
            } else {
                Session::set('notify', Helper::createNotify('warning', FAIL_ACTION));
            }
            return $params['id'];
        }
    }

    public function infoItem($arrParam, $option = null)
    {
        if ($option == null) {
            $query[]    = "SELECT `id`, `name`, `picture`, `status`, `ordering`, `description`, `link`";
            $query[]    = "FROM `$this->table`";
            $query[]    = "WHERE `id` = '" . $arrParam['id'] . "'";
            $query        = implode(" ", $query);
            $result        = $this->fetchRow($query);
            return $result;
        }
    }
}