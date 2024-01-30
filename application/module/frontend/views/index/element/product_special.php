<?php
$xhtml = '';
if(!empty($this->listBookSpecial))
{
    foreach($this->listBookSpecial as $item)
    {
        $xhtml .= HTML::showProductFrontend($item);
    }
}

?>

<div class="title1 section-t-space title5">
    <h2 class="title-inner1">Sản phẩm nổi bật</h2>
    <hr role="tournament6">
</div>
<!-- Product slider -->
<section class="section-b-space p-t-0 j-box ratio_asos">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="product-4 product-m no-arrow">
                    <?php echo $xhtml; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product slider end -->
