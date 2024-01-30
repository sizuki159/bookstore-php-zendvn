<?php
class IndexModel extends BackendModel
{
    protected $_columns = ['group_id', 'created', 'created_by', 'modified', 'modified_by', 'status', 'email', 'password', 'fullname'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getPassword($userID)
    {
        $query[] = "SELECT `password`";
        $query[] = "FROM `" . TBL_USER . "`";
        $query[] = "WHERE `id` = '$userID'";
        $query   = implode(" ", $query);
        $result  = $this->fetchRow($query);
        return $result['password'];
    }

    public function infoItem($arrParams, $option = null)
    {
        if($option == null)
        {
            $username   = mysqli_real_escape_string($this->connect, $arrParams['form']['username']);
            $password   = md5($arrParams['form']['password']);
            $query[]    = "SELECT `u`.`id`, `u`.`fullname`, `u`.`email`, `u`.`username`, `u`.`group_id`, `g`.`group_acp`, `g`.`privilege_id`";
            $query[]    = "FROM `user` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id`";
            $query[]    = "WHERE `u`.`username` = '$username' AND `u`.`password` = '$password'";

            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);

            if($result['group_acp'] == 1)
            {
                $arrPrivilege = explode(',', $result['privilege_id']);
                $strID = '';
                foreach($arrPrivilege as $privilegeID)
                    $strID .= "'$privilegeID',";
                
                $queryPrivilege[]       = "SELECT `id`, CONCAT(`module`, '-', `controller`, '-', `action`) AS `name`";
                $queryPrivilege[]       = "FROM `". TBL_PRIVELEGE . "` WHERE `id` IN ($strID'0')";
                $queryPrivilege         = implode(' ', $queryPrivilege);
                $result['privilege']    = $this->fetchPairs($queryPrivilege);
            }

            return $result;
        }
        else if($option == 'profile')
        {
            $this->setTable(TBL_USER);
            
            $id         = $this->infoUserLogin['info']['id'];
            $query[]    = "SELECT `email`, `fullname`, `username`, `id`";
            $query[]    = "FROM `$this->table` WHERE `id` = '$id'";
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);

            return $result;
        }
    }

    public function saveInfoProfile($params, $option = null)
    {
        $id         = $this->infoUserLogin['info']['id'];

        $params['form']['modified']     = date(DB_DATETIME_FORMAT);
        $params['form']['modified_by']  = $id;
        $data = array_intersect_key($params['form'], array_flip($this->_columns));
        $result = $this->update($data, [['id', $id]]);
        if ($result) {
            Session::set('notify', Helper::createNotify('success', SUCCESS_EDIT));
        } else {
            Session::set('notify', Helper::createNotify('warning', FAIL_ACTION));
        }
    }
}