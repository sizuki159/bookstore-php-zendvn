<?php

$xhtmlCategorySpecial = '';
$xhtmlBookOfCategorySpecial = '';

if (!empty($this->listBookOfCategorySpecial))
{
    foreach($this->listBookOfCategorySpecial as $key => $category)
    {
        $linkReadMore = URL::filterURL($category['name']) . "-{$category['id']}.html";
        $linkReadMore = URL::createLink($this->arrParam['module'], 'book', 'index', ['category_id' => $category['id']], $linkReadMore);
        $strClass   = '';
        $strDefault = '';
        if($key == 0)
        {
            $strClass = 'current';
            $strDefault = 'default';
        }

        $xhtmlCategorySpecial .= '
        <li class="tab-category-'.$category['id'].' '.$strClass.'">
            <a href="tab-category-'.$category['id'].'" class="my-product-tab" data-category="'.$category['id'].'">'.$category['name'].'</a>
        </li>
        ';
        if(!empty($category['listBook']))
        {
            $xhtmlBookOfCategorySpecial .= '
            <div id="tab-category-'.$category['id'].'" class="tab-content '.$strDefault.'">
                <div class="no-slider row tab-content-inside">
            ';
            foreach($category['listBook'] as $book)
            {
                $xhtmlBookOfCategorySpecial .= HTML::showProductFrontend($book);
            }
            $xhtmlBookOfCategorySpecial .= '
                </div>    
                <div class="text-center"><a href="'.$linkReadMore.'" class="btn btn-solid">Xem tất cả</a></div>
            </div>    
            ';
        }
    }

}

?>

<!-- Tab product -->
<div class="title1 section-t-space title5">
    <h2 class="title-inner1">Danh mục nổi bật</h2>
    <hr role="tournament6">
</div>
<section class="p-t-0 j-box ratio_asos">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="theme-tab">
                    <ul class="tabs tab-title">
                        <?php echo $xhtmlCategorySpecial ?>
                    </ul>
                    <div class="tab-content-cls">
                        <?php echo $xhtmlBookOfCategorySpecial ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tab product end -->