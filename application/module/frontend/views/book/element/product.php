<?php

$xhtml = '';
if(!empty($this->listBookOfCategoryID))
{
    foreach($this->listBookOfCategoryID as $item)
    {
        $xhtml .= '<div class="col-xl-3 col-6 col-grid-box">';
        $xhtml .= HTML::showProductFrontend($item);
        $xhtml .= '</div>';
    }
}
else
{
    $xhtml = '<h3 style="text-align: center">Danh sách đang cập nhật</h3>';
}

?>

<div class="product-wrapper-grid" id="my-product-list">
    <div class="row margin-res">
        <?php echo $xhtml; ?>
    </div>
</div>