<?php

$xhtml = '';

if(!empty($this->listItemCategory))
{
    foreach($this->listItemCategory as $item)
    {
        $id = $item['id'];
        $name = $item['name'];
        $nameLink = URL::filterURL($name) . "-$id.html";
        $link = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], 'index', ['category_id' => $id], $nameLink);
        $classActive = (isset($this->arrParam['category_id']) && $this->arrParam['category_id'] == $id) ? 'my-text-primary' : 'text-dark';
        $xhtml .= '
        <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 category-item">
            <a class="'.$classActive.'" href="'.$link.'">'.$name.'</a>
        </div>
        ';
    }
}

?>


<div class="collection-collapse-block open">
    <h3 class="collapse-block-title">Danh mục</h3>
    <div class="collection-collapse-block-content">
        <div class="collection-brand-filter">
            <?php echo $xhtml; ?>
            <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 text-center">
                <span class="text-dark font-weight-bold" id="btn-view-more">Xem thêm</span>
            </div>
        </div>
    </div>
</div>