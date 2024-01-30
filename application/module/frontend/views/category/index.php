<?php

$xhtml = '';

if(!empty($this->listItemCategory))
{
    foreach($this->listItemCategory as $item)
    {
        $id     = $item['id'];
        $name = $item['name'];
        $linkPicture = UPLOAD_URL . 'category' . DS . $item['picture'];
        $linkName = URL::filterURL($name) . "-$id.html";
        $link = URL::createLink($this->arrParam['module'], 'book', 'index', ['category_id' => $id], $linkName);
        $xhtml .= '
        <div class="product-box">
                <div class="img-wrapper">
                    <div class="front">
                        <a href="'.$link.'"><img src="'.$linkPicture.'" class="img-fluid blur-up lazyload bg-img" alt=""></a>
                    </div>
                </div>
                <div class="product-detail">
                    <a href="'.$link.'">
                        <h4>'.$name.'</h4>
                    </a>
                </div>
        </div>    
        ';
    }
}

?>

<?php echo HTML::pageHeaderContentFrontend('Danh mục sách'); ?>

<section class="ratio_asos j-box pets-box section-b-space" id="category">
    <div class="container">
        <div class="no-slider five-product row">
            <?php echo $xhtml; ?>
        </div>

        <?php //echo $this->pagination->showPaginationFrontend(); ?>
    </div>
</section>