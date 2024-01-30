<?php
class DashboardModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_GROUP);
    }

    public function countItems($params, $options = [])
    {
        if(isset($options['setTable']) && $options['setTable'] != null)
        {
            $this->setTable($options['setTable']);
        }

        // switch($options['setTable'])
        // {
        //     case TBL_GROUP:
        //     {
        //         $this->setTable(TBL_GROUP);
        //         break;
        //     }
        //     case TBL_USER:
        //     {
        //         $this->setTable(TBL_USER);
        //         break;
        //     }
        //     case TBL_CATEGORY:
        //     {
        //         $this->setTable(TBL_CATEGORY);
        //         break;
        //     }
        //     case TBL_BOOK:
        //     {
        //         $this->setTable(TBL_BOOK);
        //         break;
        //     }
        // }

        $result = 0;
        $query[] = "SELECT COUNT(`id`) AS `total`";
        
        if ($options['task'] == 'group') $this->setTable(TBL_GROUP);
        
        $query[] = "FROM `$this->table`";
        $query = implode(' ', $query);
        
        $result = $this->fetchRow($query)['total'];
        return $result;
    }
}
