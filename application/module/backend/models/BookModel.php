<?php
class BookModel extends BackendModel
{
    protected $_columns = ['id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'special', 'ordering', 'description', 'price', 'category_id', 'sale_off'];
    protected $fieldSearchAccepted = ['id', 'name', 'ordering', 'status', 'description', 'price', 'category_id', 'sale_off'];

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_BOOK);
    }

    public function listItems($arrParam, $options = null)
    {
        $query[]    = "SELECT `b`.*, `c`.`name` AS `categoryname`";
        $query[]    = "FROM `$this->table` AS `b` LEFT JOIN `" . TBL_CATEGORY . "` AS `c` ON `b`.`category_id` = `c`.`id`";
        $query[]    = "WHERE `b`.`id` > 0";

        // FILTER : KEYWORD
        if (!empty($arrParam['search']))
        {
            $query[] = "AND (";
            $keyword    = "'%{$arrParam['search']}%'";
            foreach ($this->fieldSearchAccepted as $field)
            {
                $query[] = "`b`.`$field` LIKE $keyword";
                $query[] = "OR";
            }
            array_pop($query);
            $query[] = ")";
        }

        // FILTER : CATEGORY ID
        if (isset($arrParam['filter_category_id']) && $arrParam['filter_category_id'] != 'default') {
            $query[] = "AND `b`.`category_id` = '{$arrParam['filter_category_id']}'";
        }
        // FILTER : STATUS
        if (isset($arrParam['status']) && $arrParam['status'] != 'all')
        {
            $query[] = "AND `b`.`status` = '{$arrParam['status']}'";
        }

        $query[]    = "ORDER BY `b`.`id`";

        $pagination            = $arrParam['pagination'];
        $totalItemsPerPage    = $pagination['totalItemsPerPage'];
        if ($totalItemsPerPage > 0)
        {
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
            $query[]    = "SELECT `id`, `name`, `description`, `picture`, `price`, `special`, `sale_off`, `status`, `category_id`";
            $query[]    = "FROM `$this->table`";
            $query[]    = "WHERE `id` = '" . $arrParam['id'] . "'";
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result;
        }
    }

    public function getListCategory($arrParams, $option = null)
	{
		$query[]	= "SELECT `name`, `id`";
		$query[]	= "FROM `category`";
		$query		= implode(' ', $query);
		$result		= $this->fetchAll($query);
		return $result;
    }
    
    public function saveItem($params, $option = null)
    {
        if($option['task'] == 'add')
        {
            $params['form']['created']      = date(DB_DATETIME_FORMAT);
            $params['form']['created_by']   = $this->infoUserLogin['info']['id'];
            $params['form']['description']  = mysqli_real_escape_string($this->connect, $params['form']['description']);

            $data = array_intersect_key($params['form'], array_flip($this->_columns));

            $result = $this->insert($data);
            if ($result) {
                Session::set('notify', Helper::createNotify('success', SUCCESS_ADD));
            } else {
                Session::set('notify', Helper::createNotify('warning', FAIL_ACTION));
            }
            return $result;

        }
        else if($option['task'] == 'edit')
        {
            $params['form']['modified']      = date(DB_DATETIME_FORMAT);
            $params['form']['modified_by']   = $this->infoUserLogin['info']['id'];
            $params['form']['description']   = mysqli_real_escape_string($this->connect, $params['form']['description']);
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

    public function changeCategory($params)
    {
        $id         = $params['id'];
        $categoryId = $params['category_id'];
        $modifiedBy = $this->infoUserLogin['info']['id'];
        $modified   = date(DB_DATETIME_FORMAT, time());
        $query = "UPDATE `$this->table` SET `category_id` = '$categoryId', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
        $this->query($query);
        return [
            'id' => $id,
            'modified'  => HTML::showItemHistory($modifiedBy, $modified),
        ];
    }

}