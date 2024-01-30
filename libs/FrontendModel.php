<?php

class FrontendModel extends Model
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
        $query[] = "AND `status` = 'active'";

        if(isset($arrParam['category_id']) && is_numeric($arrParam['category_id']))
        {
            $category = $arrParam['category_id'];
            $query[] = "AND `category_id` = '$category'";
        }

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

        $query = implode(' ', $query);
        $result = $this->fetchRow($query)['total'];
        return $result;
    }

    protected function getNameCategory($categoryID)
    {
        $query[]    = "SELECT `name`";
        $query[]	= "FROM `" . TBL_CATEGORY . "`";
        $query[]	= "WHERE `id` = '$categoryID'";
        $query		= implode(' ', $query);
        $result		= $this->fetchRow($query);
        $result		= implode('', $result);
        return $result;
    }

    public function getListCategory($params = null, $option = null)
	{
        if($option == null)
        {
            $query[]	= "SELECT *";
            $query[]	= "FROM `" . TBL_CATEGORY . "`";
            $query[]	= "WHERE `status` = 'active'";
            $query		= implode(' ', $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
        else if($option['special'])
        {
            $query[]	= "SELECT *";
            $query[]	= "FROM `" . TBL_CATEGORY . "`";
            $query[]	= "WHERE `special` = 'active'";
            $query[]	= "AND `status` = 'active'";
            $query		= implode(' ', $query);
            $result		= $this->fetchAll($query);
            return $result;
        }
    }

    public function getListBook($params, $option = null)
    {
        if($option == null)
        {
            $query[]	= "SELECT *";
            $query[]	= "FROM `" . TBL_BOOK . "`";
            $query[]	= "WHERE `status` = 'active'";

            $pagination            = $params['pagination'];
            $totalItemsPerPage    = $pagination['totalItemsPerPage'];
            if ($totalItemsPerPage > 0) {   
                $position    = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
                $query[]    = "LIMIT $position, $totalItemsPerPage";
            }
            
            $query		= implode(' ', $query);
            $result		= $this->fetchAll($query);

            // PhẦN XỬ LÝ TẠM - PHẢI ĐỔI THÀNH JOIN 2 BẢNG LẠI VỚI NHAU
            if(!empty($result))
            {
                foreach($result as $key => $value)
                {
                    $result[$key]['category_name']= $this->getNameCategory($result[$key]['category_id']);
                }
            }
            return $result;
        }
        else if($option['special'])
        {
            $query[]	= "SELECT *";
            $query[]	= "FROM `" . TBL_BOOK . "`";
            $query[]	= "WHERE `special` = 'active'";
            $query[]	= "AND `status` = 'active'";
            $query		= implode(' ', $query);
            $result		= $this->fetchAll($query);

            // PhẦN XỬ LÝ TẠM - PHẢI ĐỔI THÀNH JOIN 2 BẢNG LẠI VỚI NHAU
            if(!empty($result))
            {
                foreach($result as $key => $value)
                {
                    $result[$key]['category_name']= $this->getNameCategory($result[$key]['category_id']);
                }
            }
            return $result;
        }
        else if($option['task'] == 'book-of-category-special')
        {
            $listCategorySpecial    = $this->getListCategory(null, ['special' => true]);
            $arrCategorySpecial   = [];
            foreach($listCategorySpecial as $category)
            {
                $arrCategorySpecial[] = ['id' => $category['id'], 'name' => $category['name']];
            }
            $arrTemp = $arrCategorySpecial;
            if(!empty($arrTemp))
            {
                foreach($arrTemp as $key => $item)
                {
                    $query      = array();
                    $query[]    = "SELECT *";
                    $query[]	= "FROM `" . TBL_BOOK . "`";
                    $query[]	= "WHERE `category_id` = '{$item['id']}'";
                    $query[]	= "AND `status` = 'active'";
                    $query		= implode(' ', $query);
                    $temp		= $this->fetchAll($query);
                    $arrCategorySpecial[$key]['listBook'] = $temp;

                    //PhẦN XỬ LÝ TẠM - PHẢI ĐỔI THÀNH JOIN 2 BẢNG LẠI VỚI NHAU
                    if(!empty($arrCategorySpecial[$key]['listBook']))
                    {
                        foreach($arrCategorySpecial[$key]['listBook'] as $indexBook => $value)
                        {
                            $arrCategorySpecial[$key]['listBook'][$indexBook]['category_name'] = $arrCategorySpecial[$key]['name'];
                        }
                    }
                }
            }
            unset($arrTemp);

            return $arrCategorySpecial;
        }
        else if($option['task'] == 'book-of-category_id')
        {
            $categoryID = isset($params['category_id']) ? $params['category_id'] : 1;
            $query[]    = "SELECT *";
            $query[]	= "FROM `" . TBL_BOOK . "`";
            $query[]	= "WHERE `category_id` = '{$categoryID}'";
            $query[]	= "AND `status` = 'active'";
            if(isset($params['id']))
            {
                $query[]	= "AND `id` <> '{$params['id']}'";
            }

            $pagination            = $params['pagination'];
            $totalItemsPerPage     = $pagination['totalItemsPerPage'];
            if ($totalItemsPerPage > 0) {   
                $position    = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
                $query[]    = "LIMIT $position, $totalItemsPerPage";
            }

            $query		= implode(' ', $query);
            $result		= $this->fetchAll($query);

            // PhẦN XỬ LÝ TẠM - PHẢI ĐỔI THÀNH JOIN 2 BẢNG LẠI VỚI NHAU
            if(!empty($result))
            {
                foreach($result as $key => $value)
                {
                    $result[$key]['category_name']= $this->getNameCategory($result[$key]['category_id']);
                }
            }

            return $result;
        }
        else if($option['task'] == 'book-new')
        {
            $query[]    = "SELECT *";
            $query[]	= "FROM `" . TBL_BOOK . "`";
            $query[]	= "WHERE `created` + " . TIME_BOOK_NEW . " > " . time();
            $query[]	= "AND `status` = 'active'";
            echo $query		= implode(' ', $query);
            $result		= $this->fetchAll($query);

            return $result;
        }
        else if($option['task'] == 'info-book')
        {
            $query[]    = "SELECT *";
            $query[]	= "FROM `" . TBL_BOOK . "`";
            $query[]	= "WHERE `id` = '{$params['id']}'";
            $query[]	= "AND `status` = 'active'";
            $query		= implode(' ', $query);
            $result		= $this->fetchRow($query);
            $result['price_format'] = HTML::formatCurrency($result['price']*(1 - ($result['sale_off']/100))) . ' <del>'.HTML::formatCurrency($result['price']).'</del>';
            $result['picture']      = UPLOAD_URL . 'book' . DS . $result['picture'];
            $result['linkDetail']   = URL::createLink('frontend', 'book', 'item', ['category_id' => $result['category_id'], 'id' => $result['id']]);
            $result['linkBuy']      = URL::createLink('frontend', 'user', 'order', ['book_id' => $result['id']]);

            // PhẦN XỬ LÝ TẠM - PHẢI ĐỔI THÀNH JOIN 2 BẢNG LẠI VỚI NHAU
            $result['category_name']= $this->getNameCategory($result['category_id']);

            return $result;
        }
    }
    
}