<?php

class BackendModel extends Model
{
    protected $infoUserLogin;

    public function __construct()
    {
        parent::__construct();
        $this->infoUserLogin = Session::get('user');
    }

    public function countItems($arrParam, $options = null)
    {
        $query[] = "SELECT COUNT(`id`) AS `total`";
        $query[] = "FROM `$this->table`";
        $query[] = "WHERE `id` > 0";
 
        if (isset($arrParam['status']) && $arrParam['status'] != 'all') $query[] = "AND `status` = '{$arrParam['status']}'";
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

        switch($this->getTable())
        {
            case TBL_GROUP:
            {
                if (isset($arrParam['filter_group_acp']) && $arrParam['filter_group_acp'] != 'default')
                {
                    $query[] = "AND `group_acp` = {$arrParam['filter_group_acp']}";
                }
                break;
            }
            case TBL_USER:
            {
                if (isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default')
                {
                    $query[] = "AND `group_id` = {$arrParam['filter_group_id']}";
                }
                break;
            }
            case TBL_BOOK:
            {
                if (isset($arrParam['filter_category_id']) && $arrParam['filter_category_id'] != 'default')
                {
                    $query[] = "AND `category_id` = {$arrParam['filter_category_id']}";
                }
                break;
            }
        }

        if ($options['task'] == 'count-active') {
            $query[] = "AND `status` = 'active'";
        }

        if ($options['task'] == 'count-inactive') {
            $query[] = "AND `status` = 'inactive'";
        }

        $query = implode(' ', $query);

        $result = $this->fetchRow($query)['total'];
        return $result;
    }

    public function changeStatus($arrParam, $options = null)
    {
        if ($options == null) {
            $modifiedBy = $this->infoUserLogin['info']['id'];
            $modified   = date(DB_DATETIME_FORMAT, time());
            $status = $arrParam['status'] == 'inactive' ? 'active' : 'inactive';
            $query = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = {$arrParam['id']}";
            $this->query($query);
        }

        if ($options['task'] == 'active') {
            $ids = $arrParam['checkbox'];
            $ids = implode(',', $ids);
            $ids = "($ids)";
            $modifiedBy = $this->infoUserLogin['info']['id'];
            $modified   = date(DB_DATETIME_FORMAT, time());
            $query = "UPDATE `$this->table` SET `status` = 'active', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` IN $ids";
            $this->query($query);
        }

        if ($options['task'] == 'inactive') {
            $ids = $arrParam['checkbox'];
            $ids = implode(',', $ids);
            $ids = "($ids)";
            $modifiedBy = $this->infoUserLogin['info']['id'];
            $modified   = date(DB_DATETIME_FORMAT, time());
            $query = "UPDATE `$this->table` SET `status` = 'inactive', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` IN $ids";
            $this->query($query);
        }

        if ($options['task'] == 'change-group-acp') {
            $id = $arrParam['id'];
            $groupACP = $arrParam['group_acp'] == 0 ? 1 : 0;
            $modifiedBy = $this->infoUserLogin['info']['id'];
			$modified   = date(DB_DATETIME_FORMAT);
            $query = "UPDATE `$this->table` SET `group_acp` = $groupACP, `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
            $this->query($query);

            return [
                'id'        => $id,
                'state'     => $groupACP,
                'modified'  => HTML::showItemHistory($modifiedBy, $modified),
                'link'      => URL::createLink($arrParam['module'], $arrParam['controller'], 'changeGroupACP', ['id' => $id, 'group_acp' => $groupACP])
            ];
        }

        if ($options['task'] == 'change-book-special') {
            $id = $arrParam['id'];
            $modifiedBy = $this->infoUserLogin['info']['id'];
            $modified   = date(DB_DATETIME_FORMAT);
            
            $special    = $arrParam['special'] == 'inactive' ? 'active' : 'inactive';
            $query = "UPDATE `$this->table` SET `special` = '$special', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = '{$id}'";
            $this->query($query);
            return [
                'id'        => $id,
                'state'     => $special,
                'modified'  => HTML::showItemHistory($modifiedBy, $modified),
                'link'      => URL::createLink($arrParam['module'], $arrParam['controller'], 'changeBookSpecial', ['id' => $id, 'special' => $special])
            ];
        }

        if ($this->affectedRows()) {
            Session::set('notify', Helper::createNotify('success', SUCCESS_CHANGE));
        } else {
            Session::set('notify', Helper::createNotify('warning', FAIL_ACTION));
        }
    }

    public function deleteItems($arrParam, $options = [])
    {
        $ids = [];
        if (isset($arrParam['id'])) $ids = [$arrParam['id']];
        if (isset($arrParam['checkbox'])) $ids = $arrParam['checkbox'];

        $result = $this->delete($ids);

        if ($result) {
            Session::set('notify', Helper::createNotify('success', SUCCESS_DELETE));
        } else {
            Session::set('notify', Helper::createNotify('warning', FAIL_ACTION));
        }
    }

    public function saveItem($params, $options = [])
    {
        if ($options['task'] == 'add') {
            $params['form']['created']      = date(DB_DATETIME_FORMAT);
            $params['form']['created_by']   = $this->infoUserLogin['info']['id'];
            $params['form']['name']         = mysqli_real_escape_string($this->connect, $params['form']['name']);
            $data = array_intersect_key($params['form'], array_flip($this->_columns));

            if(isset($options['table']) && $options['table'] == 'user')
                $data['password'] = md5($data['password']);
                
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

    public function changeOrdering($params, $options = [])
    {
        $id         = $params['id'];
        $ordering   = $params['ordering'];
        $modifiedBy = $this->infoUserLogin['info']['id'];
        $modified   = date(DB_DATETIME_FORMAT, time());
        $query      = "UPDATE `$this->table` SET `ordering` = '$ordering', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
        $this->query($query);
        return [
            'id' => $id,
            'modified'  => HTML::showItemHistory($modifiedBy, $modified)
        ];
    }
}
