<?php
class UserModel extends FrontendModel
{
    protected $_columns = ['id', 'username', 'fullname', 'password', 'address', 'phone', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'email', 'group_id', 'register_ip', 'register_date'];
    protected $fieldSearchAccepted = ['id', 'name'];

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);
    }
    
    public function infoAccount($params, $option = null)
    {
        $id = $this->infoUserLogin['info']['id'];

        $query[] = "SELECT `username`, `email`, `fullname`, `address`, `phone`";
        $query[] = "FROM `$this->table`";
        $query[] = "WHERE `id` = '{$id}'";
        $query   = implode(" ", $query);
        
        $result     = $this->fetchRow($query);
        return $result;
    }

    public function getOrderHistory($username)
    {
        $query[] = "SELECT *";
        $query[] = "FROM `" . TBL_CART . "`";
        $query[] = "WHERE `username` = '$username'";
        $query   = implode(" ", $query);
        $result  = $this->fetchAll($query);
        return $result;
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

    public function saveInfoProfile($params, $option = null)
    {
        $id         = $this->infoUserLogin['info']['id'];

        $params['form']['modified']     = date(DB_DATETIME_FORMAT);
        $params['form']['modified_by']  = $id;
        $params['form']['fullname']     = mysqli_real_escape_string($this->connect, $params['form']['fullname']);
        $params['form']['address']      = mysqli_real_escape_string($this->connect, $params['form']['address']);
        unset($params['form']['email'], $params['form']['username'], $params['form']['id']);
        $data = array_intersect_key($params['form'], array_flip($this->_columns));
        $result = $this->update($data, [['id', $id]]);
        // if ($result) {
        //     Session::set('notify', Helper::createNotify('success', SUCCESS_EDIT));
        // } else {
        //     Session::set('notify', Helper::createNotify('warning', FAIL_ACTION));
        // }
    }

    public function buyItem($params, $option = null)
    {
        $cart = Session::get('cart');
        $infoBookOfListCart     = $this->infoBook($this->_arrParam, ['task' => 'in-ids', 'data' => ['ids' => array_keys($cart['quantity'])]]);

        $id         = $this->randomString(12);
        $username   = $this->infoUserLogin['info']['username'];
        $books      = [];
        $prices     = [];
        $quantities = [];
        $names      = [];
        $pictures   = [];
        foreach($cart['quantity'] as $bookID => $quantity)
        {
            $books[]        = $bookID;
            $quantities[]   = $quantity;
            $prices[]       = $infoBookOfListCart[$bookID]['price'] * (1-($infoBookOfListCart[$bookID]['sale_off']/100));
            $names[]        = $infoBookOfListCart[$bookID]['name'];
            $pictures[]     = $infoBookOfListCart[$bookID]['picture'];
        }
        $books      = json_encode($books);
        $prices     = json_encode($prices);
        $quantities = json_encode($quantities);
        $names      = json_encode($names);
        $pictures   = json_encode($pictures);
        $time       = date('Y-m-d H:i:s', time());

        $query[] = "INSERT INTO";
        $query[] = "`" . TBL_CART . "`";
        $query[] = "(`id`, `username`, `books`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`)";
        $query[] = "VALUES ('$id', '$username', '$books', '$prices', '$quantities', '$names', '$pictures', 'pending', '$time')";
        $query   = implode(' ', $query);
        $this->query($query);
        return $this->affectedRows();
    }

    private function randomString($length = 5)
	{

		$arrCharacter = array_merge(range('a', 'z'), range(0, 9), range('A', 'Z'));
		$arrCharacter = implode('', $arrCharacter);
		$arrCharacter = str_shuffle($arrCharacter);

		$result		= substr($arrCharacter, 0, $length);
		return $result;
	}

    public function infoBook($params, $option = null)
    {
        if($option == null)
        {
            $id = mysqli_real_escape_string($this->connect, $params['book_id']);
            $query[] = "SELECT `price`, `sale_off`";
            $query[] = "FROM `" . TBL_BOOK . "`";
            $query[] = "WHERE `id` = '{$id}'";
            $query[] = "AND `status` = 'active'";
    
            $query = implode(' ', $query);
            $result = $this->fetchRow($query);
            return $result;
        }
        else if($option['task'] == 'in-ids')
        {
            $ids = '';
            foreach($option['data']['ids'] as $id)
            {
                if(is_numeric($id))
                {
                    $ids .= "$id, ";
                }
            }
            $ids .= '0';

            $query[] = "SELECT `id`, `name`, `picture`, `category_id`, `price`, `sale_off`";
            $query[] = "FROM `" . TBL_BOOK . "`";
            $query[] = "WHERE `id` IN(" . $ids . ")";
            $query[] = "AND `status` = 'active'";

            $query  = implode(' ', $query);
            $temp = $this->fetchAll($query);
            $result = [];
            if(!empty($temp))
            {
                foreach($temp as $book)
                {
                    $result[$book['id']] = $book;
                    unset($result[$book['id']]['id']);
                }
            }
            unset($temp);
            return $result;
        }
    }
}
