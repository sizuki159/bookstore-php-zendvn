<?php
class IndexModel extends FrontendModel
{
    protected $_columns = ['id', 'username', 'fullname', 'password','created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'email', 'group_id', 'register_ip', 'register_date'];
    protected $fieldSearchAccepted = ['id', 'name'];

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);
    }

    public function getSlider($params, $option = null)
    {
        if ($option == null) {
            $query[]    = "SELECT `id`, `name`, `picture`, `status`, `ordering`, `description`, `link`";
            $query[]    = "FROM `".TBL_SLIDER."`";
            $query[]    = "WHERE `status` = 'active'";
            $query      = implode(" ", $query);
            $result     = $this->fetchAll($query);
            return $result;
        }
    }

    public function register($params, $option = null)
    {
        $params['form']['password']         = md5($params['form']['password']);
        $params['form']['register_ip']      = $_SERVER['REMOTE_ADDR'];
        $params['form']['register_date']    = date(DB_DATETIME_FORMAT);
        $params['form']['status']           = 'inactive';
        $params['form']['group_id']         = 0;

        $data   = array_intersect_key($params['form'], array_flip($this->_columns));
        $result = $this->insert($data);
        
        return $result;
    }

    public function infoItem($params, $option = null)
    {
        if($option == null)
        {
            $email      = mysqli_real_escape_string($this->connect, $params['form']['email']);
            $password   = md5($params['form']['password']);
            $query[]    = "SELECT `u`.`id`, `u`.`fullname`, `u`.`email`, `u`.`username`, `u`.`group_id`, `g`.`group_acp`, `g`.`privilege_id`";
            $query[]    = "FROM `user` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id`";
            $query[]    = "WHERE `u`.`email` = '$email' AND `u`.`password` = '$password'";

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
    }
}